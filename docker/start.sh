#!/bin/sh
set -e

echo "Caching config, routes, views and events..."
php artisan optimize

echo "Resetting demo database..."
touch database/database.sqlite
php artisan migrate:fresh --seed --force

echo "Starting FrankenPHP on port ${PORT:-8080}..."
exec frankenphp php-server --listen ":${PORT:-8080}" --root public/
