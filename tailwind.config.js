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
                'off-white': '#FFF8F2',
                'gris-azulado': '#787F8F',
                'verde-menta': '#02AC66',
                'azul-profundo': '#3B82F6',
                'morado-vibrante': '#8B5CF6',
            }
        },
    },

    plugins: [forms],
};