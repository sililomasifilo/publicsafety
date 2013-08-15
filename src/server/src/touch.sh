#run this file to clear database and
#add fresh values from seeder

php ../laravel/artisan migrate:rollback
php ../laravel/artisan migrate
php ../laravel/artisan db:seed
