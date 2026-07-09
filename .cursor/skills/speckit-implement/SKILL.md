---
name: speckit-implement
description: Execute tasks from tasks.md and build the feature. Use when specs, plan, and tasks are approved and ready for code.
---

# Speckit Implement

Execute `specs/NNN-feature/tasks.md` in dependency order.

## Prerequisites

- [ ] `constitution.md` exists
- [ ] `spec.md` approved
- [ ] `plan.md` approved
- [ ] `tasks.md` exists

## Steps

1. Read constitution, spec, plan, and tasks.
2. Execute phases sequentially — do not skip Docker or auth before todos.
3. Run commands via Docker: `make up`, `make artisan cmd="..."`, `make test`.
4. Mark completed tasks `[x]` in `tasks.md` as you finish them.
5. Follow TALL conventions: Livewire for UI, Tailwind for styling, Breeze for auth.
6. Scope todos to `auth()->id()`.
7. After Phase 10, run full test suite and fix failures.

## Phase Summary (001-todo-app)

| Phase | Focus |
|-------|-------|
| 1 | Docker compose, Dockerfile, nginx, Makefile |
| 2 | Laravel create-project, Livewire, Breeze, npm build |
| 3 | Register, login, logout, protected `/todos` |
| 4–8 | Todo migration, Livewire CRUD, filters, delete |
| 9 | Polish (loading, empty states, Alpine) |
| 10 | Feature tests for auth + todos |

## Stop Conditions

- Stop at checkpoints to validate if user requested incremental delivery
- Do not mark Phase 10 complete until `php artisan test` passes

## BMAD Mode

Prefix: "Act as BMAD Developer, follow spec:" for role-play consistency.
