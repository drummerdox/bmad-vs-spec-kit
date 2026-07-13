<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center rounded-xl border border-border bg-surface-elevated px-5 py-2.5 text-sm font-semibold text-ink shadow-sm motion-safe-transition hover:bg-surface focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-surface disabled:opacity-50 disabled:cursor-not-allowed']) }}>
    {{ $slot }}
</button>
