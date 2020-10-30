const mix = require('laravel-mix');

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


//mix.js('resources/js/xlsgene.js', 'public/xls_gen');

//Minificador de libs para generar archivos XLS
mix.combine(['public/xls_gen/Blob.min.js',
    'public/xls_gen/FileSaver.min.js',
    'public/xls_gen/xls.core.min.js',
    'public/xls_gen/xlsx.full.min.js'
], 'resources/js/xls.js');