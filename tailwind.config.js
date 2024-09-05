import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    safelist:[
        'top-full',
        'left-0',
        'right-0',
        'mt-2',
        'bottom-full',
        'mb-2',
        'rounded-md',
        'border-2',
        'shadow-md',
        'rounded-full',
        'w-12',
        'h-12'
      ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                xs: "0.75rem",
                sm: "0.875rem",
                base: "1rem",
                lg: "1.125rem",
                xl: "1.25rem",
                "2xl": "1.5rem",
                "3xl": "1.875rem",
                "4xl": "2.25rem",
                "5xl": "3rem",
                "6xl": "4rem",
            },
        },
    },

    plugins: [forms],
};
