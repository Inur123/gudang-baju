import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                pink: {
                  50: '#fdf2f8',
                  100: '#fce7f3',
                  200: '#fbcfe8',
                  300: '#f9a8d4',
                  400: '#f472b6',
                  500: '#ec4899',
                  600: '#db2777',
                },
                purple: {
                  50: '#faf5ff',
                  100: '#f3e8ff',
                  200: '#e9d5ff',
                  300: '#d8b4fe',
                  400: '#c084fc',
                  500: '#a855f7',
                  600: '#9333ea',
                },
                green: {
                  100: '#dcfce7',
                  500: '#22c55e',
                  600: '#16a34a',
                },
                orange: {
                  100: '#ffedd5',
                  500: '#f97316',
                  600: '#ea580c',
                },
                teal: {
                  600: '#0d9488',
                },
                red: {
                  600: '#dc2626',
                }
              }

        },
    },
    plugins: [],

};

