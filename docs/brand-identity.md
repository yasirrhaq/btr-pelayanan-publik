# BTR Brand Identity

## Purpose

This document is the current source of truth for visual brand consistency in the BTR website, admin, and pelanggan portal.

It is based on the colors and typography already used in the codebase, not a new redesign palette.

## Brand Direction

- Tone: institutional, technical, trustworthy, clean
- Visual character: navy-led interface with strong amber accents
- Usage goal: keep public, admin, and pelanggan pages visually related

## Core Colors

### Primary

- `#354776`
- Main public brand blue
- Use for:
  - major headings
  - important text emphasis
  - public CTA text
  - icon accents
  - hover/focus states

### Primary Admin / Shell Blue

- `#1E3A6B`
- Darker operational blue used in admin and pelanggan shells
- Use for:
  - sidebar background
  - shell identity
  - admin title text
  - structural navigation

### Primary Dark

- `#162B52`
- Deeper navy for depth and active shell contrast
- Use for:
  - sidebar depth
  - darker hover/active shell surfaces
  - contrast layers behind `#1E3A6B`

## Accent Colors

### Secondary / Brand Yellow

- `#FDC300`
- Main accent color in admin and pelanggan UI
- Use for:
  - active wizard tabs
  - primary highlight buttons
  - key action emphasis
  - selected states

### Secondary Soft

- `#FFD84D`
- Lighter yellow companion
- Use for:
  - hover state for yellow buttons
  - lighter active fills
  - soft emphasis blocks

### Warm Accent Legacy

- `#E9B117`
- Older accent still present in legacy public CSS
- Use only when touching legacy pages that already depend on it
- Do not introduce this as the default new accent if `#FDC300` works

### Soft Amber Surface

- `#FEF3C7`
- Soft highlight background
- Use for:
  - category pills
  - warning-light surfaces
  - subtle metadata badges
  - non-destructive highlighted labels

## Neutral Colors

### Content Background

- `#F5F5F7`
- Main app background for admin and pelanggan

### Card Background

- `#FFFFFF`
- Main card and panel background

### Primary Text

- `#1E3A6B`
- Strong heading text in shell-driven views

### Body Text

- `#2E3A59`
- Main readable paragraph/body color in admin and pelanggan

### Muted Text

- `#6B7280`
- Secondary labels, descriptions, metadata

### Soft Border

- `#E5E7EB`
- Default border color for cards, inputs, separators

## Semantic Colors

### Success

- `#10B981`
- Use for:
  - success badges
  - completed state
  - positive confirmations

### Info

- `#2563EB`
- Use for:
  - informational badges
  - neutral operational status
  - non-critical notices

### Warning

- `#F59E0B`
- Use for:
  - caution states
  - pending operational states

### Danger

- `#DC2626`
- Use for:
  - destructive actions
  - delete buttons
  - validation errors
  - blocked or invalid state

## Typography

### Primary Typeface

- `Poppins`
- Current main type family across admin and much of public styling
- Use for:
  - headings
  - navigation
  - buttons
  - UI labels
  - form text

### Fallback Stack

- `'Poppins', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif`

### Notes

- Legacy public CSS also references:
  - `PoppinsNormal`
  - `PoppinsBold`
  - `Roboto`
- For new work, prefer standard `Poppins` unless working inside untouched legacy templates

## Component Usage Rules

### Buttons

- Primary action:
  - fill `#FDC300`
  - text `#1E3A6B` or `#2A3A61`
- Secondary action:
  - white background
  - border `#E5E7EB`
  - text `#354776`
- Hover:
  - do not invert to harsh black or pure white unless contrast requires it
  - prefer soft navy or soft yellow transitions

### Navigation

- Shell navigation:
  - use `#1E3A6B` / `#162B52`
- Public topbar text:
  - use navy family, not gray-black
- Active or selected nav:
  - use yellow accent fill or underline treatment

### Pills and Badges

- Category or soft highlight pills:
  - background `#FEF3C7`
  - text `#354776`
- Status badges:
  - success `#10B981`
  - warning `#F59E0B`
  - info `#2563EB`
  - danger `#DC2626`

### Cards

- Base card:
  - background `#FFFFFF`
  - border `#E5E7EB`
  - subtle shadow only
- Do not overuse gradients unless the page already uses them consistently

## Recommended Token Mapping

Use these as the preferred naming direction when normalizing styles later:

```css
:root {
  --btr-primary: #354776;
  --btr-primary-shell: #1E3A6B;
  --btr-primary-shell-dark: #162B52;
  --btr-secondary: #FDC300;
  --btr-secondary-soft: #FFD84D;
  --btr-accent-soft: #FEF3C7;
  --btr-bg: #F5F5F7;
  --btr-surface: #FFFFFF;
  --btr-text-strong: #1E3A6B;
  --btr-text-body: #2E3A59;
  --btr-text-muted: #6B7280;
  --btr-border: #E5E7EB;
  --btr-success: #10B981;
  --btr-info: #2563EB;
  --btr-warning: #F59E0B;
  --btr-danger: #DC2626;
}
```

## Consistency Notes

- Prefer `#354776` as the public-facing headline and identity blue
- Prefer `#1E3A6B` as the shell/system blue
- Prefer `#FDC300` as the main modern accent
- Keep `#E9B117` only for legacy pages until those pages are normalized
- Keep soft amber pills readable by using navy text instead of brown unless the component is explicitly warning-oriented

## Current Reality

The codebase still contains a mix of:
- newer design-system tokens in `admin.css` and `pelanggan.css`
- older public CSS files using `--primary: #354776` and `--secondary: #e9b117`
- some legacy vendor styles

So this document should guide future cleanup:
- normalize to one blue family
- normalize to one yellow family
- reduce legacy accent drift
