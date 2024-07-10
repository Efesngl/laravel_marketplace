import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
        colors:{
            "c-black":"#3d3d3d",
            "c-grey":"#4b4b4b",
            "c-yellow":"#f1c40f",
            "c-white":"#FFFFFF",
            "c-pr":"#3498db",
            "c-bh":"#2980b9"
        }
    },

    plugins: [forms],
};
