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

// Project Dependencies
mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

//backend
mix.js('resources/assets/js/backend.js', 'public/js');

// Core UI Theme
mix.js('resources/assets/js/themes/coreui/coreui.js', 'public/js/themes/coreui')
   .js('resources/assets/js/themes/coreui/views/pace.min.js','public/js/themes/coreui')
   .js('resources/assets/js/themes/coreui/views/main.js', 'public/js/themes/coreui')
   .copyDirectory('resources/assets/img/themes/coreui', 'public/img/themes/coreui')
   .copyDirectory('resources/assets/fonts/themes/coreui', 'public/fonts/themes/coreui')
   .sass('resources/assets/sass/themes/coreui/style.scss','public/css/themes/coreui');


// Theme 2 - Anna Scheffield
mix.sass('resources/assets/sass/themes/theme2/theme2.scss','public/css/themes/theme2')
   .js('resources/assets/js/themes/theme2/theme2.js','public/js/themes/theme2')
   .copyDirectory('resources/assets/img/themes/theme1', 'public/img/themes/theme2');

// Vue good tables
mix.copyDirectory('resources/assets/img/themes/vue-good-table','public/img/themes/vue-good-table');

// Page Specific Mix

// Admins
mix.js('resources/assets/js/views/admins/login.js','public/js/views/admins')
   .js('resources/assets/js/views/admins/general.js','public/js/views/admins')
   .js('resources/assets/js/views/admins/index.js','public/js/views/admins')
   .js('resources/assets/js/views/admins/home.js','public/js/views/admins')
   .js('resources/assets/js/views/admins/charts.js','public/js/views/admins')
   .sass('resources/assets/sass/views/admins/general.scss','public/css/views/admins');

// Auth
mix.js('resources/assets/js/views/auth/login.js','public/js/views/auth')
   .js('resources/assets/js/views/auth/register.js','public/js/views/auth');

// Collection
mix.js('resources/assets/js/views/collections/create.js','public/js/views/collections')
   .js('resources/assets/js/views/collections/set.js','public/js/views/collections');

// Companies
mix.js('resources/assets/js/views/companies/create.js','public/js/views/companies');

// Home
mix.js('resources/assets/js/views/home/index.js','public/js/views/home')
   .js('resources/assets/js/views/home/shop.js','public/js/views/home')
   .js('resources/assets/js/views/home/cart.js','public/js/views/home')
   .js('resources/assets/js/views/home/checkout.js','public/js/views/home')
   .js('resources/assets/js/views/home/pages.js','public/js/views/home');

// inventory
mix.js('resources/assets/js/views/inventories/index.js','public/js/views/inventories');

// inventory items
mix.js('resources/assets/js/views/inventory_items/create.js','public/js/views/inventory_items')
   .js('resources/assets/js/views/inventory_items/edit.js','public/js/views/inventory_items')
   .js('resources/assets/js/views/inventory_items/shop.js','public/js/views/inventory_items');

// invoices
mix.js('resources/assets/js/views/invoices/finish.js','public/js/views/invoices')
   .js('resources/assets/js/views/invoices/create.js','public/js/views/invoices')
   .js('resources/assets/js/views/invoices/edit.js','public/js/views/invoices');
// invoice items
mix.js('resources/assets/js/views/invoice_items/edit.js','public/js/views/invoice_items');


// Reports
mix.js('resources/assets/js/views/reports/weeks.js','public/js/views/reports')
   .js('resources/assets/js/views/reports/months.js','public/js/views/reports')
   .js('resources/assets/js/views/reports/years.js','public/js/views/reports');


// size
mix.js('resources/assets/js/views/sizes/create.js','public/js/views/sizes');

