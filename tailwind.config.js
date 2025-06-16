/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/**/*.blade.php"],
    theme: {
        container: {
            center: true,
        },
        extend: {},
    },
    plugins: [require('@tailwindcss/typography'), require('daisyui')],
};
