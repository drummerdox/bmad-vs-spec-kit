@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full rounded-xl border border-border bg-surface-elevated text-ink shadow-sm motion-safe-transition placeholder:text-muted focus:border-primary-500 focus:ring-2 focus:ring-primary-500 disabled:opacity-50 disabled:cursor-not-allowed']) }}>
