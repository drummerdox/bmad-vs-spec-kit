# Project Constitution

> Spec Kit artifact — governing principles for the Todo App (TALL Stack + Docker).
> Created via `/speckit.constitution` (BMAD Analyst + PM review).

## Core Principles

### I. Spec-First Development
Every feature starts as a written specification in `specs/`. Code is generated from specs, not the reverse. No implementation without an approved `spec.md` and `plan.md`.

### II. TALL Stack Consistency
- **Tailwind CSS** for all styling — no inline styles, no custom CSS unless justified in plan.
- **Alpine.js** for lightweight client interactivity (expand/collapse, toggles).
- **Laravel** for routing, validation, persistence, auth, and domain logic.
- **Livewire** for reactive UI without a separate SPA build.

### III. Docker-First Local Development
- All services run via `docker compose` — no host PHP/MySQL required.
- Same compose file works on macOS, Linux, and WSL.
- `.env` values target Docker service hostnames (`mysql`, `redis`).

### IV. Auth Before Features
- Registration, login, and logout must work before todo CRUD.
- Todos are scoped to the authenticated user (`user_id` foreign key).
- Guest users are redirected to login; no anonymous todo access.

### V. Test-Driven Quality
- Feature tests cover auth flows and todo happy paths + validation failures.
- Tests run inside the PHP container: `docker compose exec app php artisan test`.
- Tests must pass before marking tasks complete.

### VI. Simplicity Over Cleverness
This is a learning demo. Prefer readable Laravel conventions over abstractions. One Livewire component per screen unless complexity demands split.

### VII. User Experience
- Immediate feedback on actions (Livewire loading states).
- Accessible form labels and keyboard-friendly controls.
- Clear empty states and confirmation on destructive actions.

## Technology Constraints

| Layer | Choice | Rationale |
|-------|--------|-----------|
| Framework | Laravel 12+ | Stable LTS track, first-party Livewire integration |
| UI | Livewire 3 + Alpine | TALL stack standard |
| CSS | Tailwind 4 via Vite | Ships with modern Laravel |
| Auth | Laravel Breeze (Livewire stack) | Minimal, TALL-native auth scaffolding |
| Database | MySQL 8 (Docker) | Production-like local dev |
| Runtime | Docker Compose | PHP-FPM + Nginx + MySQL |
| Testing | PHPUnit feature tests | Auth + todo coverage |

## Development Workflow

1. **Constitution** (this file) — immutable unless explicitly amended
2. **Specify** — `specs/NNN-feature/spec.md` (what & why)
3. **Plan** — `specs/NNN-feature/plan.md` (how & stack)
4. **Tasks** — `specs/NNN-feature/tasks.md` (executable checklist)
5. **Implement** — code changes tracked against tasks
6. **BMAD QA** — review against acceptance criteria

## Governance

- Constitution amendments require explicit documentation in `specs/` changelog.
- Specs override ad-hoc prompts during implementation.
- Complexity must be justified in `plan.md` before adding dependencies.
