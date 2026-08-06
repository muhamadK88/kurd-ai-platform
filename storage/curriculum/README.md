# Ferga Curriculum — Generated Content

Comprehensive programming curricula for the **Ferga** learning module (Kurd AI), generated
from scratch for **C# · C++ · Rust · HTML+CSS · PHP · Java**.

> Python and JavaScript are intentionally **not** included — per user direction.

## Files

| File            | Language   | langId                  |
|-----------------|------------|-------------------------|
| `csharp.json`   | C#         | `-OysGzUzKG67KcswHXn2`  |
| `cpp.json`      | C++        | `-Oyrqajy5loFSFBPUgNi`  |
| `rust.json`     | Rust       | `-OysGzfS5Qi08XHYs_FL`  |
| `htmlcss.json`  | HTML + CSS | `-OysQq7E9B4bBLuGjUEX`  |
| `php.json`      | PHP        | `-Oysj44hJLXDgdp-b9iN`  |
| `java.json`     | Java       | `-Oysj4DmsfjAe6mjjfjT`  |

- `SCHEMA.md` — the full generation spec (schema, 4 assessment concepts, cycling rule,
  bilingual quality requirements, chapter outlines).
- `validate.py` — schema/consistency validator. Run:
  `python3 storage/curriculum/validate.py`
- `../database/seeders/FergaCurriculumSeeder.php` — Laravel seeder that imports these files
  into the Firebase `ferga_lessons` node (same mechanism as the admin panel).

## Every lesson includes

- `title_so` / `title_ba` — Sorani + Badini lesson titles
- `level_so` / `level_ba` — chapter label (`بەشی ١ - دەستپێک` / `بەشا ١ - دەستپێک`)
- `content_so` / `content_ba` — full HTML explanation with real-world analogies
- `code` — runnable example with Kurdish comments
- `example_output` — exact output of the example
- One assessment, cycling through 4 concepts every 4 lessons:
  1. Standard Quiz (`choice`) — theoretical multiple choice
  2. Predict Output (`choice`) — code snippet in the question, outputs as options
  3. Find the Bug (`code`) — buggy code to correct in `challenge_desc_*` / `answer_code`
  4. Write from Scratch (`code`) — build a small program from scratch

## Importing to the live platform

```bash
# validate everything first
python3 storage/curriculum/validate.py

# copy to the seeder's data dir
cp storage/curriculum/*.json database/seeders/data/ferga/

# dry run (validate only — nothing written)
FERGA_DRY_RUN=1 php artisan db:seed --class=FergaCurriculumSeeder

# real import to Firebase
php artisan db:seed --class=FergaCurriculumSeeder
```

`FergaCurriculumSeeder` POSTs each lesson to `ferga_lessons` via `set(push(...))` semantics —
identical to how the admin panel saves lessons, so the platform UI picks them up as-is.
