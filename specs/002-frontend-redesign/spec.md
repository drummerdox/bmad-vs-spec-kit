# Feature Specification: Frontend Redesign + SEO

**Feature Branch**: `002-frontend-redesign`  
**Created**: 2026-07-09  
**Status**: Draft  
**Input**: "Frontend redesign of the site. Need SEO optimization and trending colors of 2026."

## Problem Statement

The todo app has a functional UI and custom landing page, but pages lack a unified 2026-grade visual system, consistent SEO metadata, and discoverability signals for search engines and social sharing. Visitors should experience one cohesive product from landing → auth → app, with modern color trends that feel current without sacrificing accessibility.

## Design Direction (2026 Color Trends)

The redesign adopts a **“Electric Twilight + Cloud Dancer”** palette — aligned with 2026 trends: warm airy neutrals, cinematic mesh gradients, and sparing neon accents.

| Role | Direction | Mood |
|------|-----------|------|
| **Base neutral** | Warm off-white / cream (Cloud Dancer–inspired), not pure `#FFFFFF` | Calm, breathable canvas |
| **Primary** | Deep indigo → violet | Trust, focus, SaaS-native |
| **Secondary** | Soft cyan / teal | Freshness, clarity |
| **Accent (≤5% of UI)** | Magenta or electric coral micro-glow on CTAs, badges, focus rings | Energy without rainbow overload |
| **Dark surfaces** | Zinc/slate near-black (`#09090B` family), not flat `#000` | Depth for optional dark accents |
| **Gradients** | Mesh / soft-glow hero backgrounds — layered, not harsh linear rainbows | Cinematic, modern |

**Accessibility gate**: All text and interactive elements MUST meet **WCAG 2.2 AA** contrast (4.5:1 body, 3:1 large text/UI). Accent colors used for decoration only unless contrast-validated.

**Motion**: Subtle transitions allowed; respect `prefers-reduced-motion` for animations.

---

## User Scenarios & Testing *(mandatory)*

### User Story 1 — Discoverable Landing (Priority: P0)

A visitor finds the app via search or a shared link and understands what it is within 5 seconds.

**Why this priority**: SEO and conversion start on `/`.

**Independent Test**: View page source on `/` → unique title, meta description, OG tags present; visible h1 describes the product.

**Acceptance Scenarios**:

1. **Given** a guest opens `/`, **When** the page loads, **Then** exactly one `<h1>` states the product value (not “Laravel”).
2. **Given** a guest shares the URL on social media, **When** the link is unfurled, **Then** Open Graph title, description, and image preview appear correctly.
3. **Given** Google indexes the site, **When** crawlers read `/`, **Then** semantic landmarks (`header`, `main`, `footer`, `nav`) and JSON-LD structured data describe a WebApplication.
4. **Given** a guest on mobile, **When** they view the hero, **Then** primary CTA is visible without scrolling and uses the 2026 accent palette.

---

### User Story 2 — Cohesive Visual System (Priority: P1)

A user moving from landing → register → todos feels they are in the same product.

**Why this priority**: Trust and polish; reduces bounce after auth.

**Acceptance Scenarios**:

1. **Given** a guest on `/register`, **When** the page renders, **Then** colors, typography, button shapes, and logo match the landing page system.
2. **Given** a logged-in user on `/todos`, **When** they view the app, **Then** the same primary, neutral, and accent tokens apply (not legacy indigo-only hardcoding disconnected from landing).
3. **Given** any page, **When** viewed at 375px width, **Then** layout remains readable with no horizontal scroll.

---

### User Story 3 — SEO on Auth & App Pages (Priority: P1)

Authenticated pages still have correct titles and noindex where appropriate.

**Acceptance Scenarios**:

1. **Given** `/login` and `/register`, **When** viewed, **Then** each has a unique `<title>` and meta description suitable for indexing (login/register pages may be indexed or noindex — decision: **index allowed** with clear titles).
2. **Given** `/todos` (authenticated), **When** a crawler without session hits it, **Then** it redirects to login (existing behavior); logged-in users see `<title>` “My Tasks — {App Name}”.
3. **Given** any public page, **When** inspected, **Then** `<html lang="…">` matches site locale.

---

### User Story 4 — Friendly, Trend-Forward Todo UI (Priority: P1)

The todo experience feels welcoming and visually current.

**Acceptance Scenarios**:

1. **Given** a logged-in user with no tasks, **When** they open `/todos`, **Then** an illustrated empty state uses warm neutrals and friendly copy (not bare dashed box only).
2. **Given** the add-task form, **When** displayed, **Then** priority is chosen via pill controls (not native dropdown) with 2026 accent highlights on selection.
3. **Given** a completed task, **When** shown in the list, **Then** strikethrough and muted treatment preserve readability (WCAG contrast maintained).

---

### User Story 5 — Performance & SEO Hygiene (Priority: P2)

Pages load quickly enough for Core Web Vitals awareness in a demo context.

**Acceptance Scenarios**:

1. **Given** the landing page, **When** loaded, **Then** no render-blocking external images from third-party CDNs except fonts; hero visuals are CSS/SVG-based where possible.
2. **Given** `robots.txt`, **When** crawlers fetch it, **Then** public routes are allowed; no accidental block of `/`.
3. **Given** production build, **When** assets compile, **Then** CSS/JS are versioned via Vite manifest (existing) — no duplicate unbundled styles.

---

### Edge Cases

- User with `prefers-reduced-motion: reduce` sees no essential information hidden behind animation-only reveals.
- High-contrast / zoom 200%: text and buttons remain usable.
- Empty OG image fallback: social share still shows title + description without broken image icon.
- Logged-out user bookmarking `/todos` lands on login — no SEO duplicate content for todo list body.

---

## Requirements *(mandatory)*

### Functional Requirements — Visual Redesign

- **FR-001**: System MUST apply a unified 2026 color system (warm neutral base, indigo-violet primary, cyan secondary, sparse magenta/coral accent) across landing, auth, and todo pages.
- **FR-002**: System MUST use mesh or soft-glow gradient treatments on landing hero and key section backgrounds.
- **FR-003**: System MUST replace inconsistent legacy styling with shared components (logo, primary button, card, input field patterns).
- **FR-004**: System MUST align auth pages (login, register) visually with the landing redesign.
- **FR-005**: System MUST preserve all existing todo functionality (add, toggle, filter, delete) during visual refresh.
- **FR-006**: System MUST support optional subtle dark-accent sections (zinc-tinted) without requiring full dark-mode toggle in v1.

### Functional Requirements — SEO

- **FR-007**: Every public page MUST have a unique `<title>` (50–60 chars target) and meta description (150–160 chars target).
- **FR-008**: Landing page MUST include Open Graph (`og:title`, `og:description`, `og:url`, `og:type`, `og:image`) and Twitter Card tags.
- **FR-009**: Landing page MUST include JSON-LD `WebApplication` schema (name, description, applicationCategory, offers/free tier if applicable).
- **FR-010**: Pages MUST use semantic HTML5 landmarks and a single logical `<h1>` per page.
- **FR-011**: System MUST expose `robots.txt` allowing crawl of public routes.
- **FR-012**: System SHOULD provide `sitemap.xml` listing `/`, `/login`, `/register` (static generator acceptable).
- **FR-013**: All meaningful images MUST have descriptive `alt` text; decorative images MUST use `alt=""`.
- **FR-014**: Canonical URL tag on landing and auth pages pointing to preferred URL (avoid duplicate content).

### Non-Functional Requirements

- **NFR-001**: WCAG 2.2 AA contrast on all text and controls.
- **NFR-002**: Respect `prefers-reduced-motion` for non-essential animations.
- **NFR-003**: Mobile-first layout; touch targets ≥ 44×44px for primary actions.
- **NFR-004**: Feature tests (34 existing) MUST remain passing after redesign.

---

## Pages in Scope

| Page | Redesign | SEO |
|------|----------|-----|
| `/` (landing) | Hero, features, CTA, footer | Full OG + JSON-LD |
| `/login` | Match design system | Title + description |
| `/register` | Match design system | Title + description |
| `/todos` | Todo UI refresh | Title only (auth-gated) |
| App navigation | Logo, links, logout | — |
| `robots.txt` / `sitemap.xml` | — | New/updated |

**Out of scope (v1)**: Full dark-mode toggle, blog/content pages, i18n beyond `lang` attribute, paid SEO tools integration.

---

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: Lighthouse SEO score ≥ 90 on `/` (local Docker, production build).
- **SC-002**: All WCAG AA contrast checks pass on primary text/background pairs (manual or tooling).
- **SC-003**: User can identify product purpose from landing within 5 seconds (qualitative QA walkthrough).
- **SC-004**: Social share debugger (Facebook/Twitter/LinkedIn) shows correct preview for `/`.
- **SC-005**: Zero regression — `php artisan test` full suite green.
- **SC-006**: Visual consistency — PM/QA sign-off that landing, login, and todos share the same palette and component style.

---

## Open Questions (for `/speckit.plan`)

1. **OG image**: Generate static `public/og-image.png` (1200×630) or SVG-to-PNG build step?
2. **Font**: Keep Figtree or switch to a 2026 pairing (e.g. Figtree + display accent)?
3. **Dark mode**: Ship mood-dark hero only, or defer entirely to v2?

---

## References (design research, not implementation)

- Pantone 2026 COTY direction: warm neutrals (“Cloud Dancer”)
- Trend: cinematic mesh gradients, neon micro-accents, OKLCH-aware systems
- SEO: unique metadata, structured data, semantic HTML, crawlable public routes
