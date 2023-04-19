git pull
composer install
yarn
php artisan key:generate
php artisan migrate
php artisan migrate --path=database/migrations/customs
php artisan db:seed
yarn build-full-dev