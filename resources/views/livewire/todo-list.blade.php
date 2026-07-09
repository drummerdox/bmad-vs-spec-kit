<div class="w-full max-w-2xl mx-auto">
    <header class="mb-8">
        <p class="text-sm font-medium text-indigo-600">TALL Stack · Spec-Driven Demo</p>
        <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900">Todo List</h1>
        <p class="mt-2 text-gray-600">
            Your tasks, scoped to <strong>{{ auth()->user()->name }}</strong>.
        </p>
    </header>

    <form wire:submit="addTodo" class="mb-6 rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="space-y-4">
            <div>
                <label for="title" class="mb-1 block text-sm font-medium text-gray-700">Title</label>
                <input
                    id="title"
                    type="text"
                    wire:model="title"
                    placeholder="What needs to be done?"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                />
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="mb-1 block text-sm font-medium text-gray-700">Description (optional)</label>
                <textarea
                    id="description"
                    wire:model="description"
                    rows="2"
                    placeholder="Add details..."
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                ></textarea>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <label for="priority" class="text-sm font-medium text-gray-700">Priority</label>
                <select
                    id="priority"
                    wire:model="priority"
                    class="rounded-lg border border-gray-300 px-3 py-2 text-sm"
                >
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>

                <button
                    type="submit"
                    class="ml-auto rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Add todo
                </button>
            </div>
        </div>
    </form>

    <div class="mb-4 flex gap-2">
        @foreach (['all' => 'All', 'active' => 'Active', 'completed' => 'Done'] as $key => $label)
            <button
                type="button"
                wire:click="setFilter('{{ $key }}')"
                class="rounded-full px-3 py-1 text-sm font-medium transition {{ $filter === $key ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
            >
                {{ $label }}
                <span class="ml-1 opacity-75">({{ $counts[$key] }})</span>
            </button>
        @endforeach
    </div>

    <ul class="space-y-3" wire:loading.class="opacity-50">
        @forelse ($todos as $todo)
            <li
                wire:key="todo-{{ $todo->id }}"
                x-data="{ expanded: false }"
                class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm transition {{ $todo->completed ? 'opacity-70' : '' }}"
            >
                <div class="flex items-start gap-3">
                    <input
                        type="checkbox"
                        wire:click="toggle({{ $todo->id }})"
                        @checked($todo->completed)
                        class="mt-1 size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                    />

                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2">
                            <p class="font-medium text-gray-900 {{ $todo->completed ? 'line-through' : '' }}">
                                {{ $todo->title }}
                            </p>
                            <span @class([
                                'rounded-full px-2 py-0.5 text-xs font-medium',
                                'bg-green-100 text-green-800' => $todo->priority === 'low',
                                'bg-amber-100 text-amber-800' => $todo->priority === 'medium',
                                'bg-red-100 text-red-800' => $todo->priority === 'high',
                            ])>
                                {{ ucfirst($todo->priority) }}
                            </span>
                        </div>

                        @if ($todo->description)
                            <button
                                type="button"
                                @click="expanded = !expanded"
                                class="mt-1 text-sm text-indigo-600 hover:underline"
                                x-text="expanded ? 'Hide details' : 'Show details'"
                            ></button>
                            <p
                                x-show="expanded"
                                x-transition
                                class="mt-2 text-sm text-gray-600"
                            >{{ $todo->description }}</p>
                        @endif
                    </div>

                    <button
                        type="button"
                        wire:click="delete({{ $todo->id }})"
                        wire:confirm="Delete this todo?"
                        class="rounded-lg p-2 text-gray-400 hover:bg-red-50 hover:text-red-600"
                        title="Delete"
                    >
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </div>
            </li>
        @empty
            <li class="rounded-xl border border-dashed border-gray-300 p-8 text-center text-gray-500">
                @if ($filter === 'all')
                    No todos yet. Add your first task above.
                @else
                    No todos match this filter.
                @endif
            </li>
        @endforelse
    </ul>
</div>
