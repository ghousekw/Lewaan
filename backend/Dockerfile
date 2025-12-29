FROM php:8.3-cli

# System libraries needed for PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libicu-dev \
    libxml2-dev \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions required by Laravel + Filament
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    zip \
    gd \
    intl \
    bcmath \
    exif

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader --no-interaction

EXPOSE 8000

CMD php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=8000
