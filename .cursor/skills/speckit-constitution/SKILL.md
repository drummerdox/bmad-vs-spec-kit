---
name: speckit-constitution
description: Create or update the project constitution governing TALL stack, Docker, auth, and test principles. Use when starting a new Spec Kit project or amending governing rules.
---

# Speckit Constitution

Create or update `.specify/memory/constitution.md` for this project.

## Steps

1. Read existing constitution if present.
2. Capture immutable principles: stack (TALL), Docker-first dev, auth requirements, test gates, simplicity rules.
3. Include a technology constraints table.
4. Document the workflow: Constitution → Specify → Plan → Tasks → Implement → QA.
5. Write governance rules (specs override ad-hoc prompts).

## Output

- File: `.specify/memory/constitution.md`
- Do not implement application code in this step.

## Context

This learning project uses Laravel TALL stack in Docker with registration/login before todo features.
