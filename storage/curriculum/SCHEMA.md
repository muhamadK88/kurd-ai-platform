# Ferga Curriculum Generation Spec (Kurd AI Platform)

This spec defines how to generate comprehensive lesson curricula for the **Ferga** learning
platform. It matches the live Firebase schema for the node `ferga_lessons` (see
`storage/backups/firebase-corrected/ferga_lessons.json` for reference).

## Language keys (langId) — DO NOT CHANGE

| Language      | langId                    | ext       |
|---------------|---------------------------|-----------|
| Python        | -OypFoFNvHfBuaA2Uh7O      | py        |
| C++           | -Oyrqajy5loFSFBPUgNi      | cpp       |
| C#            | -OysGzUzKG67KcswHXn2      | cs        |
| Rust          | -OysGzfS5Qi08XHYs_FL      | rs        |
| HTML + CSS    | -OysQq7E9B4bBLuGjUEX      | html+css  |
| PHP           | -Oysj44hJLXDgdp-b9iN      | php       |
| Java          | -Oysj4DmsfjAe6mjjfjT      | java      |
| JavaScript    | -Oysj4NVk0PGRLQx2Z8o      | js        |

## Lesson object schema (exact keys)

Each lesson is a JSON object with EXACTLY these keys:

```json
{
  "langId": "<one of the ids above>",
  "order": 1,
  "level_so": "بەشی ١ - دەستپێک",
  "level_ba": "بەشا ١ - دەستپێک",
  "title_so": "...",
  "title_ba": "...",
  "content_so": "<p>...</p>",
  "content_ba": "<p>...</p>",
  "code": "...",
  "code_css": "",
  "example_output": "...",
  "challenge_desc_so": "...",
  "challenge_desc_ba": "...",
  "expected_output": "...",
  "answer_code": "...",
  "answer_code_css": "",
  "quiz_type": "choice",
  "quiz_question_so": "...",
  "quiz_question_ba": "...",
  "quiz_options_so": ["", "", "", ""],
  "quiz_options_ba": ["", "", "", ""],
  "quiz_correct": "1",
  "max_attempts": 5,
  "allow_show_answer": true,
  "xp_cost": 0
}
```

### Field rules

- `order`: integer, sequential starting at 1 within each language.
- `level_so` / `level_ba`: the **chapter** label (rendered as a section heading). Format:
  - Sorani: `بەشی ١ - <chapter title>` (٢, ٣, ... for later chapters)
  - Badini: `بەشا ١ - <chapter title>` (٢, ٣, ...)
  - The same chapter label is used for every lesson inside that chapter.
- `title_so` / `title_ba`: lesson title in Sorani / Badini.
- `content_so` / `content_ba`: full HTML educational content. Use `<p>`, `<h3>`, `<ul>`,
  `<li>`, `<strong>`, `<code>`, `<pre>`. Explain concepts with **real-world analogies**.
  Sorani (so) = Central Kurdish. Badini (ba) = Northern Kurdish/Bahdini dialect — write it as
  authentic Bahdini (e.g. «بکەت»/«دبیت»/«هاتییە»/«ئەڤ» vs Sorani «بکەیت»/«دەبێت»/«هاتووە»/«ئەم»).
- `code`: a clean, **runnable** example with **Kurdish comments** inside the code.
- `example_output`: the exact output printed by `code`.
- `code_css`: only for HTML+CSS lessons (CSS part). Empty string otherwise.
- `xp_cost`: `0`.
- `max_attempts`: `5`.
- `allow_show_answer`: `true`.

## Assessment — 4 conceptual types cycling evenly

Every lesson carries ONE assessment. The 4 conceptual types map onto the 2 technical
formats the DB supports (`quiz_type` = `choice` or `code`). **Cycle evenly**: lesson N uses
concept `((N-1) mod 4) + 1`, so 1,2,3,4,1,2,3,4,...

### Concept 1 — Standard Quiz  (`quiz_type: "choice"`)
A theoretical multiple-choice question about the lesson.
- Fill: `quiz_question_so`, `quiz_question_ba`, `quiz_options_so` (4 non-empty strings),
  `quiz_options_ba` (4 non-empty strings), `quiz_correct` (string `"1"`..`"4"`, 1-based).
- Leave challenge fields empty: `challenge_desc_so`, `challenge_desc_ba`, `expected_output`,
  `answer_code`, `answer_code_css` = `""`.

### Concept 2 — Predict Output  (`quiz_type: "choice"`)
A short code snippet is placed **inside the question text**; the 4 options are possible
outputs (e.g. `5`, `10`, `Syntax Error`, `None`).
- Fill the same quiz fields as Concept 1. The question text contains the snippet.
- Leave challenge fields empty.

### Concept 3 — Find the Bug  (`quiz_type: "code"`)
`challenge_desc_so` / `challenge_desc_ba` contains a piece of **buggy code** and asks the
student to find the error and write the fully corrected code.
- Fill: `challenge_desc_so`, `challenge_desc_ba`, `answer_code` (the corrected code),
  `expected_output` (what the corrected program must print), `max_attempts` = 5.
- Leave quiz fields empty: `quiz_question_so`, `quiz_question_ba` = `""`,
  `quiz_options_so`, `quiz_options_ba` = `["","","",""]`, `quiz_correct` = `""`.

### Concept 4 — Write from Scratch  (`quiz_type: "code"`)
`challenge_desc_so` / `challenge_desc_ba` asks the student to write a specific, simple
program from scratch.
- Fill the same challenge fields as Concept 3.
- Leave quiz fields empty.

## HTML+CSS special rules

- For HTML+CSS lessons, `expected_output` must be a JSON string of **preview checks**, e.g.
  `[{"t":"text","v":"Hello"}]` or
  `[{"t":"style","s":"h1","p":"color","v":"red"},{"t":"text","v":"Welcome"}]`.
  Check types supported: `text` (body contains `v`), `style` (selector `s`, property `p`,
  value `v`), `attr`, `count`, `var`, `media`.
- CSS-focused lessons: put the CSS in `code_css` and HTML in `code` (combined web mode).
- `example_output` describes what the student sees, e.g. `A red heading "Welcome"`.

## Chapter outlines per language

### C# (cs) — langId -OysGzUzKG67KcswHXn2
1. دەستپێک — Introduction (what is C#, hello world, program structure, comments, Console)
2. گۆڕاوەکان و جۆرەکانی داتا — Variables & data types, input, constants
3. ئۆپەرەیتەرەکان — Operators (arithmetic, comparison, logical)
4. مەرجەکان — Conditions (if/else, switch, ternary)
5. لوولەکان — Loops (for, while, do-while, break/continue)
6. فەنکشنەکان — Functions/Methods (params, return, overloads)
7. ئارای و کۆلیکشن — Arrays, Lists, foreach, dictionaries
8. OOP — Classes, objects, constructors, inheritance, polymorphism

### C++ (cpp) — langId -Oyrqajy5loFSFBPUgNi
1. دەستپێک — Introduction (what is C++, hello world, iostream, comments)
2. گۆڕاوەکان و جۆرەکانی داتا — Variables & types, input
3. ئۆپەرەیتەرەکان — Operators
4. مەرجەکان — Conditions
5. لوولەکان — Loops
6. فەنکشنەکان — Functions
7. ئارای و پۆینتەر — Arrays & pointers
8. OOP — Classes, inheritance, polymorphism

### Rust (rs) — langId -OysGzfS5Qi08XHYs_FL
1. دەستپێک — Introduction (cargo, hello world, comments)
2. گۆڕاوەکان و جۆرەکانی داتا — Variables, types, shadowing
3. خاوەندارێتی و قەرزکردن — Ownership & borrowing
4. مەرجەکان — Conditions (if/else, match)
5. لوولەکان — Loops (loop, while, for)
6. فەنکشنەکان — Functions
7. ستڕەکت و ئێنووم — Structs & enums
8. هەڵەکان و داتا پێکهاتەکان — Error handling (Result/Option), Vec/HashMap

### HTML + CSS (html+css) — langId -OysQq7E9B4bBLuGjUEX
1. HTML بنەڕەتی — Structure, headings, paragraphs, links, images
2. HTML توخمەکان — Lists, tables, forms, semantic tags
3. CSS بنەڕەتی — Selectors, colors, text/font styling
4. بۆکس مۆدێل — Box model, margin, padding, border
5. پۆزیشن و نمایش — Display, position, float, overflow
6. فلیکس — Flexbox (justify-content, align-items, flex-wrap)
7. گرید — CSS Grid (grid-template, areas, gap)
8. لایۆتی پێشکەوتوو — Responsive design, media queries, animations, CSS variables

### PHP (php) — langId -Oysj44hJLXDgdp-b9iN
1. دەستپێک — Introduction (what is PHP, echo, comments, variables)
2. جۆرەکانی داتا — Data types, strings, numbers, booleans
3. ئۆپەرەیتەرەکان — Operators
4. مەرجەکان — Conditions (if/else, switch)
5. لوولەکان — Loops (for, foreach, while)
6. فەنکشنەکان — Functions
7. ئارایەکان — Arrays (indexed, associative, multidimensional)
8. OOP — Classes, inheritance, visibility

### Java (java) — langId -Oysj4DmsfjAe6mjjfjT
1. دەستپێک — Introduction (JVM, hello world, main method)
2. گۆڕاوەکان و جۆرەکانی داتا — Variables & types
3. ئۆپەرەیتەرەکان — Operators
4. مەرجەکان — Conditions
5. لوولەکان — Loops
6. فەنکشنەکان — Methods
7. ئارایەکان — Arrays, ArrayList
8. OOP — Classes, objects, inheritance, polymorphism

## Output requirements

- Produce **one JSON file per language**: an array of lesson objects.
- Suggested names: `csharp.json`, `cpp.json`, `rust.json`, `htmlcss.json`, `php.json`, `java.json`.
- Target **~28 lessons** per language (3-4 lessons per chapter × 8 chapters).
- JSON must be valid UTF-8, parseable with `json.load`. Write with a Python script that
  `json.dumps(lessons, ensure_ascii=False, indent=2)` to guarantee validity.
- Kurdish comments inside `code` strings are required.
