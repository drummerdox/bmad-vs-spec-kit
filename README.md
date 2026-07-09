# Learning 2: Spec-Driven Todo App (TALL + Docker + Auth)

A **learning demo** for **Spec-Driven Development (SDD)** using [GitHub Spec Kit](https://github.com/github/spec-kit) and [BMAD](https://github.com/bmad-code-org/BMAD-METHOD) — implemented as a Laravel **TALL** stack todo list with **Docker** and **registration/login**.

**TALL** = **T**ailwind CSS · **A**lpine.js · **L**aravel · **L**ivewire

## Quick Start

```bash
cd learning_2

cp .env.example .env
make up
make artisan cmd="key:generate"
make artisan cmd="migrate"

make build   # npm install + vite build via node container

open http://localhost:8081
# Register → auto-redirect to /todos
```

### Run Tests

```bash
make test
# 39 tests, all passing
```

## SDD Artifact Map

| Phase | Spec Kit | Output |
|-------|----------|--------|
| 0 | `/speckit.constitution` | `.specify/memory/constitution.md` |
| 1 | `/speckit.specify` | `specs/001-todo-app/spec.md` |
| 2 | `/speckit.plan` | `specs/001-todo-app/plan.md` |
| 3 | `/speckit.tasks` | `specs/001-todo-app/tasks.md` |
| 4 | `/speckit.implement` | Application code |

Full workflow: [docs/bmad/workflow.md](docs/bmad/workflow.md)

## Features

- Register, login, logout (Laravel Breeze Livewire)
- User-scoped todos (`user_id` FK)
- Add todos (title, description, priority)
- Toggle complete / active
- Filter: All · Active · Done (with counts)
- Delete with confirmation
- 39 feature tests (auth + todos + SEO)

## Frontend Redesign (`002-frontend-redesign`)

- **Electric Twilight + Cloud Dancer** design tokens (primary, accent, surface, ink, muted)
- SEO-optimized marketing landing with Open Graph, Twitter cards, and JSON-LD
- Shared UI components (`x-brand.logo`, `x-ui.button`, `x-ui.card`, `x-ui.input`)
- Cohesive auth pages and authenticated app shell
- Dynamic `/robots.txt` and `/sitemap.xml` routes

## Stack

| Layer | Technology |
|-------|------------|
| Runtime | Docker Compose (Nginx, PHP 8.3, MySQL 8) |
| Backend | Laravel 13, PHP 8.3+ |
| Auth | Laravel Breeze (Livewire + Volt) |
| Reactive UI | Livewire 3 |
| CSS | Tailwind CSS 4 + Vite |
| JS | Alpine.js |
| Database | MySQL 8 (Docker) |
| Tests | PHPUnit (SQLite in-memory for tests) |

## Project Layout

```text
learning_2/
├── .cursor/skills/speckit-*/     # Spec Kit agent skills
├── .specify/memory/              # Constitution
├── specs/001-todo-app/           # spec → plan → tasks
├── specs/002-frontend-redesign/  # UI redesign + SEO
├── docker-compose.yml
├── docker/                       # Dockerfile, nginx
├── app/Livewire/TodoList.php
├── resources/views/livewire/todo-list.blade.php
└── tests/Feature/TodoListTest.php
```

## Makefile Commands

| Command | Description |
|---------|-------------|
| `make up` | Start Docker services |
| `make down` | Stop containers |
| `make shell` | Bash into PHP container |
| `make artisan cmd="migrate"` | Run Artisan |
| `make test` | Run PHPUnit |
| `make build` | npm install + vite build |

## References

- [GitHub Spec Kit](https://github.github.com/spec-kit/)
- [BMAD Method](https://github.com/bmad-code-org/BMAD-METHOD)
- [Laravel Breeze](https://laravel.com/docs/starter-kits#breeze)
- [TALL Stack](https://tallstack.dev/)
