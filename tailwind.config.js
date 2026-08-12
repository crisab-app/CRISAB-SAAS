import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    darkMode: 'class',

    theme: {
        extend: {
            transitionTimingFunction: {
                // Esta es la curva secreta: arranca rápido, frena suave.
                'premium': 'cubic-bezier(0.32, 0.72, 0, 1)',
                'bounce-sm': 'cubic-bezier(0.34, 1.56, 0.64, 1)',
            },
            transitionDuration: {
                '250': '250ms', // El tiempo ideal: ni muy lento (300) ni muy brusco (200)
            }
        },
    },

    plugins: [forms],
};
