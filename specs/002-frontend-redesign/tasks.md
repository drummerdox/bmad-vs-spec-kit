# Tasks: Frontend Redesign + SEO

**Input**: Design documents from `specs/002-frontend-redesign/`  
**Prerequisites**: plan.md ✅, spec.md ✅, constitution.md ✅, `001-todo-app` complete ✅

## Format: `[ID] [P?] [USn] Description`

- **[P]**: Can run in parallel
- **[Story]**: User story from `spec.md` (US1–US5)

---

## Phase 1: Design Tokens & CSS Utilities

**Goal**: 2026 “Electric Twilight + Cloud Dancer” palette available as Tailwind utilities.

- [x] T001 Add `@theme` OKLCH color tokens to `resources/css/app.css` (surface, primary, secondary, accent, ink, muted)
- [x] T002 Add mesh-gradient utility classes in `@layer utilities` (hero-mesh, surface-mesh)
- [x] T003 [P] Add `prefers-reduced-motion` guard for transition utilities
- [x] T004 Extend Figtree font weights to 700 in layout head links
- [x] T005 Run `make build` and verify new token classes compile

**Checkpoint**: `bg-primary-600`, `bg-surface`, `bg-accent-500` render in a scratch Blade snippet.

---

## Phase 2: SEO Layer

**Goal**: Centralized metadata and crawlability (US1, US3, US5).

- [x] T006 [US1] Create `components/seo/meta.blade.php` (title, description, canonical, OG, Twitter)
- [x] T007 [P] [US1] Create `components/seo/json-ld-app.blade.php` (WebApplication schema)
- [x] T008 [P] [US5] Update `public/robots.txt` — Allow `/`, Sitemap URL
- [x] T009 [P] [US5] Create `public/sitemap.xml` with `/`, `/login`, `/register`
- [x] T010 [P] [US1] Add `public/og-image.png` (1200×630, branded gradient + tagline)
- [x] T011 [US1] Set `config/app.php` name to `Todo App` (if not already)

**Checkpoint**: View-source on `/` shows meta component output; `/robots.txt` and `/sitemap.xml` return 200.

---

## Phase 3: Shared UI Components

**Goal**: Reusable brand and form primitives (US2).

- [x] T012 [US2] Create `components/brand/logo.blade.php` (icon + wordmark, links to `/`)
- [x] T013 [P] [US2] Create `components/ui/button.blade.php` (variants: primary, secondary, ghost)
- [x] T014 [P] [US2] Create `components/ui/card.blade.php` (elevated surface, rounded-2xl)
- [x] T015 [P] [US2] Create `components/ui/input.blade.php` (rounded-xl, primary focus ring)
- [x] T016 [US2] Update Breeze `primary-button.blade.php` classes to use design tokens
- [x] T017 [P] [US2] Update Breeze `text-input.blade.php` classes to match `ui/input`
- [x] T018 [P] [US2] Update Breeze `nav-link.blade.php` and `responsive-nav-link.blade.php` for primary/accent active states

**Checkpoint**: Storybook-style sanity — render button, card, input on a temp view or landing partial.

---

## Phase 4: Marketing Layout + Landing (US1, US2)

**Goal**: SEO-optimized landing with 2026 visuals.

- [x] T019 [US1] Create `layouts/marketing.blade.php` (head with `<x-seo.meta>`, fonts, vite, JSON-LD slot)
- [x] T020 [US1] Refactor `welcome.blade.php` to extend marketing layout — single `<h1>`, semantic landmarks
- [x] T021 [US2] Landing hero: mesh gradient, warm surface, accent CTA with glow shadow
- [x] T022 [P] [US2] Feature section: replace ad-hoc cards with `<x-ui.card>`
- [x] T023 [P] [US2] Spec Kit / stack section: dark `bg-ink` band with tech pills
- [x] T024 [P] [US2] “How it works” steps with primary numbered circles
- [x] T025 [US1] Wire SEO meta: title “Organize your day with Todo App”, description per plan matrix
- [x] T026 [P] [US2] Update `livewire/welcome/navigation.blade.php` to use `<x-ui.button>` variants

**Checkpoint**: Lighthouse SEO on `/` ≥ 90; social meta tags present; no Laravel docs links.

---

## Phase 5: Guest Layout + Auth Pages (US2, US3)

**Goal**: Login/register visually match landing; per-page SEO.

- [x] T027 [US2] Redesign `layouts/guest.blade.php` — surface mesh bg, `<x-brand.logo>`, `<x-ui.card>` slot
- [x] T028 [US3] Add per-page SEO to guest layout via `@stack('seo')` or Volt layout props
- [x] T029 [US3] Login page: unique title + description; product-friendly heading copy
- [x] T030 [P] [US3] Register page: unique title + description; product-friendly heading copy
- [x] T031 [US2] Style login/register forms — rounded inputs, accent focus, primary submit button
- [x] T032 [P] [US2] Style forgot-password and reset-password pages (token-consistent, lower priority visuals)

**Checkpoint**: Visual walkthrough `/` → `/register` → submit — consistent palette and components.

---

## Phase 6: App Shell + Todo UI (US2, US4)

**Goal**: Authenticated area matches marketing; todo list uses design tokens.

- [x] T033 [US3] Add `<x-seo.meta title="My Tasks">` to `todos/index.blade.php` or app layout slot
- [x] T034 [US2] Update `layouts/app.blade.php` — surface gradient background, meta slot
- [x] T035 [US2] Redesign `livewire/layout/navigation.blade.php` — brand logo, primary nav, accent active state
- [x] T036 [US4] Swap `livewire/todo-list.blade.php` indigo classes → primary/accent/surface/muted tokens
- [x] T037 [P] [US4] Todo stat cards: soft-glow hover, secondary accent on active filter
- [x] T038 [P] [US4] Todo empty states: warm neutrals, friendly copy per filter (NFR-001 contrast)
- [x] T039 [US4] Completed tasks: `text-muted` + line-through (not whole-card opacity)
- [x] T040 [P] [US2] Update `todos/index.blade.php` page wrapper to match new shell

**Checkpoint**: Logged-in user sees cohesive UI; all todo CRUD still works manually.

---

## Phase 7: QA & Tests (US5)

**Goal**: No regressions; SEO smoke coverage.

- [x] T041 [US5] Create `tests/Feature/SeoTest.php` — `/` has og:title and JSON-LD; robots + sitemap 200
- [x] T042 [P] [US5] SeoTest: `/login` and `/register` have unique `<title>` tags
- [x] T043 Run full suite: `make test` — all 34+ tests green
- [x] T044 [P] [US5] Manual Lighthouse SEO ≥ 90 on `/` (production Vite build)
- [x] T045 [P] [US5] Manual contrast check: primary-600 on surface, accent-500 on white, muted completed text
- [x] T046 [US5] Manual flow: landing → register → todos → logout → login (spec US2 acceptance)
- [x] T047 Mark all tasks complete in this file; update README with redesign note

**Checkpoint**: Spec success criteria SC-001 through SC-006 satisfied.

---

## Dependencies & Execution Order

```text
Phase 1 (Tokens)
    ↓
Phase 2 (SEO) ─────────────┐
    ↓                      │ Phase 2 partial parallel with Phase 3 after T005
Phase 3 (Components) ◄─────┘
    ↓
Phase 4 (Landing) — requires Phases 1–3
    ↓
Phase 5 (Auth) — requires Phase 3; SEO meta from Phase 2
    ↓
Phase 6 (App + Todos) — requires Phase 3
    ↓
Phase 7 (QA)
```

## Parallel Opportunities

- T003, T004 parallel during Phase 1
- T007, T008, T009, T010 parallel in Phase 2
- T013, T014, T015, T017, T018 parallel in Phase 3
- T022, T023, T024, T026 parallel in Phase 4
- T030, T032 parallel in Phase 5
- T037, T038, T040 parallel in Phase 6
- T042, T044, T045 parallel in Phase 7

## User Story Mapping

| Story | Priority | Tasks |
|-------|----------|-------|
| US1 Discoverable landing | P0 | T006–T007, T010–T011, T019–T020, T025 |
| US2 Cohesive visual system | P1 | T012–T018, T021–T024, T026–T027, T031, T034–T035, T040 |
| US3 SEO auth/app pages | P1 | T028–T030, T033 |
| US4 Trend-forward todo UI | P1 | T036–T039 |
| US5 Performance & SEO hygiene | P2 | T008–T009, T041–T045 |

## Implementation Strategy

1. **Tokens first** — everything else references semantic colors
2. **SEO early** — landing can ship with meta before full visual polish
3. **Components before pages** — avoid duplicating class strings
4. **Landing → auth → app** — outward-in user journey
5. **Tests last** — but run `make test` after Phases 4–6 as smoke checks

**Status**: ✅ Complete — `/speckit.implement` executed 2026-07-09. 39 tests passing.
