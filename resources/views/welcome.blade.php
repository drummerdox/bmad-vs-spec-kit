@extends('layouts.marketing')

@php
    $seoTitle = 'Organize your day with Todo App';
    $seoDescription = 'Free personal task manager with priorities, filters, and a beautiful interface. Built on Laravel, Livewire, and Tailwind.';
    $seoSuffix = false;
@endphp

@section('content')
    <header class="sticky top-0 z-50 border-b border-gray-100/80 bg-surface/90 backdrop-blur-md">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <x-brand.logo />
            <livewire:welcome.navigation />
        </div>
    </header>

    <main>
        {{-- Hero --}}
        <section class="bg-hero-mesh px-4 py-20 sm:px-6 sm:py-28 lg:px-8">
            <div class="mx-auto max-w-4xl text-center">
                <p class="mb-4 inline-flex items-center gap-2 rounded-full bg-primary-50 px-4 py-1.5 text-sm font-semibold text-primary-700 ring-1 ring-primary-100">
                    <span class="size-2 rounded-full bg-accent-500"></span>
                    Free · Personal · TALL Stack
                </p>
                <h1 class="text-4xl font-bold tracking-tight text-ink sm:text-5xl lg:text-6xl">
                    Organize your day,<br>
                    <span class="bg-gradient-to-r from-primary-600 to-accent-500 bg-clip-text text-transparent">stay focused</span>
                </h1>
                <p class="mx-auto mt-6 max-w-2xl text-lg text-muted">
                    A clean todo app with priorities, filters, and instant updates — no clutter, no learning curve. Your tasks, your account, always in sync.
                </p>
                <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                    @auth
                        <x-ui.button variant="accent" size="lg" type="link" href="{{ route('todos') }}" wire:navigate>
                            Go to my tasks
                        </x-ui.button>
                    @else
                        <x-ui.button variant="accent" size="lg" type="link" href="{{ route('register') }}" wire:navigate>
                            Get started free
                        </x-ui.button>
                        <x-ui.button variant="secondary" size="lg" type="link" href="{{ route('login') }}" wire:navigate>
                            Log in
                        </x-ui.button>
                    @endauth
                </div>
            </div>
        </section>

        {{-- Features --}}
        <section class="px-4 py-16 sm:px-6 lg:px-8" aria-labelledby="features-heading">
            <div class="mx-auto max-w-6xl">
                <h2 id="features-heading" class="text-center text-3xl font-bold text-ink">Everything you need to stay on track</h2>
                <p class="mx-auto mt-3 max-w-xl text-center text-muted">Simple tools that help you capture, prioritize, and complete tasks without friction.</p>

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ([
                        ['icon' => '⚡', 'title' => 'Instant updates', 'desc' => 'Livewire keeps your list in sync without page reloads. Add, complete, or delete in a click.'],
                        ['icon' => '🎯', 'title' => 'Priority levels', 'desc' => 'Mark tasks low, medium, or high so you always know what deserves attention first.'],
                        ['icon' => '🔒', 'title' => 'Your data, private', 'desc' => 'Every todo is scoped to your account. Register once and pick up where you left off.'],
                    ] as $feature)
                        <x-ui.card>
                            <span class="text-3xl">{{ $feature['icon'] }}</span>
                            <h3 class="mt-4 text-lg font-semibold text-ink">{{ $feature['title'] }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-muted">{{ $feature['desc'] }}</p>
                        </x-ui.card>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Stack band --}}
        <section class="bg-ink px-4 py-16 sm:px-6 lg:px-8" aria-labelledby="stack-heading">
            <div class="mx-auto max-w-4xl text-center">
                <h2 id="stack-heading" class="text-2xl font-bold text-white sm:text-3xl">Built with the TALL stack</h2>
                <p class="mt-3 text-gray-400">Spec-driven development with Laravel, Livewire, Alpine, and Tailwind — containerized with Docker.</p>
                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    @foreach (['Laravel 13', 'Livewire 3', 'Alpine.js', 'Tailwind CSS', 'MySQL', 'Docker'] as $tech)
                        <span class="rounded-full bg-white/10 px-4 py-2 text-sm font-medium text-white ring-1 ring-white/20">{{ $tech }}</span>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- How it works --}}
        <section class="bg-surface-mesh px-4 py-16 sm:px-6 lg:px-8" aria-labelledby="steps-heading">
            <div class="mx-auto max-w-4xl">
                <h2 id="steps-heading" class="text-center text-3xl font-bold text-ink">How it works</h2>
                <ol class="mt-12 space-y-8">
                    @foreach ([
                        ['step' => '1', 'title' => 'Create your account', 'desc' => 'Sign up in seconds with email and password. No credit card required.'],
                        ['step' => '2', 'title' => 'Add your tasks', 'desc' => 'Capture what needs doing, set a priority, and optionally add notes.'],
                        ['step' => '3', 'title' => 'Check them off', 'desc' => 'Filter by active or completed, toggle done, and keep your day clear.'],
                    ] as $item)
                        <li class="flex gap-5">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-primary-600 text-sm font-bold text-white shadow-primary-glow">{{ $item['step'] }}</span>
                            <div>
                                <h3 class="text-lg font-semibold text-ink">{{ $item['title'] }}</h3>
                                <p class="mt-1 text-muted">{{ $item['desc'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </section>
    </main>

    <footer class="border-t border-gray-100 bg-surface-elevated px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 sm:flex-row">
            <x-brand.logo :show-wordmark="true" />
            <p class="text-sm text-muted">&copy; {{ date('Y') }} {{ config('app.name') }}. Built for learning and productivity.</p>
        </div>
    </footer>
@endsection
