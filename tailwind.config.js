import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/js/**/*.vue',
    ],

    safelist: [
        'bg-green-100',
        'border-green-400',
        'text-green-700',
        'bg-blue-600',
        'hover:bg-green-700',
        'hover:bg-blue-700',
        // add any others you use dynamically
    ],
    darkMode: 'class', // Enable dark mode support
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
