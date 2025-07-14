import defaultTheme from 'tailwindcss/defaultTheme';
import colors from 'tailwindcss/colors';

export default {
    content: [
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],
    darkMode: 'false',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                green: colors.emerald,
                yellow: colors.amber,
                purple: colors.violet,
                'soccer-green': '#307470',
                'soccer-light': '#9BBAB8',
                // TrainerContainer Color Palette
                primary: {
                    50: '#f0fdfa',
                    100: '#ccfbf1',
                    200: '#99f6e4',
                    300: '#5eead4',
                    400: '#2dd4bf',
                    500: '#14b8a6',  // Main brand color
                    600: '#0d9488',
                    700: '#0f766e',
                    800: '#115e59',
                    900: '#134e4a',
                },
                // Background Colors
                'bg-primary': '#ffffff',
                'bg-secondary': '#f9fafb',
                'bg-tertiary': '#f3f4f6',
                'bg-dark': '#111827',
                // Text Colors
                'text-primary': '#111827',
                'text-secondary': '#4b5563',
                'text-tertiary': '#6b7280',
                'text-inverse': '#ffffff',
                // Border Colors
                'border-light': '#e5e7eb',
                'border-default': '#d1d5db',
                'border-dark': '#9ca3af',
                // Accent Colors
                'success-green': '#10b981',
                'warning-amber': '#f59e0b',
                'error-red': '#ef4444',
                'info-blue': '#3b82f6',
            }
        },
    },

    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
    },

    plugins: [
        require('flowbite/plugin')
    ],
};
