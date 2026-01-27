FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
  git unzip zip libzip-dev \
  libpng-dev libjpeg62-turbo-dev libfreetype6-dev libwebp-dev \
  libonig-dev libxml2-dev \
  libpq-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
  && docker-php-ext-install pdo_pgsql mbstring zip exif pcntl gd \
  && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
