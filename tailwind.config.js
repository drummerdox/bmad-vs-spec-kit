import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                surface: {
                    DEFAULT: 'var(--color-surface)',
                    elevated: 'var(--color-surface-elevated)',
                },
                muted: 'var(--color-muted)',
                ink: 'var(--color-ink)',
                border: {
                    DEFAULT: 'var(--color-border)',
                    subtle: 'var(--color-border-subtle)',
                },
                primary: {
                    50: 'var(--color-primary-50)',
                    100: 'var(--color-primary-100)',
                    500: 'var(--color-primary-500)',
                    600: 'var(--color-primary-600)',
                    700: 'var(--color-primary-700)',
                },
                secondary: {
                    400: 'var(--color-secondary-400)',
                    500: 'var(--color-secondary-500)',
                },
                accent: {
                    400: 'var(--color-accent-400)',
                    500: 'var(--color-accent-500)',
                    600: 'var(--color-accent-600)',
                },
            },
            boxShadow: {
                'accent-glow': '0 10px 40px -10px rgba(236, 72, 153, 0.45)',
                'primary-glow': '0 10px 40px -10px rgba(79, 70, 229, 0.35)',
            },
        },
    },

    plugins: [forms],
};
