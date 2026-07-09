---
name: speckit-plan
description: Generate a technical implementation plan from an approved spec. Use after spec.md exists and before task breakdown.
---

# Speckit Plan

Produce `specs/NNN-feature/plan.md` from `spec.md` and `constitution.md`.

## Steps

1. Read `specs/NNN-feature/spec.md` and `.specify/memory/constitution.md`.
2. Select stack per constitution (TALL, Docker, Breeze auth, MySQL).
3. Design Docker services (nginx, app, mysql, optional node for Vite).
4. Define data model, routes, project structure.
5. Write ADRs for non-obvious decisions.
6. Map BMAD phases to deliverables.
7. Define implementation order: Docker → install → auth → features → tests.

## Output

- File: `specs/NNN-feature/plan.md`
- Constitution check table showing compliance

## Reference

See existing plan at `specs/001-todo-app/plan.md` for this project's pattern.
