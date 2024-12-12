module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                primary: '#5A67D8',
            },
            textColors: {
                primary: '#5A67D8'
            },
        },
    },
    plugins: [
        require('@tailwindcss/typography')
    ],
};
