import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Livewire/**/*.php',
    ],

    theme: {
        extend: {
            colors: {
                brand: {
                    50: '#f0f7ff',
                    100: '#e0effe',
                    200: '#badcfe',
                    300: '#7cc0fd',
                    400: '#379ef9',
                    500: '#0c81eb',
                    600: '#0265ca',
                    700: '#0250a3',
                    800: '#084586',
                    900: '#0d3b6f',
                    950: '#092548',
                },
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                'inner-soft': 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.06)',
            },
            animation: {
                'fade-in': 'fadeIn 0.3s ease-out',
                'slide-in-right': 'slideInRight 0.4s ease-out',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideInRight: {
                    '0%': { transform: 'translateX(100%)' },
                    '100%': { transform: 'translateX(0)' },
                },
            },
        },
    },

    plugins: [forms],
};
