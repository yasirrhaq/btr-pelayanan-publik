# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**BTR Pelayanan Publik** — A public services web application for Balai Teknik Rawa (a technical rawa/swamp engineering office). Built with Laravel 8, PHP ^7.2, and Vite. The UI language is Indonesian.

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
