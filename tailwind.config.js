import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
const colors = require('tailwindcss/colors')
/** @type {import('tailwindcss').Config} */
export default {
    darkMode:"class",
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            height:{
                content:'calc(100svh - 7.5rem)',
                'content-bboff':'calc(100svh - 56px)',
            }
        },
        colors:{
            "c-black":"#3d3d3d",
            "c-grey":"#4b4b4b",
            "c-yellow":"#f1c40f",
            "c-white":"#FFFFFF",
            "c-pr":"#00a8ff",
            blue:colors.blue,
            red:colors.red,
            stone:colors.stone,
            neutral:colors.neutral,
            gray:colors.gray,
            white:colors.white,
            yellow:colors.yellow
        }
    },

    plugins: [forms,require('flowbite/plugin')],
};
