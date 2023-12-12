npm install
composer install
<!--  -->
coposer create-project laravel/laravel laravel8
<!-- Yajra Datatable -->
composer require yajra/laravel-datatables-oracle:"^9,0"  
php artisan vendor:publish --tag=datatables
<!-- Image Intervention -->
composer require intervention/image  
php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravelRecent"
<!-- bumbumen99/shoppin cart -->
composer require bumbummen99/shoppingcart
php artisan vendor:publish --provider="Gloudemans\Shoppingcart\ShoppingcartServiceProvider" --tag="config"
<!-- Authintication Laravel UI -->
composer require laravel/ui
php artisan ui bootstrap
php artisan ui bootstrap --auth
<!-- development command -->
npm install && npm run dev
npm run dev
npm run watch

php artisan migrate
