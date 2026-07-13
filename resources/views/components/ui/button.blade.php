@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
])

@php
    $base = 'inline-flex items-center justify-center font-semibold rounded-xl motion-safe-transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-surface disabled:opacity-50 disabled:cursor-not-allowed';

    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $variants = [
        'primary' => 'bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500 shadow-primary-glow dark:text-[#272822]',
        'secondary' => 'bg-surface-elevated text-ink border border-border hover:bg-surface focus:ring-primary-500',
        'ghost' => 'text-muted hover:text-ink hover:bg-black/5 dark:hover:bg-white/5 focus:ring-primary-500',
        'accent' => 'bg-accent-500 text-white hover:bg-accent-600 focus:ring-accent-500 shadow-accent-glow',
    ];

    $classes = implode(' ', [$base, $sizes[$size] ?? $sizes['md'], $variants[$variant] ?? $variants['primary']]);
@endphp

@if ($type === 'link')
    <a {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
