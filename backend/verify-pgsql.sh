#!/bin/bash
# Script to verify PostgreSQL extensions in Railway container

echo "🔍 Checking PHP Version..."
php -v

echo ""
echo "📦 Checking installed PHP extensions..."
php -m | grep -i pgsql || echo "❌ No PostgreSQL extensions found!"

echo ""
echo "🔌 Checking PDO drivers..."
php -r "echo 'Available PDO drivers: '; print_r(PDO::getAvailableDrivers());"

echo ""
echo "✅ Testing pdo_pgsql extension..."
php -r "if (extension_loaded('pdo_pgsql')) { echo '✓ pdo_pgsql is loaded\n'; } else { echo '❌ pdo_pgsql is NOT loaded\n'; exit(1); }"

echo ""
echo "✅ Testing pgsql extension..."
php -r "if (extension_loaded('pgsql')) { echo '✓ pgsql is loaded\n'; } else { echo '❌ pgsql is NOT loaded\n'; exit(1); }"

echo ""
echo "🔗 Testing database connection..."
php artisan tinker --execute="try { DB::connection()->getPdo(); echo '✓ Database connection successful\n'; } catch (Exception \$e) { echo '❌ Database connection failed: ' . \$e->getMessage() . '\n'; exit(1); }"

echo ""
echo "🎉 All checks passed!"

