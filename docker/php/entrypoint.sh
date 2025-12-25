#!/bin/bash
set -e

cd /var/www/html

php artisan config:clear
php artisan cache:clear
php artisan config:cache

exec "$@"
