#!/bin/sh
set -e

echo "==> Fixing permissions..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

echo "==> Copying compiled assets to shared volume..."
cp -r /var/www/public/build/. /var/www/public/build/ 2>/dev/null || true

echo "==> Linking storage..."
php artisan storage:link --force

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Caching config/routes/views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Starting PHP-FPM..."
exec php-fpm