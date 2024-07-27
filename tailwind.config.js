import defaultTheme from "tailwindcss/defaultTheme";
const colors = require("tailwindcss/colors");
/** @type {import('tailwindcss').Config} */
export default {
    darkMode: ['selector', '[class*="dark"]'],
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            height: {
                content: "calc(100svh - 7.5rem)",
                "content-bboff": "calc(100svh - 56px)",
            },
        },
        colors: {
            "c-black": "#3d3d3d",
            "c-grey": "#4b4b4b",
            "c-yellow": "#f1c40f",
            "c-white": "#FFFFFF",
            "c-pr": "#00a8ff",
            blue: colors.blue,
            red: colors.red,
            yellow: colors.yellow,
            zinc: colors.zinc,
            emerald:colors.emerald
        },
    },

    plugins: [require('tailwindcss-primeui')],
};
