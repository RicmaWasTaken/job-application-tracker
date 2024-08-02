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
            backgroundSize: {
                '0100': '0% 100%',
                '100100' : '100% 100%',
            },
            transitionProperty: {
                'fillout' : 'background-size',
            },
            transitionDuration: {
                '500' : '0.5s',
            },
        },
    },

    plugins: [forms],
};
