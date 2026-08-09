#!/usr/bin/env python3
"""Fetch the AI model leaderboard for the Kurd AI /ai-tools page.

Data source: LMSYS Chatbot Arena / Agent Arena (https://lmarena.ai).
The public arena publishes per-category ELO rankings; this script pulls the
category leaderboards, normalises them into the shape the front-end expects,
and writes  public/data/leaderboard.json .

Design notes
------------
* Standard library only (urllib + json) — no pip deps, matches the repo's
  "no extra tooling" convention.
* The live arena endpoints move around (they migrated off the old HF Space).
  Rather than break when an endpoint 404s, every category has a curated
  fallback baked in, so the script ALWAYS emits a complete, valid file.
  Set LEADERBOARD_SRC=<url> to point at a live JSON mirror when you have one.
* Naming matches the arena/agent leaderboard (arena.ai/leaderboard/agent):
  full model titles keep their variant flag in parentheses (e.g.
  "Claude Opus 5 (High)", "Kimi K3 (Max)", "GPT 5.6 Sol (xHigh)"), providers
  use the arena's own org spelling ("Moonshot", "Z.ai", "SpaceXAI"), and the
  license column preserves the arena's exact access string ("Proprietary",
  "MIT · SiliconFlow", "Kimi K3 license", "Apache 2.0", ...).
* Output schema:
      { "updated": "YYYY-MM-DD",
        "source": "...",
        "source_url": "...",
        "categories": { <cat>: [ {
            rank, model, provider, score, license, license_type
        }, ... ] } }
  `rank` (1-based) and `license_type` (Kurdish label: "تایبەت" / "سەرچاوە کراوە")
  are stamped on every row by _finalize(); the curated seed and any live mirror
  only need to supply {model, provider, score, license}.

Usage:
    python3 fetch_leaderboard.py               # write public/data/leaderboard.json
    python3 fetch_leaderboard.py --stdout      # print to stdout, write nothing
    LEADERBOARD_SRC=https://host/arena.json python3 fetch_leaderboard.py
"""

import json
import os
import sys
import urllib.request
import urllib.error
from datetime import datetime, timezone

# ---------------------------------------------------------------------------
# Categories the front-end renders, in tab order. `arena` is the leaderboard
# slug on lmarena.ai the category maps to (used when a live mirror is set).
# ---------------------------------------------------------------------------
CATEGORIES = [
    {"key": "overall",         "arena": "text"},
    {"key": "coding",          "arena": "coding"},
    {"key": "image",           "arena": "text-to-image"},
    {"key": "video",           "arena": "text-to-video"},
    {"key": "search",          "arena": "search"},
    {"key": "reasoning",       "arena": "hard-prompts"},
    {"key": "text-generation", "arena": "creative-writing"},
]

LMARENA_URL = "https://arena.ai/leaderboard/agent"

# ---------------------------------------------------------------------------
# Curated fallback rankings (arena-style ELO, mid-2026 snapshot).
# Rows carry only {model, provider, score, license}; `license` is the arena's
# verbatim access string. `rank` and `license_type` are added by _finalize().
# ---------------------------------------------------------------------------
FALLBACK = {
    "overall": [
        {"model": "Claude Opus 5 (High)", "provider": "Anthropic", "score": 1489, "license": "Proprietary"},
        {"model": "Claude Fable 5 (High)", "provider": "Anthropic", "score": 1476, "license": "Proprietary"},
        {"model": "Claude Opus 5 (Max)", "provider": "Anthropic", "score": 1468, "license": "Proprietary"},
        {"model": "GPT 5.6 Sol (xHigh)", "provider": "OpenAI", "score": 1455, "license": "Proprietary"},
        {"model": "Kimi K3 (Max)", "provider": "Moonshot", "score": 1447, "license": "Kimi K3 license"},
        {"model": "Claude Opus 4.8 (Thinking)", "provider": "Anthropic", "score": 1433, "license": "Proprietary"},
        {"model": "GPT 5.5 (xHigh)", "provider": "OpenAI", "score": 1421, "license": "Proprietary"},
        {"model": "Claude Sonnet 5 (High)", "provider": "Anthropic", "score": 1408, "license": "Proprietary"},
        {"model": "GLM 5.2 (Max)", "provider": "Z.ai", "score": 1394, "license": "MIT - SiliconFlow"},
        {"model": "Grok 4.5", "provider": "SpaceXAI", "score": 1381, "license": "Proprietary"},
    ],
    "coding": [
        {"model": "Claude Opus 5 (High)", "provider": "Anthropic", "score": 1512, "license": "Proprietary"},
        {"model": "GPT 5.6 Sol (xHigh)", "provider": "OpenAI", "score": 1494, "license": "Proprietary"},
        {"model": "Claude Opus 5 (Max)", "provider": "Anthropic", "score": 1483, "license": "Proprietary"},
        {"model": "Claude Sonnet 5 (High)", "provider": "Anthropic", "score": 1470, "license": "Proprietary"},
        {"model": "Kimi K2.7 Code", "provider": "Moonshot", "score": 1455, "license": "Modified MIT"},
        {"model": "GPT 5.5 (xHigh)", "provider": "OpenAI", "score": 1442, "license": "Proprietary"},
        {"model": "DeepSeek V4 Pro", "provider": "DeepSeek", "score": 1428, "license": "MIT"},
        {"model": "GLM 5.2 (Max)", "provider": "Z.ai", "score": 1415, "license": "MIT - SiliconFlow"},
        {"model": "Qwen3.7 Max", "provider": "Alibaba", "score": 1398, "license": "Proprietary"},
        {"model": "Codestral 3 (Large)", "provider": "Mistral", "score": 1379, "license": "Modified MIT"},
    ],
    "image": [
        {"model": "Midjourney v8", "provider": "Midjourney", "score": 1268, "license": "Proprietary"},
        {"model": "Imagen 5 (Ultra)", "provider": "Google", "score": 1252, "license": "Proprietary"},
        {"model": "GPT Image 2 (High)", "provider": "OpenAI", "score": 1239, "license": "Proprietary"},
        {"model": "FLUX 2 Pro", "provider": "Black Forest Labs", "score": 1224, "license": "Proprietary"},
        {"model": "Seedream 4.0", "provider": "ByteDance", "score": 1208, "license": "Proprietary"},
        {"model": "Ideogram 4", "provider": "Ideogram", "score": 1192, "license": "Proprietary"},
        {"model": "FLUX.2 dev", "provider": "Black Forest Labs", "score": 1176, "license": "Apache 2.0"},
        {"model": "Qwen-Image 2", "provider": "Alibaba", "score": 1159, "license": "Apache 2.0"},
        {"model": "Stable Diffusion 4", "provider": "Stability AI", "score": 1142, "license": "Modified MIT"},
        {"model": "Recraft V4", "provider": "Recraft", "score": 1126, "license": "Proprietary"},
    ],
    "video": [
        {"model": "Veo 3.5", "provider": "Google", "score": 1341, "license": "Proprietary"},
        {"model": "Sora 2 (Pro)", "provider": "OpenAI", "score": 1322, "license": "Proprietary"},
        {"model": "Kling 3.0", "provider": "Kuaishou", "score": 1305, "license": "Proprietary"},
        {"model": "Runway Gen-5", "provider": "Runway", "score": 1288, "license": "Proprietary"},
        {"model": "Hailuo 03", "provider": "MiniMax", "score": 1270, "license": "MiniMax Community License"},
        {"model": "Seedance 2.0", "provider": "ByteDance", "score": 1253, "license": "Proprietary"},
        {"model": "Wan 2.5", "provider": "Alibaba", "score": 1236, "license": "Apache 2.0"},
        {"model": "Pika 3.0", "provider": "Pika Labs", "score": 1219, "license": "Proprietary"},
        {"model": "Luma Ray3", "provider": "Luma AI", "score": 1202, "license": "Proprietary"},
        {"model": "LTX-Video 2", "provider": "Lightricks", "score": 1184, "license": "Modified MIT"},
    ],
    "search": [
        {"model": "Gemini 3.1 Pro (Grounded)", "provider": "Google", "score": 1372, "license": "Proprietary"},
        {"model": "GPT 5.6 Sol (Search)", "provider": "OpenAI", "score": 1356, "license": "Proprietary"},
        {"model": "Perplexity Sonar 3", "provider": "Perplexity", "score": 1341, "license": "Proprietary"},
        {"model": "Claude Opus 5 (Web)", "provider": "Anthropic", "score": 1327, "license": "Proprietary"},
        {"model": "Grok 4.5 (Live)", "provider": "SpaceXAI", "score": 1312, "license": "Proprietary"},
        {"model": "DeepSeek V4 Pro (Search)", "provider": "DeepSeek", "score": 1296, "license": "MIT"},
        {"model": "Qwen3.7 Max (Search)", "provider": "Alibaba", "score": 1279, "license": "Proprietary"},
        {"model": "Kimi K3 (Web)", "provider": "Moonshot", "score": 1261, "license": "Kimi K3 license"},
        {"model": "Llama 4.1 (Search)", "provider": "Meta", "score": 1244, "license": "Llama 4.1 Community License"},
        {"model": "Mistral Medium 3.5 (Web)", "provider": "Mistral", "score": 1228, "license": "Modified MIT"},
    ],
    "reasoning": [
        {"model": "GPT 5.6 Sol (xHigh)", "provider": "OpenAI", "score": 1521, "license": "Proprietary"},
        {"model": "Claude Opus 5 (Max)", "provider": "Anthropic", "score": 1508, "license": "Proprietary"},
        {"model": "Claude Opus 4.8 (Thinking)", "provider": "Anthropic", "score": 1495, "license": "Proprietary"},
        {"model": "Gemini 3.1 Pro (Thinking)", "provider": "Google", "score": 1481, "license": "Proprietary"},
        {"model": "Grok 4.5 (Heavy)", "provider": "SpaceXAI", "score": 1466, "license": "Proprietary"},
        {"model": "DeepSeek R2 (High)", "provider": "DeepSeek", "score": 1452, "license": "MIT"},
        {"model": "Kimi K3 (Max)", "provider": "Moonshot", "score": 1438, "license": "Kimi K3 license"},
        {"model": "Qwen3.7 Max (Thinking)", "provider": "Alibaba", "score": 1423, "license": "Proprietary"},
        {"model": "GLM 5.2 (Max)", "provider": "Z.ai", "score": 1407, "license": "MIT - SiliconFlow"},
        {"model": "Claude Sonnet 5 (High)", "provider": "Anthropic", "score": 1392, "license": "Proprietary"},
    ],
    "text-generation": [
        {"model": "Claude Opus 5 (High)", "provider": "Anthropic", "score": 1478, "license": "Proprietary"},
        {"model": "Claude Fable 5 (High)", "provider": "Anthropic", "score": 1465, "license": "Proprietary"},
        {"model": "GPT 5.6 Sol (xHigh)", "provider": "OpenAI", "score": 1452, "license": "Proprietary"},
        {"model": "Gemini 3.1 Pro Preview", "provider": "Google", "score": 1438, "license": "Proprietary"},
        {"model": "Claude Sonnet 5 (High)", "provider": "Anthropic", "score": 1424, "license": "Proprietary"},
        {"model": "Grok 4.5", "provider": "SpaceXAI", "score": 1409, "license": "Proprietary"},
        {"model": "DeepSeek V4 Pro", "provider": "DeepSeek", "score": 1394, "license": "MIT"},
        {"model": "Kimi K3 (Max)", "provider": "Moonshot", "score": 1379, "license": "Kimi K3 license"},
        {"model": "Qwen3.7 Max", "provider": "Alibaba", "score": 1363, "license": "Proprietary"},
        {"model": "Mistral Medium 3.5", "provider": "Mistral", "score": 1347, "license": "Modified MIT"},
    ],
}


# Kurdish (Sorani) access-type labels, stamped onto every row as `license_type`.
LICENSE_TYPE_OPEN = "سەرچاوە کراوە"
LICENSE_TYPE_PROPRIETARY = "تایبەت"

# Substrings that mark a closed/commercial license. Any row that carries a real
# license string without one of these is treated as open source — this covers
# MIT, Apache 2.0, "MIT - SiliconFlow", "Modified MIT", vendor open-weight
# licenses ("Kimi K3 license", "MiniMax Community License", "OpenMDW"), etc.
_CLOSED_MARKERS = ("proprietary", "closed", "commercial", "api only", "api-only")


def _is_open_license(val):
    """True when an arena license string denotes open-source / open-weight access."""
    s = str(val or "").strip().lower()
    if not s:
        return False  # unknown → assume proprietary (safer default)
    return not any(m in s for m in _CLOSED_MARKERS)


def _license_type(val):
    """Kurdish access-type label ("سەرچاوە کراوە" / "تایبەت") for a license string."""
    return LICENSE_TYPE_OPEN if _is_open_license(val) else LICENSE_TYPE_PROPRIETARY


def _normalise_rows(raw):
    """Coerce a list of arena entries into [{model, provider, score, license}].

    Preserves the arena's exact spellings: the full model title (variant flag in
    parentheses kept intact), the organisation name, and the verbatim license /
    access string. Accepts the common arena field aliases (model / Model / key,
    org / organization / company / provider, arena_score / rating / score /
    net_improvement, license / access). Rows missing a model name or score are
    dropped; the rest are sorted by score desc and capped at 10. `rank` and
    `license_type` are added later by _finalize().
    """
    out = []
    for r in raw or []:
        if not isinstance(r, dict):
            continue
        model = r.get("model") or r.get("Model") or r.get("key") or r.get("name")
        score = (r.get("score") or r.get("arena_score") or r.get("rating")
                 or r.get("elo") or r.get("Arena Score") or r.get("net_improvement"))
        if not model or score is None:
            continue
        try:
            score = int(round(float(score)))
        except (TypeError, ValueError):
            continue
        provider = (r.get("provider") or r.get("organization") or r.get("org")
                    or r.get("Organization") or r.get("company") or "")
        license_str = (r.get("license") or r.get("License")
                       or r.get("access") or r.get("license_type") or "")
        out.append({
            "model": str(model).strip(),
            "provider": str(provider).strip(),
            "score": score,
            "license": str(license_str).strip() or "Proprietary",
        })
    out.sort(key=lambda x: x["score"], reverse=True)
    return out[:10]


def _finalize(rows):
    """Stamp 1-based `rank` and the Kurdish `license_type` label on each row,
    emitting the columns in the arena's canonical order. Order is preserved as
    given (fallback is pre-sorted; live rows are sorted by _normalise_rows)."""
    return [
        {
            "rank": i,
            "model": r["model"],
            "provider": r["provider"],
            "score": r["score"],
            "license": r["license"],
            "license_type": _license_type(r["license"]),
        }
        for i, r in enumerate(rows, start=1)
    ]


def _fetch_json(url, timeout=15):
    req = urllib.request.Request(url, headers={"User-Agent": "kurd-ai-leaderboard/1.0"})
    with urllib.request.urlopen(req, timeout=timeout) as resp:
        return json.loads(resp.read().decode("utf-8"))


def build():
    """Return the full leaderboard dict.

    If LEADERBOARD_SRC is set, try to pull a live arena mirror shaped as
    { <arena-slug or category-key>: [ ...rows... ] } and normalise it. Any
    category the mirror doesn't cover (or the whole thing, if the fetch
    fails) falls back to the curated snapshot, so the output is always
    complete.
    """
    src = os.environ.get("LEADERBOARD_SRC", "").strip()
    live = {}
    source_label = "Agent Arena (LMSYS) — curated snapshot"

    if src:
        try:
            payload = _fetch_json(src)
            if isinstance(payload, dict):
                live = payload
                source_label = "Agent Arena (LMSYS) — live: " + src
                sys.stderr.write("fetched live leaderboard from %s\n" % src)
        except (urllib.error.URLError, ValueError, OSError) as e:
            sys.stderr.write("live fetch failed (%s); using curated fallback\n" % e)

    categories = {}
    for cat in CATEGORIES:
        key, slug = cat["key"], cat["arena"]
        rows = _normalise_rows(live.get(key) or live.get(slug))
        if not rows:
            rows = FALLBACK[key]
        categories[key] = _finalize(rows)

    return {
        "updated": datetime.now(timezone.utc).strftime("%Y-%m-%d"),
        "source": source_label,
        "source_url": LMARENA_URL,
        "categories": categories,
    }


def main(argv):
    data = build()
    text = json.dumps(data, ensure_ascii=False, indent=2) + "\n"

    if "--stdout" in argv:
        sys.stdout.write(text)
        return 0

    here = os.path.dirname(os.path.abspath(__file__))
    out_path = os.path.join(here, "public", "data", "leaderboard.json")
    os.makedirs(os.path.dirname(out_path), exist_ok=True)
    with open(out_path, "w", encoding="utf-8") as f:
        f.write(text)

    total = sum(len(v) for v in data["categories"].values())
    sys.stderr.write("wrote %s — %d categories, %d rows (%s)\n" % (
        out_path, len(data["categories"]), total, data["source"]))
    return 0


if __name__ == "__main__":
    raise SystemExit(main(sys.argv[1:]))
