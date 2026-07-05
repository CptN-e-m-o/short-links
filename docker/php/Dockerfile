FROM php:8.3-fpm-alpine

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apk add --no-cache \
    bash \
    git \
    curl \
    unzip \
    zip \
    icu-dev \
    oniguruma-dev \
    libzip-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    intl \
    zip \
    bcmath \
    pcntl \
    gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/html