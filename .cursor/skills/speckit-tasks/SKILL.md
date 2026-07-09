---
name: speckit-tasks
description: Break an approved plan into phased, executable tasks. Use after plan.md is ready and before implementation.
---

# Speckit Tasks

Produce `specs/NNN-feature/tasks.md` from `plan.md`.

## Steps

1. Read `plan.md` and `spec.md`.
2. Phase tasks in this order for this project:
   - Phase 1: Docker setup
   - Phase 2: Project install (Laravel, Livewire, Breeze)
   - Phase 3: Registration, login, base flow (US0)
   - Phase 4: Foundational schema
   - Phases 5–8: User stories US1–US4
   - Phase 9: Polish
   - Phase 10: Tests
3. Use format: `- [ ] TNNN [P?] [USn] Description`
4. Add checkpoints after each phase.
5. Document dependencies and parallel opportunities.

## Output

- File: `specs/NNN-feature/tasks.md`
- All tasks start unchecked `[ ]` unless reporting progress

## Reference

See `specs/001-todo-app/tasks.md` for the canonical breakdown.
