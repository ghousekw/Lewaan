#!/bin/bash
set -e

echo "🔍 Verifying PHP extensions..."
php -m | grep -i pdo
php -m | grep -i pgsql
php -m | grep -i pdo_pgsql

echo "✅ PostgreSQL extensions verified"
echo "📊 Available PDO drivers:"
php -r "print_r(PDO::getAvailableDrivers());"

echo "🚀 Starting Laravel..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan migrate --force

echo "🌐 Starting server on port $PORT..."
php artisan serve --host=0.0.0.0 --port=$PORT
