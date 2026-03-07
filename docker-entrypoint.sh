#!/bin/sh
set -e
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/vendor

php artisan storage:link --force
php artisan migrate --force

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec php-fpm