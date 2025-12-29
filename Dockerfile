FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    libpq-dev \
    postgresql-client \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions - install pdo_pgsql with all dependencies
RUN docker-php-ext-install pdo pgsql pdo_pgsql \
    && docker-php-ext-enable pdo_pgsql \
    && docker-php-ext-install mbstring zip gd intl bcmath exif

# Explicitly enable pdo_pgsql by creating ini files
RUN echo "extension=pgsql.so" > /usr/local/etc/php/conf.d/docker-php-ext-pgsql.ini \
    && echo "extension=pdo_pgsql.so" > /usr/local/etc/php/conf.d/docker-php-ext-pdo_pgsql.ini \
    && ls -la /usr/local/etc/php/conf.d/ | grep pgsql

# Create a php.ini file that PHP CLI will actually load
RUN php -r "echo '[PHP]\n'; echo 'extension_dir=' . ini_get('extension_dir') . '\n'; echo 'extension=pgsql.so\n'; echo 'extension=pdo_pgsql.so\n';" > /usr/local/etc/php/php.ini \
    && cat /usr/local/etc/php/php.ini

# Verify pdo_pgsql is installed and enabled at build time
RUN php -r "if (!extension_loaded('pdo_pgsql')) { echo 'ERROR: pdo_pgsql extension not loaded at build time!\n'; phpinfo(INFO_MODULES); exit(1); }" \
    && php -m | grep -i pdo_pgsql \
    && php -r "echo 'Available PDO drivers: '; print_r(PDO::getAvailableDrivers());" \
    && echo "✓ pdo_pgsql extension verified at build time"

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files from backend directory
COPY backend/ .

# Install PHP dependencies
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --optimize-autoloader --no-interaction --prefer-dist --no-dev

# Set permissions
RUN chmod -R 755 storage bootstrap/cache

# Create startup script
RUN echo '#!/bin/sh' > /start.sh && \
    echo 'set -e' >> /start.sh && \
    echo 'echo "=== PHP Extension Check ==="' >> /start.sh && \
    echo 'php -r "if (extension_loaded(\"pdo_pgsql\")) { echo \"✓ pdo_pgsql extension is LOADED\n\"; echo \"Available PDO drivers: \"; print_r(PDO::getAvailableDrivers()); } else { echo \"✗ ERROR: pdo_pgsql extension is NOT loaded!\n\"; exit(1); }"' >> /start.sh && \
    echo 'echo ""' >> /start.sh && \
    echo 'php artisan migrate --force' >> /start.sh && \
    echo 'PORT=${PORT:-8000}' >> /start.sh && \
    echo 'exec php artisan serve --host=0.0.0.0 --port="$PORT"' >> /start.sh && \
    chmod +x /start.sh

# Expose port
EXPOSE 8000

# Start command
CMD ["/start.sh"]

