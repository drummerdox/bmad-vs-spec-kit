# Feature Specification: Light / Dark Theme Switcher (Authenticated)

**Feature Branch**: `003-theme-switcher`  
**Created**: 2026-07-12  
**Status**: Draft  
**Input**: "On logged-in user I need black and white theme switcher. Save existing theme as light, for black theme use Monokai theme as reference. Save theme in user cookies."

## Problem Statement

Logged-in users spend most of their time in the todo app and profile screens. The current visual system is light-only (warm neutral base from the 2026 redesign). Users who prefer dark environments — or who work in low-light settings — have no way to switch appearance without leaving the app. A simple **light / dark** toggle for authenticated pages will improve comfort and accessibility while preserving the existing look as the default **light** theme.

## Design Direction

### Light theme (default)

The **light** theme MUST preserve the current authenticated-app appearance from the frontend redesign: warm off-white surfaces, indigo-violet primary, cyan secondary, and sparse magenta/coral accents. No visual regression for users who never change the setting.

### Dark theme (Monokai-inspired)

The **dark** theme uses the **Monokai** color scheme as a reference — not a pixel-perfect clone of the Monokai editor theme, but the same mood: charcoal background, high-contrast cream text, and vivid accent colors for interactive states and priority indicators.

| Role | Monokai reference | Application intent |
|------|-------------------|--------------------|
| **Background** | `#272822` | Page and card surfaces |
| **Foreground / body text** | `#F8F8F2` | Primary readable text |
| **Muted text** | `#75715E` | Secondary labels, placeholders |
| **Selection / elevated surface** | `#49483E` | Borders, hover fills, input backgrounds |
| **Primary accent** | `#66D9EF` (cyan) | Links, focus rings, selected controls |
| **Secondary accent** | `#AE81FF` (purple) | Secondary highlights |
| **Success / high priority** | `#A6E22E` (green) | Positive states, priority badges where appropriate |
| **Warning / medium priority** | `#E6DB74` (yellow) | Caution or medium priority |
| **Destructive / high urgency** | `#F92672` (pink-red) | Delete actions, critical priority |
| **Orange accent** | `#FD971F` | Optional warm accent for CTAs |

**Accessibility gate**: Dark theme text and controls MUST meet **WCAG 2.2 AA** contrast (4.5:1 body, 3:1 large text/UI). Monokai accent colors used decoratively unless contrast-validated on dark backgrounds.

**Motion**: Theme switch SHOULD apply with a brief, non-blocking transition; respect `prefers-reduced-motion`.

---

## User Scenarios & Testing *(mandatory)*

### User Story 1 — Toggle Theme While Logged In (Priority: P0)

A logged-in user switches between light and dark appearance from anywhere in the authenticated app.

**Why this priority**: Core value — without a visible control, the feature does not exist.

**Independent Test**: Login → open `/todos` → switch to dark → entire app shell and todo UI reflect dark theme → switch back to light → appearance matches pre-feature light theme.

**Acceptance Scenarios**:

1. **Given** a logged-in user on `/todos` with no prior theme cookie, **When** the page loads, **Then** the **light** theme is applied (current default appearance).
2. **Given** a logged-in user, **When** they activate the theme switcher and choose **dark**, **Then** the app layout, navigation, todo list, forms, and profile pages immediately use the Monokai-inspired dark palette.
3. **Given** a logged-in user on dark theme, **When** they switch to **light**, **Then** the UI returns to the existing light design system with no missing or broken styles.
4. **Given** a logged-in user, **When** they use the switcher on mobile (responsive nav), **Then** the same light/dark options are available and usable (touch target ≥ 44×44px).

---

### User Story 2 — Persist Theme in Cookie (Priority: P0)

A user's theme choice survives page reloads, navigation, and return visits on the same browser.

**Why this priority**: Explicit user requirement; ephemeral toggles feel broken.

**Independent Test**: Set dark → reload `/todos` → still dark → close tab → reopen site and login → still dark on authenticated pages.

**Acceptance Scenarios**:

1. **Given** a logged-in user selects **dark**, **When** they reload the page or navigate to `/profile`, **Then** dark theme remains active.
2. **Given** a logged-in user selects **light**, **When** they reload or navigate, **Then** light theme remains active.
3. **Given** a user had **dark** stored in a cookie, **When** they log out and log back in on the same browser, **Then** dark theme is still applied on authenticated pages (cookie is browser-scoped, not session-scoped).
4. **Given** a user clears site cookies, **When** they log in again, **Then** the app falls back to **light** (default).

---

### User Story 3 — Authenticated Scope Only (Priority: P1)

Guests and public marketing/auth pages are unaffected; theme switching is a logged-in experience.

**Why this priority**: User asked for switcher "on logged-in user"; keeps landing/SEO pages stable.

**Acceptance Scenarios**:

1. **Given** a guest on `/`, `/login`, or `/register`, **When** the page loads, **Then** no theme switcher is shown and pages use the existing public light styling.
2. **Given** a guest, **When** they later log in, **Then** the authenticated app reads the theme cookie (if any) or defaults to light.
3. **Given** a logged-in user on dark theme, **When** they log out, **Then** they are redirected to a public page that does not apply the dark authenticated palette.

---

### User Story 4 — Cohesive Dark Coverage (Priority: P1)

Dark theme applies consistently across all authenticated surfaces, not only the page background.

**Acceptance Scenarios**:

1. **Given** dark theme active, **When** the user views the todo list (empty state, filters, add form, priority pills, completed items), **Then** all components use dark-theme tokens — no light-only hardcoded surfaces remain visible.
2. **Given** dark theme active, **When** the user opens `/profile` (password, profile info, delete account forms), **Then** forms, labels, errors, and buttons match the dark palette.
3. **Given** dark theme active, **When** the user triggers Livewire loading states or validation errors, **Then** feedback remains readable and visually consistent.

---

### User Story 5 — Discoverable Control (Priority: P2)

Users can find the switcher without documentation.

**Acceptance Scenarios**:

1. **Given** a logged-in user on desktop, **When** they view the app navigation, **Then** a theme switcher (light/dark) is visible near other account actions (e.g. beside Log Out).
2. **Given** a logged-in user on mobile, **When** they open the responsive menu, **Then** the theme switcher is reachable without hunting in settings.

---

### Edge Cases

- Invalid or tampered cookie value (e.g. `theme=purple`) → treat as **light** default; optionally reset cookie on next valid toggle.
- Cookie blocked by browser → theme works for current session via client state but may not persist; no error blocking app use.
- User switches theme mid-form-entry → form data and focus are preserved; only colors change.
- `prefers-reduced-motion: reduce` → no essential information hidden; transition may be instant.
- High zoom (200%) and keyboard navigation → switcher remains operable and labeled for assistive tech.
- Two browser tabs: change theme in one tab → other tab reflects updated theme on next navigation or reload (full cross-tab sync is optional, not required v1).

---

## Requirements *(mandatory)*

### Functional Requirements — Theme Switcher

- **FR-001**: System MUST expose exactly two themes for authenticated users: **light** and **dark**.
- **FR-002**: **Light** MUST match the current authenticated-app visual system (post–frontend-redesign) without intentional visual changes for users who never toggle.
- **FR-003**: **Dark** MUST follow the Monokai-inspired palette defined in Design Direction (charcoal base, cream text, Monokai accent family for interactive and semantic colors).
- **FR-004**: System MUST provide a theme switcher control on all authenticated pages (`/todos`, `/profile`, and shared app navigation).
- **FR-005**: System MUST persist the user's theme choice in a **browser cookie** (values: `light` or `dark`); MUST NOT require database storage or user profile fields for theme v1.
- **FR-006**: System MUST apply the stored theme on initial page render for authenticated routes (no prolonged flash of wrong theme).
- **FR-007**: System MUST default to **light** when no valid theme cookie exists.
- **FR-008**: System MUST NOT show the theme switcher on guest/public pages (`/`, `/login`, `/register`).
- **FR-009**: Theme switching MUST NOT alter todo data, auth state, or form submissions.
- **FR-010**: All text and interactive elements in both themes MUST meet WCAG 2.2 AA contrast.

### Functional Requirements — Persistence

- **FR-011**: Theme cookie MUST survive browser refresh and subsequent authenticated visits on the same device/browser.
- **FR-012**: Theme cookie SHOULD use a stable, app-specific name and reasonable expiry (e.g. 1 year) so preference persists across sessions.
- **FR-013**: Logging out MUST NOT delete the theme cookie (preference is browser-level, not account-level).

### Non-Functional Requirements

- **NFR-001**: Respect `prefers-reduced-motion` for theme transition animations.
- **NFR-002**: Mobile-first; switcher touch targets ≥ 44×44px.
- **NFR-003**: Existing feature tests MUST remain passing; new tests cover cookie persistence and authenticated scope.
- **NFR-004**: No regression in todo CRUD, auth, or profile flows.

---

## Key Entities

| Entity | Description |
|--------|-------------|
| **Theme preference** | User's chosen appearance: `light` or `dark`. Stored in a client cookie; scoped to browser, not user account record. |
| **Theme cookie** | Named client storage holding the theme preference value; read on authenticated page load, written on toggle. |

---

## Pages in Scope

| Page | Theme switcher | Theming |
|------|----------------|---------|
| `/todos` | Yes | Light + dark |
| `/profile` | Yes | Light + dark |
| App navigation (authenticated layout) | Yes | Light + dark |
| `/` (landing) | No | Light only (existing) |
| `/login`, `/register` | No | Light only (existing) |

**Out of scope (v1)**: System/auto theme from `prefers-color-scheme`, per-user server-side theme sync across devices, more than two themes, theme switcher on guest pages, theme tied to user database profile, blog or other future routes.

---

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: Logged-in user can switch light ↔ dark from navigation in ≤ 2 clicks/taps.
- **SC-002**: After selecting dark, reload keeps dark theme on `/todos` and `/profile` (cookie verified).
- **SC-003**: Light theme is visually equivalent to current authenticated app (PM/QA sign-off).
- **SC-004**: Dark theme background and body text align with Monokai reference values (`#272822` / `#F8F8F2` family); accents use Monokai palette roles.
- **SC-005**: WCAG AA contrast passes for primary text/background pairs in both themes.
- **SC-006**: Guest pages show no switcher and unchanged public styling.
- **SC-007**: Full test suite green including new theme persistence and scope tests.
- **SC-008**: No visible flash of light theme on dark preference during authenticated page load (qualitative check).

---

## Open Questions (for `/speckit.plan`)

1. **Cookie name & expiry**: Fixed name (e.g. `theme`) vs prefixed app name; 1-year vs session cookie?
2. **Switcher UX**: Icon toggle (sun/moon) vs labeled segmented control ("Light | Dark")?
3. **FOUC prevention**: Inline script in layout head vs server-read cookie on first paint — tradeoff for plan.
4. **Dark mesh backgrounds**: Reuse gradient utilities with dark tokens or flat Monokai `#272822` surfaces only?
5. **Profile sub-forms**: Any third-party or Breeze components needing one-off dark overrides?

---

## References (design research, not implementation)

- Monokai (Wimer Hazenberg) — canonical editor palette for dark theme mood and accent roles
- Existing light system — `specs/002-frontend-redesign/spec.md` (Electric Twilight + Cloud Dancer)
- WCAG 2.2 AA contrast requirements for dual-theme support
