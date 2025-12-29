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

# Create startup script with comprehensive extension check
RUN echo '#!/bin/sh' > /start.sh && \
    echo 'set -e' >> /start.sh && \
    echo 'echo "=== PHP Extension Check at Runtime ==="' >> /start.sh && \
    echo 'echo "PHP Version: $(php -v | head -1)"' >> /start.sh && \
    echo 'echo ""' >> /start.sh && \
    echo 'echo "Checking for pdo_pgsql extension..."' >> /start.sh && \
    echo 'if php -m | grep -q pdo_pgsql; then' >> /start.sh && \
    echo '  echo "✓ pdo_pgsql extension is LOADED"' >> /start.sh && \
    echo '  php -r "echo \"Available PDO drivers: \"; print_r(PDO::getAvailableDrivers());"' >> /start.sh && \
    echo 'else' >> /start.sh && \
    echo '  echo "✗ ERROR: pdo_pgsql extension is NOT loaded!"' >> /start.sh && \
    echo '  echo "All loaded extensions:"' >> /start.sh && \
    echo '  php -m' >> /start.sh && \
    echo '  echo ""' >> /start.sh && \
    echo '  echo "Checking extension files..."' >> /start.sh && \
    echo '  find /usr/local/lib/php/extensions -name "*pgsql*" 2>/dev/null || echo "No pgsql extensions found"' >> /start.sh && \
    echo '  echo ""' >> /start.sh && \
    echo '  echo "PHP configuration:"' >> /start.sh && \
    echo '  php --ini' >> /start.sh && \
    echo '  exit 1' >> /start.sh && \
    echo 'fi' >> /start.sh && \
    echo 'echo ""' >> /start.sh && \
    echo 'php artisan migrate --force' >> /start.sh && \
    echo 'PORT=${PORT:-8000}' >> /start.sh && \
    echo 'exec php artisan serve --host=0.0.0.0 --port="$PORT"' >> /start.sh && \
    chmod +x /start.sh

# Expose port
EXPOSE 8000

# Start command
CMD ["/start.sh"]

