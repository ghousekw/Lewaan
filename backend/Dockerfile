FROM php:8.4-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pgsql \
        mbstring \
        zip \
        gd \
        intl \
        bcmath \
        exif \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /app

# Copy files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Permissions (important for Laravel)
RUN chmod -R 775 storage bootstrap/cache

# Expose Railway port
EXPOSE 8080

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8080

# FROM php:8.4-cli

# # Install system dependencies REQUIRED for PHP extensions
# RUN apt-get update && apt-get install -y \
#     git \
#     unzip \
#     pkg-config \
#     libpq-dev \
#     libzip-dev \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     libicu-dev \
#     libxml2-dev \
#     libcurl4-openssl-dev \
#     libonig-dev \
#     && rm -rf /var/lib/apt/lists/*

# # Configure GD properly
# RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# # Install PHP extensions
# RUN docker-php-ext-install \
#     pdo \
#     pdo_pgsql \
#     pgsql \
#     mbstring \
#     xml \
#     curl \
#     zip \
#     gd \
#     intl \
#     bcmath \
#     exif

# # Explicitly enable PostgreSQL extensions (docker-php-ext-install doesn't always enable)
# RUN docker-php-ext-enable pdo pgsql pdo_pgsql

# # Verify pdo_pgsql is installed and enabled
# RUN php -r "if (!extension_loaded('pdo_pgsql')) { echo 'ERROR: pdo_pgsql extension not loaded!\n'; exit(1); }" \
#     && php -m | grep -i pdo_pgsql \
#     && php -r "echo 'PDO drivers: '; print_r(PDO::getAvailableDrivers());" \
#     && echo "✓ pdo_pgsql extension verified"

# # Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# WORKDIR /var/www/html
# COPY . .

# ENV COMPOSER_ALLOW_SUPERUSER=1
# RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# EXPOSE 8000

# # Use PORT environment variable (Railway automatically sets this)
# CMD sh -c 'php artisan serve --host=0.0.0.0 --port=$PORT'
