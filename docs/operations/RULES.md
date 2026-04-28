# Current Rules

## Token Optimization Stack

- Use `caveman`-style brevity by default: short, direct, technically accurate, low filler.
- Use `lean-ctx` first for file reads, tree inspection, search, shell output, outlines, and compressed context.
- Use `symdex-code-search` first for code discovery: symbols, callers, callees, routes, semantic lookup.
- Use repo graph tools first when available for architecture, impact radius, coverage, and review context.
- Use parallel tool calls for independent reads/searches to reduce round trips and repeated context loading.
- Keep context narrow: read only needed files, prefer symbols/outlines/diffs over full files.
- Expand explanation only for risky work, ambiguity, or explicit user request.
- Use subagents for bounded parallel research only when delegation is allowed and materially helps.
- Prefer memory/context compression for large rule files or session docs when they start bloating prompts.

## Token Optimization Notes

- `graphify` is not a default token-optimization tool in this repo. It is useful for turning large inputs into a knowledge graph, but it is optional and task-specific.
- The main stack here is `caveman` + `lean-ctx` + `symdex-code-search` + graph-first exploration.

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
- Write durable feature summaries to `docs/implementation/` and handoff logs to `docs/operations/sessions/`.

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
- Record completed work in `docs/implementation/` or `docs/operations/sessions/` based on whether it is durable documentation or a handoff log.
- Always update `docs/operations/IMPLEMENTATION_TRACKER.md` when a feature is finished or an existing feature's implementation status or behavior changes.
- Keep implementation tracker and bug list aligned with real code before closing work.

## UI Rules

- Keep public shell consistent across pages.
- Use same container widths and spacing rhythm.
- Prefer local asset fallbacks over remote placeholders.
- Make interactive cards fully clickable when appropriate.
- Keep mobile admin usable: visible burger, compact actions, scoped menus.

## New Project Baseline Prompt

Use this as the starting project rule prompt for new repos:

```md
# Agent Rules

## Token Efficiency Defaults

- Use `caveman`-style brevity by default: short, direct, technically accurate, readable.
- Prefer `lean-ctx` for reads, tree inspection, search, outlines, shell output, and compressed context.
- Prefer `symdex-code-search` or equivalent code index before broad file scanning.
- Prefer graph/context-first exploration before grep-style scanning when a repo graph is available.
- Keep context tight: read only what is needed, prefer symbols/outlines/diffs over full files.
- Expand explanations only for risky work, ambiguity, or when the user asks for more detail.
- Avoid filler, repetition, and restating obvious tool output.
- Parallelize independent reads/searches when possible.
- Compress or trim large memory/rules files when they become prompt ballast.

## Workflow Defaults

- Plan first for non-trivial tasks; re-plan quickly if execution diverges.
- Explore with index/graph/context tools before raw file scanning.
- Verify before marking work done: run relevant tests, lint, or smoke checks.
- Prefer minimal-impact fixes over broad refactors unless the task requires broader changes.
- Preserve existing user changes and do not revert unrelated edits.
- Do not use destructive git commands unless explicitly requested.
- Do not commit or push unless explicitly requested.

## Docs Defaults

- Keep `RULES.md` short and high-signal.
- Store all non-code project knowledge under `docs/`, using subfolders by purpose.
- Update docs only when behavior, workflow, or architecture actually changes.
```
- Do not make an update that could break everything we have code!
