<div class="w-full max-w-2xl mx-auto">
    {{-- Welcome header --}}
    <header class="mb-8 text-center sm:text-left">
        <div class="inline-flex items-center gap-2 rounded-full bg-primary-50 px-3 py-1 text-xs font-semibold text-primary-700 ring-1 ring-primary-100">
            <span class="size-1.5 rounded-full bg-primary-500"></span>
            TALL Stack · Spec-Driven Demo
        </div>
        <h1 class="mt-4 text-3xl font-bold tracking-tight text-ink">
            Hey, {{ auth()->user()->name }} 👋
        </h1>
        <p class="mt-2 text-muted">
            What would you like to get done today?
        </p>
    </header>

    {{-- Quick stats --}}
    <div class="mb-6 grid grid-cols-3 gap-3">
        @foreach ([
            ['key' => 'all', 'label' => 'Total', 'icon' => '📋', 'color' => 'primary'],
            ['key' => 'active', 'label' => 'Active', 'icon' => '⚡', 'color' => 'sky'],
            ['key' => 'completed', 'label' => 'Done', 'icon' => '✅', 'color' => 'emerald'],
        ] as $stat)
            <button
                type="button"
                wire:click="setFilter('{{ $stat['key'] }}')"
                @class([
                    'rounded-2xl border p-4 text-left motion-safe-transition hover:shadow-md focus:outline-none focus:ring-2 focus:ring-secondary-400/30',
                    'border-secondary-400 bg-secondary-400/10 shadow-sm ring-2 ring-secondary-400/30' => $filter === $stat['key'],
                    'border-border bg-surface-elevated hover:border-border hover:shadow-primary-glow' => $filter !== $stat['key'],
                ])
            >
                <span class="text-lg">{{ $stat['icon'] }}</span>
                <p class="mt-1 text-2xl font-bold text-ink">{{ $counts[$stat['key']] }}</p>
                <p class="text-xs font-medium text-muted">{{ $stat['label'] }}</p>
            </button>
        @endforeach
    </div>

    {{-- Add task form --}}
    <form
        wire:submit="addTodo"
        class="mb-8 overflow-hidden rounded-2xl border border-primary-100 bg-gradient-to-br from-surface-elevated to-primary-50/40 shadow-sm"
    >
        <div class="border-b border-primary-100/80 bg-surface-elevated/60 px-5 py-3">
            <h2 class="text-sm font-semibold text-ink">✏️ New task</h2>
        </div>

        <div class="space-y-4 p-5">
            <div>
                <label for="title" class="sr-only">Task title</label>
                <input
                    id="title"
                    type="text"
                    wire:model="title"
                    placeholder="What needs to be done?"
                    autofocus
                    class="w-full rounded-xl border-0 bg-surface-elevated px-4 py-3 text-base text-ink shadow-sm ring-1 ring-border placeholder:text-muted focus:ring-2 focus:ring-primary-500"
                />
                @error('title')
                    <p class="mt-2 flex items-center gap-1 text-sm text-red-600 dark:text-[#f92672]">
                        <svg class="size-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div x-data="{ showDetails: false }">
                <button
                    type="button"
                    @click="showDetails = !showDetails"
                    class="flex items-center gap-1 text-sm font-medium text-primary-600 hover:text-primary-700"
                >
                    <svg class="size-4 transition-transform" :class="showDetails && 'rotate-90'" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                    <span x-text="showDetails ? 'Hide details' : 'Add description (optional)'"></span>
                </button>
                <div x-show="showDetails" x-transition class="mt-3">
                    <textarea
                        id="description"
                        wire:model="description"
                        rows="2"
                        placeholder="Any extra notes..."
                        class="w-full rounded-xl border-0 bg-surface-elevated px-4 py-3 text-sm text-ink shadow-sm ring-1 ring-border placeholder:text-muted focus:ring-2 focus:ring-primary-500"
                    ></textarea>
                </div>
            </div>

            <div>
                <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-muted">Priority</p>
                <div class="flex flex-wrap gap-2">
                    @foreach (['low' => ['label' => 'Low', 'emoji' => '🟢'], 'medium' => ['label' => 'Medium', 'emoji' => '🟡'], 'high' => ['label' => 'High', 'emoji' => '🔴']] as $value => $meta)
                        <button
                            type="button"
                            wire:click="$set('priority', '{{ $value }}')"
                            @class([
                                'inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-medium transition-all duration-150',
                                'bg-surface-elevated text-ink ring-1 ring-border hover:ring-border' => $priority !== $value,
                                'bg-primary-600 text-white shadow-md ring-2 ring-primary-600 ring-offset-1 ring-offset-surface dark:text-[#272822]' => $priority === $value,
                            ])
                        >
                            <span>{{ $meta['emoji'] }}</span>
                            {{ $meta['label'] }}
                        </button>
                    @endforeach
                </div>
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary-600 px-4 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-primary-500 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-surface disabled:opacity-60 dark:text-[#272822]"
            >
                <span wire:loading.remove wire:target="addTodo">
                    <svg class="inline size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </span>
                <span wire:loading wire:target="addTodo" class="inline-flex items-center gap-2">
                    <svg class="size-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Adding…
                </span>
                <span wire:loading.remove wire:target="addTodo">Add task</span>
            </button>
        </div>
    </form>

    {{-- Task list --}}
    <div class="relative">
        <div wire:loading.flex wire:target="toggle,delete,setFilter" class="absolute inset-0 z-10 hidden items-center justify-center rounded-2xl bg-surface-elevated/60 backdrop-blur-[1px]">
            <svg class="size-8 animate-spin text-primary-500" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
        </div>

        <ul class="space-y-3">
            @forelse ($todos as $todo)
                <li
                    wire:key="todo-{{ $todo->id }}"
                    x-data="{ expanded: false }"
                    @class([
                        'group relative overflow-hidden rounded-2xl border bg-surface-elevated p-4 shadow-sm motion-safe-transition hover:shadow-md',
                        'border-border' => ! $todo->completed,
                        'border-border-subtle' => $todo->completed,
                    ])
                >
                    {{-- Priority accent bar --}}
                    <div @class([
                        'absolute inset-y-0 left-0 w-1',
                        'priority-bar-low' => $todo->priority === 'low' && ! $todo->completed,
                        'priority-bar-medium' => $todo->priority === 'medium' && ! $todo->completed,
                        'priority-bar-high' => $todo->priority === 'high' && ! $todo->completed,
                        'bg-border' => $todo->completed,
                    ])></div>

                    <div class="flex items-start gap-3 pl-2">
                        {{-- Custom checkbox --}}
                        <button
                            type="button"
                            wire:click="toggle({{ $todo->id }})"
                            aria-label="{{ $todo->completed ? 'Mark as active' : 'Mark as done' }}"
                            @class([
                                'mt-0.5 flex size-6 shrink-0 items-center justify-center rounded-full border-2 transition-all duration-200',
                                'border-border bg-surface-elevated hover:border-primary-400 hover:bg-primary-50' => ! $todo->completed,
                                'border-primary-500 bg-primary-500 text-white dark:text-[#272822]' => $todo->completed,
                            ])
                        >
                            @if ($todo->completed)
                                <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            @endif
                        </button>

                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <p @class([
                                    'text-base font-medium leading-snug',
                                    'text-muted line-through decoration-border' => $todo->completed,
                                    'text-ink' => ! $todo->completed,
                                ])>
                                    {{ $todo->title }}
                                </p>
                                <span @class([
                                    'inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-semibold',
                                    'badge-priority-low' => $todo->priority === 'low',
                                    'badge-priority-medium' => $todo->priority === 'medium',
                                    'badge-priority-high' => $todo->priority === 'high',
                                ])>
                                    @if ($todo->priority === 'low') 🟢
                                    @elseif ($todo->priority === 'medium') 🟡
                                    @else 🔴
                                    @endif
                                    {{ ucfirst($todo->priority) }}
                                </span>
                            </div>

                            @if ($todo->description)
                                <button
                                    type="button"
                                    @click="expanded = !expanded"
                                    class="mt-1.5 flex items-center gap-1 text-xs font-medium text-primary-600 hover:text-primary-700"
                                >
                                    <svg class="size-3 transition-transform" :class="expanded && 'rotate-90'" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                    </svg>
                                    <span x-text="expanded ? 'Hide note' : 'Show note'"></span>
                                </button>
                                <p
                                    x-show="expanded"
                                    x-transition
                                    class="mt-2 rounded-lg bg-surface px-3 py-2 text-sm leading-relaxed text-muted"
                                >{{ $todo->description }}</p>
                            @endif
                        </div>

                        <button
                            type="button"
                            wire:click="delete({{ $todo->id }})"
                            wire:confirm="Delete this task?"
                            class="rounded-xl p-2 text-muted opacity-0 transition-all hover:bg-accent-500/10 hover:text-accent-500 group-hover:opacity-100 focus:opacity-100 focus:outline-none focus:ring-2 focus:ring-accent-500/30"
                            title="Delete task"
                        >
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </div>
                </li>
            @empty
                <li class="rounded-2xl border-2 border-dashed border-border bg-surface/50 px-6 py-12 text-center">
                    <div class="mx-auto mb-4 flex size-16 items-center justify-center rounded-full bg-primary-50 text-3xl">
                        @if ($filter === 'all')
                            📝
                        @elseif ($filter === 'active')
                            🎉
                        @else
                            🔍
                        @endif
                    </div>
                    @if ($filter === 'all')
                        <p class="text-base font-semibold text-ink">No tasks yet</p>
                        <p class="mt-1 text-sm text-muted">Add your first task above — you've got this!</p>
                    @elseif ($filter === 'active')
                        <p class="text-base font-semibold text-ink">All caught up!</p>
                        <p class="mt-1 text-sm text-muted">No active tasks. Time for a break ☕</p>
                    @else
                        <p class="text-base font-semibold text-ink">Nothing completed yet</p>
                        <p class="mt-1 text-sm text-muted">Check off a task to see it here.</p>
                    @endif
                </li>
            @endforelse
        </ul>
    </div>
</div>
