#!/bin/sh
set -e

# Copy .env.example → .env if no .env exists
if [ ! -f /var/www/html/.env ]; then
    echo "[entrypoint] No .env found, copying from .env.example"
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Ensure storage dirs exist and are writable
mkdir -p /var/www/html/storage/logs \
         /var/www/html/storage/framework/cache \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Run artisan setup steps (requires APP_URL to be set)
php artisan package:discover --ansi 2>/dev/null || true
php artisan storage:link --force 2>/dev/null || true
php artisan config:clear 2>/dev/null || true
php artisan view:clear  2>/dev/null || true

echo "[entrypoint] Starting php-fpm..."
exec php-fpm
