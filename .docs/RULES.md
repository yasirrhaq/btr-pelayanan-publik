# Current Rules

## Response Style

- Use short direct answers.
- Keep filler low.
- Prefer action-first wording.
- Ask only when blocked or risky.

## Workflow

- Plan first for non-trivial work.
- Re-plan when execution changes.
- Use tools early.
- Verify before calling work done.
- Prefer minimal-impact fixes.
- Write session reports to `.docs/sessions`.

## Project-Specific Working Rules

- Use graph/context-first exploration when possible before broad file scanning.
- Track progress with todo updates for multi-step work.
- Preserve existing user changes.
- Do not revert unrelated workspace edits.
- Do not use destructive git commands.
- Do not commit unless user asks.
- Do not push unless user asks.

## Git Rules

- Inspect `git status`, `git diff`, `git log` before commit.
- Follow existing commit style.
- Avoid amend unless explicitly requested and safe.
- Never force push without explicit request.

## Verification Rules

- Lint changed PHP when relevant.
- Clear Blade cache after Blade/layout changes when needed.
- Use Docker-aware commands in this repo.
- Prefer checking real DB state for workflow/dashboard issues.

## Docs Rules

- Update related `.md` docs after substantial feature or workflow changes.
- Record completed work in `.docs/sessions`.
- Keep implementation tracker and bug list aligned with real code.

## UI Rules

- Keep public shell consistent across pages.
- Use same container widths and spacing rhythm.
- Prefer local asset fallbacks over remote placeholders.
- Make interactive cards fully clickable when appropriate.
- Keep mobile admin usable: visible burger, compact actions, scoped menus.
