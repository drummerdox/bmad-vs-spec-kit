<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($theme ?? 'light') === 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @include('partials.theme-init')

        <x-seo.meta
            :title="$seoTitle ?? 'My Tasks'"
            :description="$seoDescription ?? 'View and manage your personal todo list with priorities and filters.'"
            robots="noindex, nofollow"
        />

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @stack('head')

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-ink">
        <div class="min-h-screen bg-surface-mesh">
            <livewire:layout.navigation />

            @if (isset($header))
                <header class="border-b border-border-subtle bg-surface-elevated/80 backdrop-blur-sm">
                    <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
