FROM node:22-alpine AS node
WORKDIR /app
COPY package.json vite.config.js ./
RUN npm install
COPY resources/ resources/
RUN npm run build

FROM composer:latest AS composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

FROM php:8.4-fpm-alpine
RUN apk add --no-cache nginx supervisor linux-headers \
    && docker-php-ext-install pdo pdo_mysql

COPY --from=composer /app/vendor/ /app/vendor/
COPY --from=node /app/public/build/ /app/public/build/
COPY . /app/

RUN rm -f /app/bootstrap/cache/packages.php /app/bootstrap/cache/services.php \
    && php /app/artisan package:discover --ansi

COPY docker/supervisor.conf /etc/supervisor/conf.d/laravel.conf
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh \
    && chmod -R 775 /app/storage /app/bootstrap/cache \
    && chown -R www-data:www-data /app/storage /app/bootstrap/cache

WORKDIR /app
EXPOSE 80
ENTRYPOINT ["/entrypoint.sh"]
