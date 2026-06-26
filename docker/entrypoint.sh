#!/bin/sh

sed -i "s/listen 80;/listen ${PORT:-80};/" /etc/nginx/nginx.conf

php /app/artisan storage:link --force
php /app/artisan optimize:clear

php /app/artisan migrate --force

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/laravel.conf
