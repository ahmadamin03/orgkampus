#!/bin/sh

php /app/artisan storage:link --force
php /app/artisan optimize:clear

php /app/artisan migrate --force

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/laravel.conf
