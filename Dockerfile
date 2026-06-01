FROM node:20-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build


FROM php:8.4-fpm-alpine AS app

RUN apk add --no-cache \
        nginx \
        supervisor \
        bash \
        netcat-openbsd \
        libzip-dev \
        icu-dev \
        oniguruma-dev \
        libpng-dev \
        postgresql-dev \
    && docker-php-ext-install \
        pdo_pgsql \
        pgsql \
        bcmath \
        intl \
        zip \
        gd \
        opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader --prefer-dist --no-interaction

COPY . .
COPY --from=assets /app/public/build ./public/build

RUN composer dump-autoload --optimize \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod +x docker/entrypoint.sh

COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf

EXPOSE 80

ENTRYPOINT ["docker/entrypoint.sh"]
