#!/bin/bash
set -e

PORT=${PORT:-10000}

echo "Configuring Nginx port to $PORT..."
sed -i "s/listen 10000;/listen ${PORT};/g" /etc/nginx/conf.d/default.conf
sed -i "s/listen \[::\]:10000;/listen \[::\]:${PORT};/g" /etc/nginx/conf.d/default.conf

# Ensure storage & cache permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Cache Laravel configurations in production
if [ "$APP_ENV" = "production" ]; then
    echo "Caching Laravel configuration, routes, and views..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

# Run database migrations automatically
if [ "$SKIP_MIGRATIONS" != "true" ]; then
    echo "Running database migrations..."
    php artisan migrate --force || echo "Migration skipped or failed."
fi

# Start PHP-FPM in background
echo "Starting PHP-FPM..."
php-fpm -D

# Start Nginx in foreground
echo "Starting Nginx on port $PORT..."
exec nginx -g "daemon off;"
