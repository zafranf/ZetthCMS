let mix = require("laravel-mix");

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
mix.setPublicPath("resources");

/* css */
mix.styles(
    [
        "node_modules/bulma/css/bulma.min.css",
        // "node_modules/bulma-extensions/dist/css/bulma-extensions.min.css",
        "node_modules/bulma-badge/dist/css/bulma-badge.min.css",
        "node_modules/bulma-calendar/dist/css/bulma-calendar.min.css",
        "node_modules/bulma-carousel/dist/css/bulma-carousel.min.css",
        "node_modules/bulma-checkradio/dist/css/bulma-checkradio.min.css",
        "node_modules/bulma-divider/dist/css/bulma-divider.min.css",
        "node_modules/bulma-pageloader/dist/css/bulma-pageloader.min.css",
        "node_modules/bulma-quickview/dist/css/bulma-quickview.min.css",
        "node_modules/bulma-ribbon/dist/css/bulma-ribbon.min.css",
        "node_modules/bulma-steps/dist/css/bulma-steps.min.css",
        "node_modules/bulma-switch/dist/css/bulma-switch.min.css",
        "node_modules/bulma-tagsinput/dist/css/bulma-tagsinput.min.css",
        "node_modules/bulma-timeline/dist/css/bulma-timeline.min.css",
        "node_modules/bulma-tooltip/dist/css/bulma-tooltip.min.css",
        "node_modules/select2/dist/css/select2.min.css",
        "node_modules/quill/dist/quill.snow.css",
        "resources/themes/WebSC/css/app.css"
    ],
    "resources/themes/WebSC/css/styles.css"
).version();

/* js */
mix.scripts(
    [
        "node_modules/jquery/dist/jquery.min.js",
        // "node_modules/bulma-extensions/dist/js/bulma-extensions.min.js",
        "node_modules/bulma-calendar/dist/js/bulma-calendar.min.js",
        "node_modules/bulma-carousel/dist/js/bulma-carousel.min.js",
        "node_modules/bulma-quickview/dist/js/bulma-quickview.min.js",
        "node_modules/bulma-steps/dist/js/bulma-steps.min.js",
        "node_modules/bulma-tagsinput/dist/js/bulma-tagsinput.min.js",
        "node_modules/select2/dist/js/select2.min.js",
        "node_moduls/quill/dist/quill.min.js",
        "resources/themes/WebSC/js/app.js"
    ],
    "resources/themes/WebSC/js/scripts.js"
).version();
