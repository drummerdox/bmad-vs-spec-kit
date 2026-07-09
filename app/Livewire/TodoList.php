<?php

namespace App\Livewire;

use App\Models\Todo;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TodoList extends Component
{
    #[Validate('required|string|min:3|max:255')]
    public string $title = '';

    #[Validate('nullable|string|max:1000')]
    public ?string $description = null;

    #[Validate('required|in:low,medium,high')]
    public string $priority = 'medium';

    public string $filter = 'all';

    public function addTodo(): void
    {
        $validated = $this->validate();

        $nextPosition = (int) auth()->user()->todos()->max('position') + 1;

        auth()->user()->todos()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'position' => $nextPosition,
        ]);

        $this->reset(['title', 'description']);
        $this->priority = 'medium';
    }

    public function toggle(int $todoId): void
    {
        $todo = $this->findUserTodo($todoId);
        $todo->update(['completed' => ! $todo->completed]);
    }

    public function delete(int $todoId): void
    {
        $this->findUserTodo($todoId)->delete();
    }

    public function setFilter(string $filter): void
    {
        if (! in_array($filter, ['all', 'active', 'completed'], true)) {
            return;
        }

        $this->filter = $filter;
    }

    public function render(): View
    {
        $user = auth()->user();
        $query = $user->todos()->orderBy('position');

        $query = match ($this->filter) {
            'active' => $query->where('completed', false),
            'completed' => $query->where('completed', true),
            default => $query,
        };

        return view('livewire.todo-list', [
            'todos' => $query->get(),
            'counts' => [
                'all' => $user->todos()->count(),
                'active' => $user->todos()->where('completed', false)->count(),
                'completed' => $user->todos()->where('completed', true)->count(),
            ],
        ]);
    }

    private function findUserTodo(int $todoId): Todo
    {
        return auth()->user()->todos()->findOrFail($todoId);
    }
}
