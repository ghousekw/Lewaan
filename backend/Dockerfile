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
    && docker-php-ext-install mbstring zip gd intl bcmath exif

# CRITICAL: Remove any php.ini file that might exist (we'll use conf.d only)
# PHP will use default php.ini-development or php.ini-production if needed
# We DO NOT create a custom php.ini - extensions are loaded via conf.d
RUN rm -f /usr/local/etc/php/php.ini 2>/dev/null || true \
    && echo "Removed any existing php.ini file"

# Enable extensions using docker-php-ext-enable (standard PHP Docker way)
# This creates proper .ini files in conf.d directory
RUN docker-php-ext-enable pgsql pdo_pgsql

# Verify extensions are properly configured in conf.d
RUN ls -la /usr/local/etc/php/conf.d/ | grep -E "(pgsql|pdo)" || echo "Warning: Extension ini files not found"

# Verify PHP can parse configuration without errors (this will fail if php.ini has syntax errors)
RUN php --ini 2>&1 | tee /tmp/php-ini-check.txt \
    && if grep -q "syntax error" /tmp/php-ini-check.txt; then \
        echo "ERROR: PHP configuration has syntax errors!"; \
        cat /tmp/php-ini-check.txt; \
        exit 1; \
    fi \
    && echo "✓ PHP configuration is valid"

# Verify pdo_pgsql is installed and enabled at build time
RUN php -r "if (!extension_loaded('pdo_pgsql')) { echo 'ERROR: pdo_pgsql extension not loaded at build time!\n'; phpinfo(INFO_MODULES); exit(1); }" \
    && php -m | grep -i pdo_pgsql \
    && php -r "echo 'Available PDO drivers: '; print_r(PDO::getAvailableDrivers());" \
    && echo "✓ pdo_pgsql extension verified at build time"

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files (build context is backend directory)
# Exclude any php.ini files that might accidentally be in the repo
COPY . .
# Ensure no php.ini was copied (safety check)
RUN if [ -f /var/www/html/php.ini ]; then \
        echo "WARNING: php.ini found in application files, removing it"; \
        rm -f /var/www/html/php.ini; \
    fi

# Install PHP dependencies
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --optimize-autoloader --no-interaction --prefer-dist --no-dev

# Set permissions
RUN chmod -R 755 storage bootstrap/cache

# Create startup script with comprehensive checks
RUN echo '#!/bin/sh' > /start.sh && \
    echo 'set -e' >> /start.sh && \
    echo 'echo "=========================================="' >> /start.sh && \
    echo 'echo "=== PHP Configuration Diagnostics ==="' >> /start.sh && \
    echo 'echo "=========================================="' >> /start.sh && \
    echo 'echo ""' >> /start.sh && \
    echo 'echo "Checking for php.ini files..."' >> /start.sh && \
    echo 'if [ -f /usr/local/etc/php/php.ini ]; then' >> /start.sh && \
    echo '  echo "WARNING: php.ini file exists at /usr/local/etc/php/php.ini"' >> /start.sh && \
    echo '  echo "First 5 lines:"' >> /start.sh && \
    echo '  head -5 /usr/local/etc/php/php.ini' >> /start.sh && \
    echo 'else' >> /start.sh && \
    echo '  echo "✓ No custom php.ini file (using defaults)"' >> /start.sh && \
    echo 'fi' >> /start.sh && \
    echo 'echo ""' >> /start.sh && \
    echo 'echo "Extension ini files in conf.d:"' >> /start.sh && \
    echo 'ls -la /usr/local/etc/php/conf.d/ | grep -E "(pgsql|pdo)" || echo "No pgsql ini files found"' >> /start.sh && \
    echo 'echo ""' >> /start.sh && \
    echo 'echo "Testing PHP configuration syntax..."' >> /start.sh && \
    echo 'if ! php --ini > /tmp/php-ini-output.txt 2>&1; then' >> /start.sh && \
    echo '  echo "✗ ERROR: PHP configuration has syntax errors!"' >> /start.sh && \
    echo '  cat /tmp/php-ini-output.txt' >> /start.sh && \
    echo '  exit 1' >> /start.sh && \
    echo 'fi' >> /start.sh && \
    echo 'echo "✓ PHP configuration is valid"' >> /start.sh && \
    echo 'echo ""' >> /start.sh && \
    echo 'echo "=== PHP Extension Check ==="' >> /start.sh && \
    echo 'php -r "if (extension_loaded(\"pdo_pgsql\")) { echo \"✓ pdo_pgsql extension is LOADED\n\"; echo \"Available PDO drivers: \"; print_r(PDO::getAvailableDrivers()); } else { echo \"✗ ERROR: pdo_pgsql extension is NOT loaded!\n\"; echo \"Loaded extensions:\"; print_r(get_loaded_extensions()); exit(1); }"' >> /start.sh && \
    echo 'echo ""' >> /start.sh && \
    echo 'echo "=== Running Migrations ==="' >> /start.sh && \
    echo 'php artisan migrate --force' >> /start.sh && \
    echo 'echo ""' >> /start.sh && \
    echo 'PORT=${PORT:-8000}' >> /start.sh && \
    echo 'echo "=== Starting Laravel Server on port $PORT ==="' >> /start.sh && \
    echo 'exec php artisan serve --host=0.0.0.0 --port="$PORT"' >> /start.sh && \
    chmod +x /start.sh

# Expose port
EXPOSE 8000

# Start command
CMD ["/start.sh"]

