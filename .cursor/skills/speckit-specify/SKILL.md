---
name: speckit-specify
description: Write a feature specification (what and why) from a user description. Use when defining requirements before planning or implementation.
---

# Speckit Specify

Produce `specs/NNN-feature/spec.md` from the user's feature description.

## Steps

1. Read `.specify/memory/constitution.md` for constraints.
2. Choose feature folder (e.g. `specs/001-todo-app/`).
3. Write user stories with P0/P1/P2 priorities and Given/When/Then acceptance scenarios.
4. Include auth stories (US0) if the app requires login.
5. Add functional requirements (FR-xxx) and success criteria (SC-xxx).
6. Document key entities — no tech stack in this file.

## Output

- File: `specs/NNN-feature/spec.md`
- Status: Draft until PM review

## Do Not

- Choose frameworks or write code
- Include Docker/Laravel implementation details
