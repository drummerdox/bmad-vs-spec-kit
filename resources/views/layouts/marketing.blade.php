<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <x-seo.meta
            :title="$seoTitle ?? config('app.name', 'Todo App')"
            :description="$seoDescription ?? 'Organize your daily tasks with a free, personal todo app. Priorities, filters, and a clean interface — sign up in seconds.'"
            :suffix="$seoSuffix ?? isset($seoTitle)"
        />

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @stack('head')

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-ink bg-surface">
        @yield('content')

        <x-seo.json-ld-app />
    </body>
</html>
