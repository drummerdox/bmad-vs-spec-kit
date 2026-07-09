import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
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
                    DEFAULT: '#f9f8f5',
                    elevated: '#ffffff',
                },
                muted: '#6b6560',
                ink: '#18181b',
                primary: {
                    50: '#f0efff',
                    100: '#e0deff',
                    500: '#6366f1',
                    600: '#4f46e5',
                    700: '#4338ca',
                },
                secondary: {
                    400: '#22d3ee',
                    500: '#06b6d4',
                },
                accent: {
                    400: '#f472b6',
                    500: '#ec4899',
                    600: '#db2777',
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
