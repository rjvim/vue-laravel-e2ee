const mix = require("laravel-mix");
const tailwindcss = require("tailwindcss");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.wasm$/,
                type: "javascript/auto",
                loader: "file-loader"
            }
        ]
    }
});

mix.js("resources/js/app.js", "public/js")
    .options({
        processCssUrls: false,
        postCss: [tailwindcss("./tailwind.config.js")]
    })
    .sass("resources/sass/app.scss", "public/css");

if (mix.inProduction()) {
    mix.version();
}
