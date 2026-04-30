FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader

FROM php:8.2-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . .
COPY --from=vendor /app/vendor ./vendor

RUN cp .env.example .env \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

