FROM php:8.3-cli

# Install system dependencies and PostgreSQL client
RUN apt-get update && apt-get install -y \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    libpq-dev \
    postgresql-client \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pgsql \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install mbstring zip gd intl bcmath exif \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    && php -r "if (!extension_loaded('pdo_pgsql')) { echo 'ERROR: pdo_pgsql extension not loaded!\n'; echo 'Loaded extensions:\n'; print_r(get_loaded_extensions()); exit(1); }" \
    && echo "✓ pdo_pgsql extension verified"

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files (build context is backend directory)
COPY . .

# Install PHP dependencies
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --optimize-autoloader --no-interaction --prefer-dist --no-dev

# Set permissions
RUN chmod -R 755 storage bootstrap/cache

# Create startup script
RUN echo '#!/bin/sh' > /start.sh && \
    echo 'set -e' >> /start.sh && \
    echo 'echo "=== Checking PHP extensions ==="' >> /start.sh && \
    echo 'php -m | grep pdo' >> /start.sh && \
    echo 'if php -m | grep -q pdo_pgsql; then' >> /start.sh && \
    echo '  echo "✓ pdo_pgsql is loaded"' >> /start.sh && \
    echo 'else' >> /start.sh && \
    echo '  echo "✗ ERROR: pdo_pgsql is NOT loaded!"' >> /start.sh && \
    echo '  echo "Available PDO drivers:"' >> /start.sh && \
    echo '  php -r "print_r(PDO::getAvailableDrivers());"' >> /start.sh && \
    echo '  exit 1' >> /start.sh && \
    echo 'fi' >> /start.sh && \
    echo 'php artisan migrate --force' >> /start.sh && \
    echo 'PORT=${PORT:-8000}' >> /start.sh && \
    echo 'exec php artisan serve --host=0.0.0.0 --port="$PORT"' >> /start.sh && \
    chmod +x /start.sh

# Expose port
EXPOSE 8000

# Start command
CMD ["/start.sh"]

