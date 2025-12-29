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

# Install PHP extensions - install pdo_pgsql first as it depends on pdo and pgsql
RUN docker-php-ext-install pdo pgsql pdo_pgsql \
    && docker-php-ext-enable pdo_pgsql \
    && docker-php-ext-install mbstring zip gd intl bcmath exif

# Verify pdo_pgsql is installed and enabled
RUN php -r "if (!extension_loaded('pdo_pgsql')) { echo 'ERROR: pdo_pgsql extension not loaded!\n'; phpinfo(INFO_MODULES); exit(1); }" \
    && php -m | grep -i pdo_pgsql \
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

# Create startup script with comprehensive extension check
RUN echo '#!/bin/sh' > /start.sh && \
    echo 'set -e' >> /start.sh && \
    echo 'echo "=== PHP Extension Check ==="' >> /start.sh && \
    echo 'echo "PHP Version: $(php -v | head -1)"' >> /start.sh && \
    echo 'echo "All loaded extensions:"' >> /start.sh && \
    echo 'php -m' >> /start.sh && \
    echo 'echo ""' >> /start.sh && \
    echo 'echo "PDO extensions:"' >> /start.sh && \
    echo 'php -m | grep -i pdo || echo "No PDO extensions found"' >> /start.sh && \
    echo 'echo ""' >> /start.sh && \
    echo 'echo "Available PDO drivers:"' >> /start.sh && \
    echo 'php -r "print_r(PDO::getAvailableDrivers());"' >> /start.sh && \
    echo 'echo ""' >> /start.sh && \
    echo 'if php -m | grep -q pdo_pgsql; then' >> /start.sh && \
    echo '  echo "✓ pdo_pgsql extension is LOADED"' >> /start.sh && \
    echo 'else' >> /start.sh && \
    echo '  echo "✗ ERROR: pdo_pgsql extension is NOT loaded!"' >> /start.sh && \
    echo '  echo "Checking extension files..."' >> /start.sh && \
    echo '  ls -la /usr/local/lib/php/extensions/*/pdo_pgsql.so 2>/dev/null || echo "pdo_pgsql.so not found in extensions directory"' >> /start.sh && \
    echo '  php --ini' >> /start.sh && \
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

