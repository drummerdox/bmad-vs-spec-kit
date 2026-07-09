# Feature Specification: Todo List Application (Authenticated)

**Feature Branch**: `001-todo-app`  
**Created**: 2026-07-09  
**Status**: Draft  
**Input**: "Build a todo list app where registered users manage daily tasks with priorities."

## User Scenarios & Testing *(mandatory)*

### User Story 0 - Register and Login (Priority: P0)

A new user creates an account, logs in, and reaches the todo dashboard. Unauthenticated visitors cannot access todos.

**Why this priority**: Auth gates all todo functionality; must exist before any CRUD.

**Independent Test**: Register → login → land on `/todos` → logout → `/todos` redirects to login.

**Acceptance Scenarios**:

1. **Given** a guest on `/register`, **When** they submit valid name, email, password, and confirmation, **Then** they are logged in and redirected to `/todos`.
2. **Given** a registered user on `/login`, **When** they submit correct credentials, **Then** they reach `/todos`.
3. **Given** invalid login credentials, **When** the user submits the form, **Then** a validation error is shown and they remain on `/login`.
4. **Given** an authenticated user, **When** they click Logout, **Then** the session ends and they are redirected to the home/login page.
5. **Given** a guest, **When** they visit `/todos`, **Then** they are redirected to `/login`.

---

### User Story 1 - Add a Todo (Priority: P1)

A logged-in user adds a new task with title, optional description, and priority.

**Why this priority**: Core value — without adding todos, the app has no purpose.

**Independent Test**: Login → submit "Buy milk" with priority "high" → todo appears in the list.

**Acceptance Scenarios**:

1. **Given** an empty todo list, **When** the user enters title "Buy milk" and clicks Add, **Then** the todo appears unchecked.
2. **Given** the add form, **When** title is shorter than 3 characters, **Then** validation error shown, no todo created.
3. **Given** the add form, **When** priority "high" is selected, **Then** the new todo shows a high-priority badge.
4. **Given** User A is logged in, **When** User B's todos exist in DB, **Then** User A sees only their own todos.

---

### User Story 2 - Complete a Todo (Priority: P1)

A user marks a todo done when finished.

**Why this priority**: Completing tasks is the primary interaction loop.

**Independent Test**: Click checkbox on active todo → strikethrough applied.

**Acceptance Scenarios**:

1. **Given** an active todo, **When** the user clicks its checkbox, **Then** it is marked completed with strikethrough.
2. **Given** a completed todo, **When** the user clicks checkbox again, **Then** it returns to active.

---

### User Story 3 - Filter Todos (Priority: P2)

A user filters the list: all, active only, or completed only.

**Why this priority**: Helps manage longer lists.

**Independent Test**: Create 2 active + 1 completed → filter "Active" shows 2 items.

**Acceptance Scenarios**:

1. **Given** mixed todos, **When** user clicks "Active" filter, **Then** only incomplete todos shown with count badge.
2. **Given** mixed todos, **When** user clicks "Done" filter, **Then** only completed todos shown.

---

### User Story 4 - Delete a Todo (Priority: P2)

A user removes a todo they no longer need.

**Independent Test**: Click delete → confirm → todo removed.

**Acceptance Scenarios**:

1. **Given** a todo in the list, **When** user clicks delete and confirms, **Then** the todo is permanently removed.

---

### Edge Cases

- Empty list shows helpful empty state message.
- Titles 255 chars accepted; longer rejected.
- Description optional; expand/collapse via Alpine.js.
- User cannot toggle/delete another user's todo (403 or not found).

## Requirements *(mandatory)*

### Functional Requirements

- **FR-001**: System MUST provide registration with name, email, password (confirmed).
- **FR-002**: System MUST provide login and logout.
- **FR-003**: System MUST protect `/todos` and related routes with authentication middleware.
- **FR-004**: System MUST scope todos to `auth()->id()` — create, read, update, delete.
- **FR-005**: System MUST allow creating todos with title (required), description (optional), priority (low/medium/high).
- **FR-006**: System MUST validate title is 3–255 characters.
- **FR-007**: System MUST allow toggling completion status.
- **FR-008**: System MUST allow deleting todos with confirmation.
- **FR-009**: System MUST provide filters: All, Active, Completed with live counts.
- **FR-010**: System MUST persist data in MySQL across sessions.
- **FR-011**: System MUST show loading feedback during Livewire requests.

### Key Entities

- **User**: id, name, email, password (hashed), timestamps (Laravel default).
- **Todo**: id, user_id (FK), title, description (nullable), completed (boolean), priority (enum), position (int), timestamps.

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: New user can register and add first todo in under 60 seconds.
- **SC-002**: All P0 and P1 user stories pass automated feature tests.
- **SC-003**: UI renders on mobile and desktop viewports.
- **SC-004**: App runs entirely via `docker compose up` with documented setup.
- **SC-005**: Zero separate SPA — Vite + Alpine + Livewire only.
