# Learning 2: Spec-Driven Todo App (TALL + Docker + Auth)

A **learning demo** for **Spec-Driven Development (SDD)** using [GitHub Spec Kit](https://github.com/github/spec-kit) and [BMAD](https://github.com/bmad-code-org/BMAD-METHOD) — implemented as a Laravel **TALL** stack todo list with **Docker** and **registration/login**.

**TALL** = **T**ailwind CSS · **A**lpine.js · **L**aravel · **L**ivewire

## What This Teaches

1. **Spec Kit flow** — constitution → spec → plan → tasks → implement  
2. **Docker-first** — Nginx, PHP-FPM, MySQL via Compose  
3. **Auth base flow** — register, login, logout (Laravel Breeze Livewire)  
4. **TALL todo CRUD** — Livewire component, user-scoped todos  
5. **Feature tests** — auth + todo acceptance scenarios  

## SDD Artifact Map

| Step | Phase | Spec Kit | Output |
|------|-------|----------|--------|
| 0 | Principles | `/speckit.constitution` | `.specify/memory/constitution.md` |
| 1 | Requirements | `/speckit.specify` | `specs/001-todo-app/spec.md` |
| 2 | Architecture | `/speckit.plan` | `specs/001-todo-app/plan.md` |
| 3 | Checklist | `/speckit.tasks` | `specs/001-todo-app/tasks.md` |
| 4 | Docker | Implement T001–T007 | `docker-compose.yml`, `docker/` |
| 5 | Install | Implement T008–T016 | Laravel + Breeze + Livewire |
| 6 | Auth | Implement T017–T023 | Register / login / protected `/todos` |
| 7 | Todos | Implement T024–T043 | Livewire todo-list |
| 8 | Tests | Implement T044–T054 | `tests/Feature/*` |

Full workflow: [docs/bmad/workflow.md](docs/bmad/workflow.md)

## Quick Start (after implementation)

```bash
cd learning_2

cp .env.example .env
make up
make artisan cmd="key:generate"
make artisan cmd="migrate"
make npm cmd="install && npm run build"

open http://localhost:8080
```

### Run Tests

```bash
make test
# or
docker compose exec app php artisan test --filter=TodoListTest
```

## Cursor / Spec Kit Commands

Skills in `.cursor/skills/`:

- `/speckit.constitution` — project principles  
- `/speckit.specify` — feature requirements  
- `/speckit.plan` — technical plan  
- `/speckit.tasks` — task breakdown  
- `/speckit.implement` — build from tasks  

## Features (from spec.md)

- Register, login, logout (Breeze Livewire)  
- User-scoped todos  
- Add todos (title, description, priority)  
- Toggle complete / active  
- Filter: All · Active · Done  
- Delete with confirmation  
- Feature tests for auth + todos  

## Stack

| Layer | Technology |
|-------|------------|
| Runtime | Docker Compose (Nginx, PHP 8.3, MySQL 8) |
| Backend | Laravel 12, PHP 8.3+ |
| Auth | Laravel Breeze (Livewire) |
| Reactive UI | Livewire 3 |
| CSS | Tailwind CSS 4 + Vite |
| JS | Alpine.js |
| Database | MySQL 8 |
| Tests | PHPUnit feature tests |

## Project Layout

```text
learning_2/
├── .cursor/skills/speckit-*/     # Spec Kit agent skills
├── .specify/memory/              # Constitution
├── specs/001-todo-app/           # spec → plan → tasks
├── docs/bmad/                    # BMAD workflow
├── docker/                       # Dockerfile, nginx config
├── docker-compose.yml
├── Makefile
└── (Laravel app after implement)
```

## Next Step

Artifacts are ready. Run in Cursor:

```
/speckit.implement
```

Or: *"Act as BMAD Developer, execute specs/001-todo-app/tasks.md starting Phase 1."*

## References

- [GitHub Spec Kit](https://github.github.com/spec-kit/)
- [BMAD Method](https://github.com/bmad-code-org/BMAD-METHOD)
- [Laravel Breeze](https://laravel.com/docs/starter-kits#breeze)
- [TALL Stack](https://tallstack.dev/)
