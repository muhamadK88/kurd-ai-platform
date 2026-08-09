#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Kurd AI — Automated AI-news pipeline.

Flow
----
    RSS feeds (OpenAI, HuggingFace, DeepMind, X/Twitter via RSSHub, …)
        → full body + lead image        (news-please)
        → fact-check + bilingual rewrite (Gemini 2.5 Pro)
        → POST /api/news/automated-store (Sorani + Badini payload)

Gemini is the quality gate. It must:
  * reject rumours / social leaks / image-less posts,
  * require a self-reported confidence >= 8/10,
  * translate into clean Sorani (کوردیی سۆرانی) AND authentic Badini
    (کوردیی بادینی, Arabic script — never Latin Kurmanji),
  * assign exactly one category and up to three tags.

Environment
-----------
    GEMINI_API_KEY        Google AI Studio key for Gemini 2.5 Pro   (required)
    WEBSITE_API_SECRET    Bearer secret for the ingest endpoint      (required)
    WEBSITE_URL           Site base URL, e.g. https://kurd-ai.com    (required)
    NEWS_MAX_PER_RUN      Cap on articles published per run (default 6)
    NEWS_FEEDS            Comma-separated feed override (optional)

Standard-library logging; every skip reason is printed so a GitHub Actions
run is self-explanatory.
"""

from __future__ import annotations

import json
import os
import sys
import time
from dataclasses import dataclass, field
from datetime import datetime, timezone
from typing import Any, Optional

import feedparser
import requests
from dateutil import parser as date_parser

try:
    # news-please exposes a single-article convenience class.
    from newsplease import NewsPlease
except Exception as exc:  # pragma: no cover - import-time guard
    NewsPlease = None
    _NEWSPLEASE_IMPORT_ERROR = exc

from google import genai
from google.genai import types as genai_types


# --------------------------------------------------------------------------- #
# Configuration
# --------------------------------------------------------------------------- #

GEMINI_MODEL = "gemini-2.5-pro"
MIN_CONFIDENCE = 8
REQUEST_TIMEOUT = 30
MAX_BODY_CHARS = 8000          # keep the Gemini prompt bounded
MAX_PER_RUN = int(os.environ.get("NEWS_MAX_PER_RUN", "6"))
ENTRIES_PER_FEED = int(os.environ.get("NEWS_ENTRIES_PER_FEED", "8"))

# Official / high-signal AI sources. X/Twitter is pulled through RSSHub so we
# still get an author + image and can apply the same fact-check gate.
DEFAULT_FEEDS = [
    "https://openai.com/news/rss.xml",
    "https://huggingface.co/blog/feed.xml",
    "https://deepmind.google/blog/rss.xml",
    "https://blog.google/technology/ai/rss/",
    "https://www.microsoft.com/en-us/research/feed/",
    "https://rsshub.app/twitter/user/OpenAI",
    "https://rsshub.app/twitter/user/GoogleDeepMind",
]

VALID_CATEGORIES = [
    "AI Agents",
    "Image Generation",
    "Finance & Business",
    "LLMs & Base Models",
    "General AI",
]


def log(msg: str) -> None:
    stamp = datetime.now(timezone.utc).strftime("%H:%M:%S")
    print(f"[{stamp}] {msg}", flush=True)


def feeds() -> list[str]:
    override = os.environ.get("NEWS_FEEDS", "").strip()
    if override:
        return [u.strip() for u in override.split(",") if u.strip()]
    return DEFAULT_FEEDS


# --------------------------------------------------------------------------- #
# Data model
# --------------------------------------------------------------------------- #

@dataclass
class Article:
    title: str
    url: str
    body: str = ""
    image_url: str = ""
    published_at: Optional[str] = None   # ISO-8601
    source: str = ""

    def is_complete(self) -> bool:
        """A candidate must have a headline, a usable body and a lead image."""
        return bool(
            self.title.strip()
            and len(self.body.strip()) >= 200
            and self.image_url.strip()
        )


@dataclass
class Translation:
    title_sorani: str
    summary_sorani: str
    title_badini: str
    summary_badini: str
    category: str
    tags: list[str] = field(default_factory=list)
    confidence: int = 0
    approved: bool = False
    reason: str = ""


# --------------------------------------------------------------------------- #
# Stage 1 — collect candidate entries from RSS
# --------------------------------------------------------------------------- #

def collect_entries() -> list[Article]:
    seen_urls: set[str] = set()
    out: list[Article] = []

    for feed_url in feeds():
        try:
            parsed = feedparser.parse(feed_url)
        except Exception as exc:
            log(f"  feed error {feed_url}: {exc}")
            continue

        source = (parsed.feed.get("title") if parsed.feed else "") or feed_url
        entries = parsed.entries[:ENTRIES_PER_FEED]
        log(f"  {len(entries):>2} entries from {source}")

        for entry in entries:
            link = entry.get("link", "").strip()
            if not link or link in seen_urls:
                continue
            seen_urls.add(link)

            published = _entry_datetime(entry)
            out.append(
                Article(
                    title=entry.get("title", "").strip(),
                    url=link,
                    image_url=_entry_image(entry),
                    published_at=published,
                    source=source,
                )
            )

    return out


def _entry_datetime(entry: Any) -> Optional[str]:
    for key in ("published", "updated", "created"):
        if entry.get(key):
            try:
                return date_parser.parse(entry[key]).astimezone(timezone.utc).isoformat()
            except (ValueError, TypeError, OverflowError):
                continue
    return None


def _entry_image(entry: Any) -> str:
    """Best-effort lead image straight from the feed, before news-please."""
    media = entry.get("media_content") or entry.get("media_thumbnail")
    if media and isinstance(media, list):
        url = media[0].get("url", "")
        if url:
            return url
    for link in entry.get("links", []):
        if link.get("type", "").startswith("image/") and link.get("href"):
            return link["href"]
    return ""


# --------------------------------------------------------------------------- #
# Stage 2 — enrich with full body text + high-res lead image
# --------------------------------------------------------------------------- #

def enrich(article: Article) -> Article:
    """Fill in body + best image using news-please, keeping any feed image."""
    if NewsPlease is None:
        log(f"  news-please unavailable ({_NEWSPLEASE_IMPORT_ERROR}); using feed data only")
        return article

    try:
        parsed = NewsPlease.from_url(article.url, timeout=REQUEST_TIMEOUT)
    except Exception as exc:
        log(f"  extract failed ({exc}); using feed data only")
        return article

    if parsed is None:
        return article

    if getattr(parsed, "maintext", None):
        article.body = parsed.maintext.strip()

    # Prefer the high-resolution featured image news-please discovers.
    lead = getattr(parsed, "image_url", None)
    if lead:
        article.image_url = lead

    if not article.published_at and getattr(parsed, "date_publish", None):
        try:
            article.published_at = parsed.date_publish.astimezone(timezone.utc).isoformat()
        except (ValueError, AttributeError, TypeError):
            pass

    return article


def image_is_reachable(url: str) -> bool:
    """A missing/broken image is an automatic reject (task requires an image)."""
    if not url:
        return False
    try:
        resp = requests.head(url, timeout=15, allow_redirects=True)
        if resp.status_code == 405 or "image" not in resp.headers.get("Content-Type", ""):
            # Some CDNs reject HEAD — fall back to a ranged GET.
            resp = requests.get(url, timeout=15, stream=True, headers={"Range": "bytes=0-1024"})
        ctype = resp.headers.get("Content-Type", "")
        return resp.status_code < 400 and ctype.startswith("image")
    except requests.RequestException:
        return False


# --------------------------------------------------------------------------- #
# Stage 3 — Gemini 2.5 Pro: fact-check gate + bilingual rewrite
# --------------------------------------------------------------------------- #

SYSTEM_INSTRUCTION = """\
You are the editor-in-chief and translator for Kurd AI, a Kurdish technology
news platform. You are strict, skeptical, and bilingual.

Your job for each article:
1. FACT-CHECK GATE — set "approved": false and give a short English "reason" if:
   - it is an unverified rumour, leak, or speculation;
   - it originates from an anonymous social-media post with no official source;
   - it has no real accompanying image;
   - your confidence that this is genuine, publishable AI news is below 8/10.
   Otherwise set "approved": true. Always fill "confidence" (0-10 integer).

2. TRANSLATION (only meaningful when approved) — produce clean, natural,
   news-desk Kurdish. Never transliterate English sentences.
   - "sorani": Clean, professional Central Kurdish / Sorani (کوردیی سۆرانی),
     Arabic script.
   - "badini": Authentic Badini (کوردیی بادینی / بادینی) in ARABIC SCRIPT,
     using native Badini vocabulary and grammar (Badini verb endings and
     terms such as: دکەت، هەیە، بۆ، ژ، ب، دێ، هاتیە، ئەڤ، وان، خۆ).
     STRICTLY DO NOT write standard Northern Kurmanji, and DO NOT use Latin
     script. It must read as real Behdini/Badini as spoken in Duhok.
   - The summary must be 2-4 full sentences, faithful to the source, no hype.

3. CATEGORY — choose EXACTLY ONE of:
   "AI Agents", "Image Generation", "Finance & Business",
   "LLMs & Base Models", "General AI".

4. TAGS — an array of up to 3 short English tags (e.g. "Base", "Investment",
   "Update", "Research", "Release"). If the news concerns core foundational
   technology (a base/foundation model, core architecture, training method),
   you MUST include "Base".

Return ONLY a JSON object with these exact keys:
approved, confidence, reason, title_sorani, summary_sorani,
title_badini, summary_badini, category, tags
"""

RESPONSE_SCHEMA = genai_types.Schema(
    type=genai_types.Type.OBJECT,
    required=[
        "approved", "confidence", "reason",
        "title_sorani", "summary_sorani", "title_badini", "summary_badini",
        "category", "tags",
    ],
    properties={
        "approved": genai_types.Schema(type=genai_types.Type.BOOLEAN),
        "confidence": genai_types.Schema(type=genai_types.Type.INTEGER),
        "reason": genai_types.Schema(type=genai_types.Type.STRING),
        "title_sorani": genai_types.Schema(type=genai_types.Type.STRING),
        "summary_sorani": genai_types.Schema(type=genai_types.Type.STRING),
        "title_badini": genai_types.Schema(type=genai_types.Type.STRING),
        "summary_badini": genai_types.Schema(type=genai_types.Type.STRING),
        "category": genai_types.Schema(
            type=genai_types.Type.STRING, enum=VALID_CATEGORIES
        ),
        "tags": genai_types.Schema(
            type=genai_types.Type.ARRAY,
            items=genai_types.Schema(type=genai_types.Type.STRING),
        ),
    },
)


def analyze(client: genai.Client, article: Article) -> Optional[Translation]:
    body = article.body[:MAX_BODY_CHARS]
    prompt = (
        f"SOURCE: {article.source}\n"
        f"URL: {article.url}\n"
        f"HAS_IMAGE: {'yes' if article.image_url else 'no'}\n"
        f"IMAGE_URL: {article.image_url}\n\n"
        f"HEADLINE:\n{article.title}\n\n"
        f"BODY:\n{body}\n"
    )

    try:
        response = client.models.generate_content(
            model=GEMINI_MODEL,
            contents=prompt,
            config=genai_types.GenerateContentConfig(
                system_instruction=SYSTEM_INSTRUCTION,
                temperature=0.3,
                response_mime_type="application/json",
                response_schema=RESPONSE_SCHEMA,
            ),
        )
    except Exception as exc:
        log(f"  Gemini error: {exc}")
        return None

    raw = (response.text or "").strip()
    if not raw:
        log("  Gemini returned empty response")
        return None

    try:
        data = json.loads(raw)
    except json.JSONDecodeError:
        log("  Gemini returned non-JSON; skipping")
        return None

    category = data.get("category", "General AI")
    if category not in VALID_CATEGORIES:
        category = "General AI"

    tags = [str(t).strip() for t in (data.get("tags") or []) if str(t).strip()][:3]

    return Translation(
        title_sorani=data.get("title_sorani", "").strip(),
        summary_sorani=data.get("summary_sorani", "").strip(),
        title_badini=data.get("title_badini", "").strip(),
        summary_badini=data.get("summary_badini", "").strip(),
        category=category,
        tags=tags,
        confidence=int(data.get("confidence", 0) or 0),
        approved=bool(data.get("approved", False)),
        reason=data.get("reason", "").strip(),
    )


# --------------------------------------------------------------------------- #
# Stage 4 — deliver to the website
# --------------------------------------------------------------------------- #

def publish(payload: dict[str, Any], website_url: str, api_secret: str) -> bool:
    endpoint = website_url.rstrip("/") + "/api/news/automated-store"
    headers = {
        "Authorization": f"Bearer {api_secret}",
        "Content-Type": "application/json",
        "User-Agent": "KurdAI-NewsPipeline/1.0",
    }
    try:
        resp = requests.post(endpoint, json=payload, headers=headers, timeout=REQUEST_TIMEOUT)
    except requests.RequestException as exc:
        log(f"  publish request failed: {exc}")
        return False

    if resp.status_code in (200, 201):
        log(f"  ✓ published (HTTP {resp.status_code})")
        return True

    log(f"  ✗ publish rejected: HTTP {resp.status_code} — {resp.text[:300]}")
    return False


# --------------------------------------------------------------------------- #
# Main run
# --------------------------------------------------------------------------- #

def main() -> int:
    gemini_key = os.environ.get("GEMINI_API_KEY", "").strip()
    api_secret = os.environ.get("WEBSITE_API_SECRET", "").strip()
    website_url = os.environ.get("WEBSITE_URL", "").strip()

    if not (gemini_key and api_secret and website_url):
        log("Missing environment: need GEMINI_API_KEY, WEBSITE_API_SECRET, WEBSITE_URL")
        return 2

    log(f"Feeds: {', '.join(feeds())}")
    candidates = collect_entries()
    log(f"{len(candidates)} candidate entries collected")

    client = genai.Client(api_key=gemini_key)
    published = 0
    skipped = 0
    failed = 0

    for article in candidates:
        if published >= MAX_PER_RUN:
            log(f"Reached per-run cap ({MAX_PER_RUN}); stopping.")
            break

        if not article.is_complete():
            log(f"  SKIP (incomplete) {article.title[:60]} — no title/body/image")
            skipped += 1
            continue

        log(f"> {article.title[:70]}")
        article = enrich(article)
        log(f"  image: {article.image_url[:80] or '(none)'}")

        if not image_is_reachable(article.image_url):
            log("  SKIP (image unreachable) — the task requires a working image")
            skipped += 1
            continue

        verdict = analyze(client, article)
        if verdict is None:
            failed += 1
            continue

        if not verdict.approved or verdict.confidence < MIN_CONFIDENCE:
            log(f"  REJECT (confidence {verdict.confidence}/10): {verdict.reason}")
            skipped += 1
            continue

        payload = {
            "title_sorani": verdict.title_sorani,
            "summary_sorani": verdict.summary_sorani,
            "title_badini": verdict.title_badini,
            "summary_badini": verdict.summary_badini,
            "image_url": article.image_url,
            "source_url": article.url,
            "published_at": article.published_at or datetime.now(timezone.utc).isoformat(),
            "category": verdict.category,
            "tags": verdict.tags,
            "confidence_score": verdict.confidence,
        }

        if publish(payload, website_url, api_secret):
            published += 1
        else:
            failed += 1

        time.sleep(1)  # be polite to the site + the Gemini rate limit

    log(
        f"Done: {published} published, {skipped} skipped/rejected, "
        f"{failed} failed."
    )
    return 0


if __name__ == "__main__":
    sys.exit(main())

