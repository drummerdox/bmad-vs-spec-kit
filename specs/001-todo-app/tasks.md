# Tasks: Todo List Application (Docker + Auth + TALL)

**Input**: Design documents from `specs/001-todo-app/`  
**Prerequisites**: plan.md ✅, spec.md ✅, constitution.md ✅

## Format: `[ID] [P?] [Story] Description`

- **[P]**: Can run in parallel
- **[Story]**: User story (US0–US4)

---

## Phase 1: Docker Setup

**Goal**: Reproducible local environment without host PHP/MySQL.

- [ ] T001 Create `docker/php/Dockerfile` (PHP 8.3-FPM, pdo_mysql, zip, pcntl, bcmath)
- [ ] T002 [P] Create `docker/nginx/default.conf` (root `/var/www/html/public`, fastcgi to `app:9000`)
- [ ] T003 Create `docker-compose.yml` with services: `nginx`, `app`, `mysql`
- [ ] T004 [P] Add `node` service with profile `dev` for Vite HMR on port 5173
- [ ] T005 [P] Create `Makefile` with targets: `up`, `down`, `shell`, `composer`, `artisan`, `test`, `npm`
- [ ] T006 Add `.env.example` with Docker MySQL credentials (`DB_HOST=mysql`)
- [ ] T007 Verify `make up` starts all containers and nginx responds on `:8080`

**Checkpoint**: `docker compose ps` shows healthy services; empty response or 502 until Laravel installed.

---

## Phase 2: Project Install

**Goal**: Laravel + TALL dependencies installed inside Docker.

- [ ] T008 Run `composer create-project laravel/laravel .` inside `app` container (or copy scaffold)
- [ ] T009 `composer require livewire/livewire`
- [ ] T010 `php artisan livewire:publish --config` (if needed)
- [ ] T011 `composer require laravel/breeze --dev && php artisan breeze:install livewire`
- [ ] T012 [P] `npm install && npm run build` (or `npm run dev` via node service)
- [ ] T013 Configure `.env`: APP_KEY, DB_* pointing at `mysql` service
- [ ] T014 `php artisan migrate` — users table from Breeze
- [ ] T015 [P] Initialize Spec Kit dirs: `.specify/`, `specs/`, `docs/bmad/`
- [ ] T016 Wire volume mounts in compose so host code syncs to `/var/www/html`

**Checkpoint**: Breeze auth pages render at `/login` and `/register`; migrations applied.

---

## Phase 3: Registration, Login & Base Flow (US0)

**Goal**: Full auth loop; todos route protected.

- [ ] T017 [US0] Confirm Breeze Livewire register form (name, email, password, confirmation)
- [ ] T018 [US0] Confirm login form with validation errors on bad credentials
- [ ] T019 [US0] Add logout link in app layout navigation
- [ ] T020 [US0] Redirect post-login to `/todos` (update `RouteServiceProvider` or `bootstrap/app.php`)
- [ ] T021 [US0] Add `auth` middleware group route `GET /todos` → placeholder view
- [ ] T022 [US0] Redirect guests hitting `/todos` to `/login`
- [ ] T023 [P] [US0] Customize welcome/home page with links to login and register

**Checkpoint**: Manual flow — register → todos page → logout → login → todos works.

---

## Phase 4: Foundational (Todo Schema)

**Goal**: Database ready for user-scoped todos.

- [ ] T024 Create `todos` migration: user_id FK, title, description, completed, priority, position
- [ ] T025 Create `Todo` model: `$fillable`, casts, `belongsTo(User)`, `User hasMany(Todo)`
- [ ] T026 Run migration inside container
- [ ] T027 Create app layout component or extend Breeze layout for todo page
- [ ] T028 Wire `/todos` view to host Livewire component (placeholder OK)

**Checkpoint**: `php artisan tinker` — `$user->todos()->create([...])` persists row.

---

## Phase 5: User Story 1 — Add a Todo (P1) 🎯 MVP

- [ ] T029 [US1] Scaffold Livewire `todo-list` component (class + view or SFC)
- [ ] T030 [US1] Load todos via `auth()->user()->todos()->orderBy('position')`
- [ ] T031 [US1] Implement `addTodo()` with validation (title 3–255, priority enum)
- [ ] T032 [US1] Build add-todo form UI with Tailwind + priority select
- [ ] T033 [US1] Display priority badges on list items

**Checkpoint**: Logged-in user adds todo; reload persists; other user's todos hidden.

---

## Phase 6: User Story 2 — Complete a Todo (P1)

- [ ] T034 [US2] Implement `toggle(Todo $todo)` scoped to current user
- [ ] T035 [US2] Checkbox UI with strikethrough for completed items

**Checkpoint**: Toggle works; unauthorized todo ID returns 404/403.

---

## Phase 7: User Story 3 — Filter Todos (P2)

- [ ] T036 [US3] Add `$filter` property and `setFilter()` method
- [ ] T037 [US3] Filter pills: All / Active / Done with count badges

**Checkpoint**: Counts match filtered results.

---

## Phase 8: User Story 4 — Delete a Todo (P2)

- [ ] T038 [US4] Implement `delete(Todo $todo)` with user scope
- [ ] T039 [US4] Delete button with `wire:confirm` prompt

**Checkpoint**: Full CRUD complete for authenticated user.

---

## Phase 9: Polish

- [ ] T040 [P] Alpine.js expand/collapse for descriptions
- [ ] T041 [P] Empty state when no todos match filter
- [ ] T042 [P] `wire:loading` opacity on list during requests
- [ ] T043 [P] Optional `TodoSeeder` for demo data (per-user)

---

## Phase 10: Tests

**Goal**: Automated coverage for P0/P1 stories; run via `make test`.

- [ ] T044 Configure `phpunit.xml` for in-memory SQLite (fast) or MySQL test DB
- [ ] T045 [P] Feature test: guest cannot access `/todos` (redirect login)
- [ ] T046 [P] Feature test: user can register and reach todos page
- [ ] T047 [P] Feature test: user can login with valid credentials
- [ ] T048 [P] Feature test: login fails with invalid password
- [ ] T049 Feature test: authenticated user can add todo (Livewire::test)
- [ ] T050 Feature test: title validation rejects < 3 chars
- [ ] T051 Feature test: user can toggle todo completion
- [ ] T052 Feature test: user cannot access another user's todo
- [ ] T053 Run full suite: `docker compose exec app php artisan test` — all green
- [ ] T054 Update README with Docker quick start and test commands

**Checkpoint**: All tests pass; spec acceptance scenarios covered.

---

## Dependencies & Execution Order

```text
Phase 1 (Docker)
    ↓
Phase 2 (Install)
    ↓
Phase 3 (Auth US0)
    ↓
Phase 4 (Schema)
    ↓
Phase 5 (US1 MVP) → Phase 6 (US2) → Phase 7 (US3) → Phase 8 (US4)
    ↓
Phase 9 (Polish)
    ↓
Phase 10 (Tests)
```

## Parallel Opportunities

- T002, T004, T005, T006 after T001
- T012, T015 parallel during Phase 2
- T023 parallel with T017–T022
- T040–T043 parallel in Phase 9
- T045–T048 parallel in Phase 10

## Implementation Strategy

1. **Docker first** — no Laravel until containers work
2. **Install + migrate** — Breeze auth tables
3. **Auth flow** — register/login/logout before any todo UI
4. **Todo MVP** — add + list only, then iterate
5. **Tests last** — but write auth tests as soon as US0 is done (optional early T045–T048)

**Status**: 🔲 Not started — run `/speckit.implement` to execute tasks.
