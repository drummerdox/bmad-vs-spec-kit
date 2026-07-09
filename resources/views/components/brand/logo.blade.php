@props([
    'href' => '/',
    'showWordmark' => true,
    'size' => 'md',
])

@php
    $iconSizes = [
        'sm' => 'h-8 w-8',
        'md' => 'h-10 w-10 text-xl',
        'lg' => 'h-12 w-12 text-2xl',
    ];
    $iconSize = $iconSizes[$size] ?? $iconSizes['md'];
    $wordmarkSizes = [
        'sm' => 'text-base',
        'md' => 'text-lg',
        'lg' => 'text-xl',
    ];
    $wordmarkSize = $wordmarkSizes[$size] ?? $wordmarkSizes['md'];
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5 group']) }} wire:navigate>
    <div class="inline-flex items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 to-accent-500 text-white font-bold shadow-primary-glow {{ $iconSize }}">
        <svg class="w-1/2 h-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>
    @if ($showWordmark)
        <span class="{{ $wordmarkSize }} font-bold text-ink group-hover:text-primary-600 motion-safe-transition">{{ config('app.name', 'Todo App') }}</span>
    @endif
</a>
