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
                'rosa-electrico': '#FF7DB5',
                'rojo-intenso': '#F21F07', 
                'naranja-vibrante': '#FC7925',
                'ambar': '#FFB700',
                'amarillo-dorado': '#FFDD00',
                'crema': '#FAEDD9',
                'negro': '#000000',
                'blanco-crema': '#FFF8F2',
                'gris-azulado': '#787F8F',
            }
        },
    },

    plugins: [forms],
};