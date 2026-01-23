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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');


mix.js('resources/js/vue-pages/app-pesaje-approve.js','public/js/admin');    
mix.js('resources/js/vue-pages/app-pesaje.js','public/js/admin');    
mix.js('resources/js/vue-pages/app-anagua.js','public/js/admin');    
mix.js('resources/js/vue-pages/app-addgranel.js','public/js/admin');    
mix.js('resources/js/vue-pages/app-fetchpacking.js','public/js/admin');       
mix.js('resources/js/vue-pages/app-packing.js','public/js/admin');      
mix.js('resources/js/vue-pages/app-addestandares.js', 'public/js/admin');
mix.js('resources/js/vue-pages/app-addcontroles.js', 'public/js/admin');
mix.js('resources/js/vue-pages/app-addinspecciones.js', 'public/js/admin');
mix.js('resources/js/vue-pages/app-controlproducto.js', 'public/js/vue-pages');
mix.js('resources/js/vue-pages/app-tanque.js', 'public/js/vue-pages');


mix.js('resources/js/vue-pages/app-fetchpacking.js','public/js');    

mix.js('resources/js/vue-pages/app-listuser.js','public/js/admin');
mix.js('resources/js/vue-pages/app-createuser.js','public/js/admin');
mix.js('resources/js/vue-pages/app-edituser.js','public/js/admin');   

mix.js('resources/js/vue-pages/app-packing-status.js','public/js/admin');   
mix.js('resources/js/vue-pages/app-mix-status.js','public/js/admin');   
