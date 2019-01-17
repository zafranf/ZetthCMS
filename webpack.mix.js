let mix = require('laravel-mix');

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

/* css */
mix.styles([
    'resources/assets/admin/plugins/pace/pace-theme-flash.css',
    'resources/assets/admin/plugins/bootstrap/css/bootstrap.min.css',
    'resources/assets/admin/plugins/font-awesome/css/font-awesome.css',
    'resources/assets/admin/plugins/jquery-scrollbar/jquery.scrollbar.css',
    'resources/assets/admin/plugins/select2/css/select2.min.css',
    'resources/assets/admin/plugins/switchery/css/switchery.min.css',
    'resources/assets/admin/pages/css/pages-icons.css',
    'resources/assets/admin/pages/css/pages.min.css',
], 'public/css/admin.css').version();

/* js */
mix.styles([
    'resources/assets/admin/plugins/pace/pace.min.js',
    'resources/assets/admin/plugins/jquery/jquery-3.2.1.min.js',
    'resources/assets/admin/plugins/modernizr.custom.js',
    'resources/assets/admin/plugins/jquery-ui/jquery-ui.min.js',
    'resources/assets/admin/plugins/popper/umd/popper.min.js',
    'resources/assets/admin/plugins/bootstrap/js/bootstrap.min.js',
    'resources/assets/admin/plugins/jquery/jquery-easy.js',
    'resources/assets/admin/plugins/jquery-unveil/jquery.unveil.min.js',
    'resources/assets/admin/plugins/jquery-ios-list/jquery.ioslist.min.js',
    'resources/assets/admin/plugins/jquery-actual/jquery.actual.min.js',
    'resources/assets/admin/plugins/jquery-scrollbar/jquery.scrollbar.min.js',
    'resources/assets/admin/plugins/select2/js/select2.full.min.js',
    'resources/assets/admin/plugins/classie/classie.js',
    'resources/assets/admin/plugins/switchery/js/switchery.min.js',
    'resources/assets/admin/pages/js/pages.js',
    'resources/assets/admin/js/scripts.js',
], 'public/js/admin.js').version();