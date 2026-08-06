#!/usr/bin/env python3
"""
Validate all generated Ferga curriculum JSON files against the schema in SCHEMA.md.

Usage: python3 storage/curriculum/validate.py
Exit code 0 = all good, 1 = problems found.
"""
import json
import os
import sys

DIR = os.path.dirname(os.path.abspath(__file__))

LANGS = {
    'csharp.json': '-OysGzUzKG67KcswHXn2',
    'cpp.json': '-Oyrqajy5loFSFBPUgNi',
    'rust.json': '-OysGzfS5Qi08XHYs_FL',
    'htmlcss.json': '-OysQq7E9B4bBLuGjUEX',
    'php.json': '-Oysj44hJLXDgdp-b9iN',
    'java.json': '-Oysj4DmsfjAe6mjjfjT',
}

REQUIRED_SCALARS = [
    'langId', 'order', 'level_so', 'level_ba', 'title_so', 'title_ba',
    'content_so', 'content_ba', 'code', 'example_output', 'expected_output',
    'challenge_desc_so', 'challenge_desc_ba', 'answer_code', 'quiz_type',
    'quiz_question_so', 'quiz_question_ba', 'quiz_correct',
]

# cycle: lesson N uses concept ((N-1) mod 4)+1
def expected_quiz_type(n):
    concept = ((n - 1) % 4) + 1
    return 'choice' if concept in (1, 2) else 'code'

def main():
    problems = 0
    total_lessons = 0
    for fname, langid in LANGS.items():
        path = os.path.join(DIR, fname)
        if not os.path.exists(path):
            print(f'[MISSING] {fname} — file does not exist')
            problems += 1
            continue
        with open(path, encoding='utf-8') as f:
            try:
                lessons = json.load(f)
            except json.JSONDecodeError as e:
                print(f'[INVALID JSON] {fname}: {e}')
                problems += 1
                continue
        if not isinstance(lessons, list):
            print(f'[ERROR] {fname}: top-level is not a JSON array')
            problems += 1
            continue

        total_lessons += len(lessons)
        orders = []
        for i, l in enumerate(lessons, start=1):
            tag = f'{fname}[{i}]'
            if not isinstance(l, dict):
                print(f'[ERROR] {tag}: lesson is not an object')
                problems += 1
                continue

            # 1. langId
            if l.get('langId') != langid:
                print(f'[ERROR] {tag}: langId={l.get("langId")!r}, expected {langid}')
                problems += 1

            # 2. required scalar fields present
            for k in REQUIRED_SCALARS:
                if k not in l:
                    print(f'[ERROR] {tag}: missing field "{k}"')
                    problems += 1

            # 3. order sequential
            o = l.get('order')
            orders.append(o)
            if o != i:
                print(f'[ERROR] {tag}: order={o!r}, expected {i}')
                problems += 1

            # 4. quiz_type matches the cycling rule
            qt = l.get('quiz_type', '')
            expected = expected_quiz_type(i)
            if qt != expected:
                print(f'[ERROR] {tag}: quiz_type={qt!r}, expected {expected!r} (cycle ((N-1) mod 4)+1)')
                problems += 1

            # 5. choice lessons: options arrays of 4 + correct in 1..4
            if qt == 'choice':
                for k in ('quiz_options_so', 'quiz_options_ba'):
                    opts = l.get(k)
                    if not isinstance(opts, list) or len(opts) != 4:
                        print(f'[ERROR] {tag}: {k} must be list of 4, got {opts!r}')
                        problems += 1
                    else:
                        for j, oo in enumerate(opts, start=1):
                            if not (isinstance(oo, str) and oo.strip()):
                                print(f'[ERROR] {tag}: {k}[{j}] is empty')
                                problems += 1
                c = str(l.get('quiz_correct', ''))
                if c not in ('1', '2', '3', '4'):
                    print(f'[ERROR] {tag}: quiz_correct={c!r}, must be "1".."4"')
                    problems += 1
                # challenge fields should be empty for choice lessons
                for k in ('challenge_desc_so', 'challenge_desc_ba', 'expected_output', 'answer_code'):
                    if str(l.get(k, '')).strip():
                        print(f'[WARN] {tag}: choice lesson has non-empty "{k}" (should be empty)')
                if str(l.get('quiz_question_so', '')).strip() == '':
                    print(f'[ERROR] {tag}: choice lesson needs quiz_question_so')
                    problems += 1

            # 6. code lessons: challenge + answer + expected present; quiz fields empty
            elif qt == 'code':
                for k in ('challenge_desc_so', 'challenge_desc_ba', 'expected_output', 'answer_code'):
                    if not str(l.get(k, '')).strip():
                        print(f'[ERROR] {tag}: code lesson missing "{k}"')
                        problems += 1
                for k in ('quiz_question_so', 'quiz_question_ba'):
                    if str(l.get(k, '')).strip():
                        print(f'[WARN] {tag}: code lesson has non-empty "{k}" (should be empty)')
                if str(l.get('quiz_correct', '')).strip():
                    print(f'[WARN] {tag}: code lesson has non-empty quiz_correct (should be empty)')
            elif qt not in ('none', ''):
                print(f'[ERROR] {tag}: unsupported quiz_type {qt!r}')
                problems += 1

            # 7. order numbers all distinct (guards against dupes)
            if o is not None and len(orders) != len(set(orders)):
                pass  # covered by sequential check

            # 8. HTML+CSS expected_output must parse as preview-check JSON
            if fname == 'htmlcss.json' and str(l.get('expected_output', '')).strip():
                try:
                    parsed = json.loads(l['expected_output'])
                    if not (isinstance(parsed, list) or (isinstance(parsed, dict) and 'checks' in parsed)):
                        print(f'[WARN] {tag}: expected_output parses but not a checks array: {parsed!r}')
                except json.JSONDecodeError:
                    print(f'[ERROR] {tag}: HTML+CSS expected_output must be JSON preview checks, got {l["expected_output"]!r}')
                    problems += 1

        # 8b. orders strictly 1..N
        if orders != list(range(1, len(lessons) + 1)):
            print(f'[ERROR] {fname}: orders not 1..{len(lessons)} sequential: {orders}')
            problems += 1

        print(f'[OK] {fname}: {len(lessons)} lessons, langId={langid}')

    print('-' * 50)
    print(f'TOTAL lessons across languages: {total_lessons}')
    if problems:
        print(f'RESULT: {problems} problem(s) found')
        sys.exit(1)
    print('RESULT: all files valid')
    sys.exit(0)

if __name__ == '__main__':
    main()
