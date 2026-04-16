# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**BTR Pelayanan Publik** — A public services web application for Balai Teknik Rawa (a technical rawa/swamp engineering office). Built with Laravel 8, PHP ^7.2, and Vite. The UI language is Indonesian.

## Token Efficiency Defaults

- Keep responses concise by default using `caveman`-style brevity in `full` mode: short, direct, technically accurate, and readable.
- Prefer `lean-ctx` for reads, shell output, search, and tree inspection to reduce context usage.
- Prefer `symdex-code-search` for code discovery before broad file scanning.
- Expand explanations only when the task is risky, ambiguous, or the user asks for more detail.
- Avoid filler, repetition, and restating obvious command output.

## Workflow Defaults

Primary workflow reference: `.docs/WORKFLOW.md`.

- Plan first for any non-trivial task; re-plan quickly if execution diverges.
- Use subagents/tools aggressively for research, exploration, and parallel analysis to keep main context clean.
- Verify before marking work done: run relevant tests, compare behavior, inspect logs when needed.
- Prefer elegant, minimal-impact fixes over patchy quick wins.
- Handle bug fixing autonomously when enough context is available.
- Track work in `tasks/todo.md`, capture review notes there, and record recurring corrections in `tasks/lessons.md`.
- Write completed feature sessions to `.docs/sessions`.
- Prefer current external docs through Context7 when latest documentation matters.

## Common Commands

```bash
# Install dependencies
composer install
npm install

# Asset compilation
npm run dev       # Development with hot reload
npm run build     # Production build

# Database
php artisan migrate
php artisan migrate:fresh --seed

# Storage
php artisan storage:link

# Run tests
php artisan test
php artisan test --filter TestClassName   # Single test
vendor/bin/phpunit tests/Feature/ExampleTest.php  # Specific file

# Tinker / debugging
php artisan tinker
```

## Architecture

### Authentication & Middleware

Two custom middleware control access beyond Laravel's default `auth`:

- `admin` → `IsAdmin` middleware: checks `users.is_admin == 1`
- `is_verify_email` → `IsVerifyEmail` middleware: checks `users.is_verified == 1`

Registration sends an email verification link (via `SignupEmail` Mailable using Gmail SMTP). Users must verify before accessing protected routes. The middleware stack is defined in [app/Http/Kernel.php](app/Http/Kernel.php).

### Route Structure

- **Public** (`routes/web.php`, no middleware): home, berita (news), company info pages, gallery, services
- **Auth + verified** (middleware: `auth`, `is_verify_email`): profile, service status tracking
- **Admin** (prefix: `/dashboard`, middleware: `admin`): full CRUD for all content types

### Content Management

Admin can manage: posts/berita (with slugs), categories, karya ilmiah (scientific works), gallery (foto/video), employee info, organization structure, facilities, landing pages, related sites, footer settings, URL services.

**Landing pages** (`LandingPage` model) use soft deletes and track `created_by`/`updated_by` user IDs. They have a type relation (`LandingPageTipe`).

### Models with Sluggable

`Post`, `Category`, and `KaryaIlmiah` use `cviebrock/eloquent-sluggable`. Slugs are generated automatically on create.

### Helper Functions (`app/Helper.php`)

Global functions autoloaded via composer:
- `cutText($string, $limit)` — truncate to N words
- `imageExists($path)` — checks if image exists, falls back to an Unsplash placeholder
- `globalTipeLanding()` — fetches all `LandingPageTipe` records (used in views)
- `slugCustom($name)` — manual slug generation
- `toSqlWithBinding($builder, $get)` — debug query output

### Database

MySQL. Database name: `pupr` (see `.env.example`). Faker locale is `id_ID`.

### Assets

Vite (`vite.config.js`) handles JS and CSS. Compiled assets go to `public/build/`. The `resources/js/app.js` and `resources/css/app.css` are the entry points.

### AppServiceProvider Notes

- Forces HTTPS URLs in production
- Sets Bootstrap 5 pagination via `Paginator::useBootstrap()`
- Sets default string length to 191 (for older MySQL compatibility)

<!-- code-review-graph MCP tools -->
## MCP Tools: code-review-graph

**IMPORTANT: This project has a knowledge graph. ALWAYS use the
code-review-graph MCP tools BEFORE using Grep/Glob/Read to explore
the codebase.** The graph is faster, cheaper (fewer tokens), and gives
you structural context (callers, dependents, test coverage) that file
scanning cannot.

### When to use graph tools FIRST

- **Exploring code**: `semantic_search_nodes` or `query_graph` instead of Grep
- **Understanding impact**: `get_impact_radius` instead of manually tracing imports
- **Code review**: `detect_changes` + `get_review_context` instead of reading entire files
- **Finding relationships**: `query_graph` with callers_of/callees_of/imports_of/tests_for
- **Architecture questions**: `get_architecture_overview` + `list_communities`

Fall back to Grep/Glob/Read **only** when the graph doesn't cover what you need.

### Key Tools

| Tool | Use when |
|------|----------|
| `detect_changes` | Reviewing code changes — gives risk-scored analysis |
| `get_review_context` | Need source snippets for review — token-efficient |
| `get_impact_radius` | Understanding blast radius of a change |
| `get_affected_flows` | Finding which execution paths are impacted |
| `query_graph` | Tracing callers, callees, imports, tests, dependencies |
| `semantic_search_nodes` | Finding functions/classes by name or keyword |
| `get_architecture_overview` | Understanding high-level codebase structure |
| `refactor_tool` | Planning renames, finding dead code |

### Workflow

1. The graph auto-updates on file changes (via hooks).
2. Use `detect_changes` for code review.
3. Use `get_affected_flows` to understand impact.
4. Use `query_graph` pattern="tests_for" to check coverage.
