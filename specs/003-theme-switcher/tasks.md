# Tasks: Light / Dark Theme Switcher (Authenticated)

**Input**: Design documents from `specs/003-theme-switcher/`  
**Prerequisites**: plan.md ✅, spec.md ✅, constitution.md ✅, `001-todo-app` + `002-frontend-redesign` complete ✅

## Format: `[ID] [P?] [USn] Description`

- **[P]**: Can run in parallel (different files, no dependency on incomplete tasks)
- **[Story]**: User story from `spec.md` (US1–US5)

---

## Phase 1: Theme Infrastructure

**Goal**: Server reads cookie, `<html>` gets `dark` class, Tailwind dark mode enabled.

- [x] T001 Create `app/Support/Theme.php` with `COOKIE`, `LIGHT`, `DARK`, `resolve()`, `isDark()`
- [x] T002 Register view composer in `AppServiceProvider` — pass `$theme` to `layouts.app`
- [x] T003 Add `darkMode: 'class'` to `tailwind.config.js`
- [x] T004 [P] Map Tailwind semantic colors to CSS variables in `tailwind.config.js` (surface, ink, muted, primary, secondary, accent, border)
- [x] T005 Update `layouts/app.blade.php` — `@class(['dark' => $theme === 'dark'])` on `<html>`
- [x] T006 Create `resources/views/partials/theme-init.blade.php` (inline FOUC guard script)
- [x] T007 Include `theme-init` partial in `layouts/app.blade.php` `<head>` before `@vite`

**Checkpoint**: Logged-in user with `todolist_theme=dark` cookie → view-source shows `<html … class="dark">` (or `dark` in class list).

---

## Phase 2: CSS Dual-Theme Tokens

**Goal**: Light tokens unchanged; Monokai-inspired dark tokens swap via `html.dark`.

- [x] T008 Add `:root` CSS custom properties to `resources/css/app.css` (light values = current palette)
- [x] T009 Add `html.dark` CSS custom property overrides (Monokai palette per plan.md)
- [x] T010 [P] Update `.bg-surface-mesh` to use `var(--color-surface)`; add `html.dark .bg-surface-mesh` dark mesh gradients
- [x] T011 [P] Add `@layer components` priority badge classes (`.badge-priority-low`, `-medium`, `-high`) with dark variants
- [x] T012 Run `npm run build` and verify CSS variables compile; light theme visually unchanged on `/todos`

**Checkpoint**: Manually add `class="dark"` to `<html>` in devtools → authenticated page background becomes `#272822`, text `#F8F8F2`.

---

## Phase 3: Theme Switcher UI (US1, US2, US5)

**Goal**: User can toggle light/dark; choice written to cookie instantly.

- [x] T013 [US2] Create `resources/js/theme.js` — `themeSwitcher()` Alpine factory (`setTheme`, cookie write, 1-year max-age)
- [x] T014 Import `theme.js` in `resources/js/app.js`
- [x] T015 [US1] Create `components/theme-switcher.blade.php` — segmented Light/Dark control, sun/moon icons, `role="group"`, `aria-label="Theme"`, 44px touch targets
- [x] T016 [US5] Add `<x-theme-switcher />` to desktop nav in `livewire/layout/navigation.blade.php` (beside Log Out)
- [x] T017 [P] [US5] Add `<x-theme-switcher />` to mobile responsive menu in `navigation.blade.php`
- [x] T018 [US1] Verify toggle switches `document.documentElement` class and writes `todolist_theme` cookie without Livewire round-trip

**Checkpoint**: Login → toggle dark → reload → still dark; toggle light → reload → light; cookie visible in DevTools → Application → Cookies.

---

## Phase 4: App Shell & Shared Components (US4)

**Goal**: Navigation, layout header, and shared primitives respect both themes.

- [x] T019 [US4] Update `layouts/app.blade.php` — replace hardcoded `border-gray-100` with border token
- [x] T020 [US4] Update `livewire/layout/navigation.blade.php` — semantic surface/border tokens; remove light-only gray hovers
- [x] T021 [P] [US4] Update `components/nav-link.blade.php` — border/hover tokens instead of `gray-*`
- [x] T022 [P] [US4] Update `components/responsive-nav-link.blade.php` — surface hover tokens
- [x] T023 [P] [US4] Update `components/ui/card.blade.php` — border token
- [x] T024 [P] [US4] Update `components/ui/input.blade.php` — elevated bg, ink text, border token
- [x] T025 [P] [US4] Update `components/ui/button.blade.php` — verify dark contrast on primary/secondary variants
- [x] T026 [P] [US4] Update Breeze `text-input.blade.php`, `input-label.blade.php`, `input-error.blade.php` for dark-aware styling
- [x] T027 [P] [US4] Update Breeze `primary-button.blade.php`, `secondary-button.blade.php`, `danger-button.blade.php` for dark-aware styling
- [x] T028 [P] [US4] Update `components/modal.blade.php` — dark elevated surface for panel

**Checkpoint**: Dark theme on `/todos` — nav, header, and shared inputs render without white/gray leaks.

---

## Phase 5: Todo List Dark Coverage (US1, US4)

**Goal**: Full todo UI uses semantic tokens; Monokai priority colors in dark mode.

- [x] T029 [US4] Migrate add-task form in `livewire/todo-list.blade.php` — replace `bg-white`, `gray-*`, `from-white` with semantic tokens
- [x] T030 [P] [US4] Migrate stat filter cards — border/surface tokens; active state uses secondary accent
- [x] T031 [P] [US4] Migrate task list items — borders, checkbox, loading overlay to semantic tokens
- [x] T032 [P] [US4] Replace priority badges with `.badge-priority-*` classes; priority accent bars use Monokai colors in dark
- [x] T033 [P] [US4] Migrate empty states — surface/border/ink/muted tokens
- [x] T034 [US4] Grep `todo-list.blade.php` for remaining `gray-|bg-white` — eliminate or justify each

**Checkpoint**: Dark theme todo CRUD manual test — add, toggle, filter, delete all work; no white cards visible.

---

## Phase 6: Profile Dark Coverage (US4)

**Goal**: Profile page and Livewire forms match dark palette.

- [x] T035 [US4] Update `profile.blade.php` — card wrappers `bg-surface-elevated`, header `text-ink`
- [x] T036 [P] [US4] Update `livewire/profile/update-profile-information-form.blade.php` — token-consistent labels/inputs
- [x] T037 [P] [US4] Update `livewire/profile/update-password-form.blade.php` — token-consistent styling
- [x] T038 [P] [US4] Update `livewire/profile/delete-user-form.blade.php` — token-consistent styling + modal

**Checkpoint**: Dark theme on `/profile` — all three form sections readable; validation errors visible.

---

## Phase 7: Guest Scope Verification (US3)

**Goal**: Public pages unchanged; switcher absent for guests.

- [x] T039 [US3] Confirm `layouts/guest.blade.php` and `layouts/marketing.blade.php` do NOT include `theme-init` partial
- [x] T040 [US3] Confirm `welcome.blade.php` and auth Volt pages do NOT render `<x-theme-switcher />`
- [x] T041 [US3] Manual: set dark cookie → logout → `/` and `/login` remain light with no switcher

**Checkpoint**: Guest pages visually identical to pre-feature; no `dark` class on guest layout `<html>`.

---

## Phase 8: Tests & QA

**Goal**: Automated coverage + no regressions; spec success criteria met.

- [x] T042 [US2] Create `tests/Feature/ThemeSwitcherTest.php` — default light without cookie on `/todos`
- [x] T043 [P] [US2] ThemeSwitcherTest — dark cookie renders `dark` on `/todos` and `/profile`
- [x] T044 [P] [US2] ThemeSwitcherTest — invalid cookie (`purple`) defaults to light
- [x] T045 [P] [US1] ThemeSwitcherTest — switcher present on authenticated `/todos`
- [x] T046 [P] [US3] ThemeSwitcherTest — switcher absent on `/` and `/login`
- [x] T047 Run full suite: `docker compose exec app php artisan test` — all tests green
- [x] T048 [P] [US1] Manual: toggle dark ↔ light on desktop and mobile nav (≤2 taps, SC-001)
- [x] T049 [P] [US2] Manual: dark → reload `/todos` + `/profile`; logout → login → dark persists (SC-002)
- [x] T050 [P] Manual: hard refresh with dark cookie — no prolonged light flash (SC-008)
- [x] T051 [P] Manual: contrast spot-check — `#f8f8f2` on `#272822`, primary buttons in dark (SC-005)
- [x] T052 Manual: light theme regression — default `/todos` matches pre-feature appearance (SC-003)
- [x] T053 Mark tasks complete in this file after QA sign-off

**Checkpoint**: Spec success criteria SC-001 through SC-008 satisfied; ThemeSwitcherTest green.

---

## Dependencies & Execution Order

```text
Phase 1 (Infrastructure)
    ↓
Phase 2 (CSS Tokens) — requires T003–T004
    ↓
Phase 3 (Switcher UI) — requires Phase 1–2 for visual feedback
    ↓
Phase 4 (App Shell) — requires Phase 2
    ↓
Phase 5 (Todo List) ──┐
    ↓                 │ Phase 5 and 6 parallel after Phase 4
Phase 6 (Profile) ────┘
    ↓
Phase 7 (Guest Scope) — can start after Phase 3
    ↓
Phase 8 (Tests & QA) — requires Phases 1–7
```

## Parallel Opportunities

- T004 parallel with T001–T003 in Phase 1 (different files)
- T010, T011 parallel in Phase 2
- T017 parallel with T016 in Phase 3
- T021–T028 parallel in Phase 4 (distinct component files)
- T030–T033 parallel in Phase 5
- T036–T038 parallel in Phase 6
- T043–T046 parallel in Phase 8 (same test file — write sequentially, then run together)
- T048–T051 parallel manual QA in Phase 8

## User Story Mapping

| Story | Priority | Tasks |
|-------|----------|-------|
| US1 Toggle theme while logged in | P0 | T015–T018, T029–T034, T045, T048, T052 |
| US2 Persist theme in cookie | P0 | T001–T002, T005–T007, T013–T014, T042–T044, T049 |
| US3 Authenticated scope only | P1 | T039–T041, T046 |
| US4 Cohesive dark coverage | P1 | T008–T012, T019–T038 |
| US5 Discoverable control | P2 | T016–T017 |

## Implementation Strategy

1. **Infrastructure before UI** — cookie read + `dark` class must work before switcher matters
2. **CSS variables before blade sweep** — token swap reduces per-file `dark:` duplication
3. **Switcher early** — enables manual QA while migrating views
4. **Todo list before profile** — highest hardcoded-gray count; biggest visual risk
5. **Tests last** — but run `php artisan test` after Phases 4–6 as smoke checks

## Notes

- **No Docker / migration / route changes** for this feature
- **Out of scope**: guest page theming, `prefers-color-scheme` auto mode, DB user preference
- **Cookie spec**: `todolist_theme=light|dark`; path `/`; max-age 1 year; `SameSite=Lax`

**Status**: ✅ Complete — `/speckit.implement` executed 2026-07-12. 46 tests passing.
