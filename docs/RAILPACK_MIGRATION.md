# Railpack Migration Complete

Your Laravel application has been successfully migrated from Nixpacks to Railpack.

## Changes Made

### 1. Updated `railway.json`
- Changed builder from `NIXPACKS` to `RAILPACK`
- Removed `startCommand` - Railpack automatically handles Laravel startup with FrankenPHP
- Railpack will automatically:
  - Run database migrations (can be disabled with `RAILPACK_SKIP_MIGRATIONS=true`)
  - Create storage symlinks
  - Optimize the application (config, route, view, event caches)
  - Start FrankenPHP server

### 2. Updated `backend/composer.json`
- Added required PHP extensions as `ext-*` requirements:
  - `ext-pdo` - Database abstraction
  - `ext-pdo_pgsql` - PostgreSQL support
  - `ext-mbstring` - Multibyte string handling
  - `ext-xml` - XML processing
  - `ext-curl` - HTTP client
  - `ext-zip` - Archive handling
  - `ext-gd` - Image processing
  - `ext-intl` - Internationalization
  - `ext-bcmath` - Arbitrary precision mathematics
  - `ext-exif` - Image metadata (required by Spatie packages)

Railpack will automatically install these extensions based on your `composer.json` requirements.

### 3. Updated `composer.lock`
- Regenerated lock file to ensure compatibility with PHP 8.2
- Resolved dependency conflicts with packages requiring PHP 8.4

### 4. Removed `Procfile`
- Deleted `backend/Procfile` which was using `php artisan serve`
- Railpack now uses its default Laravel startup with FrankenPHP automatically

### 5. Archived `nixpacks.toml`
- Renamed to `nixpacks.toml.backup` for reference
- No longer needed as Railpack handles all configuration automatically

## Railpack Features

### Automatic Laravel Detection
- Detects Laravel by presence of `artisan` file
- Sets document root to `/app/public` automatically
- Configures FrankenPHP for optimal performance

### Automatic Optimizations
At build time, Railpack automatically runs:
- `php artisan config:cache`
- `php artisan event:cache`
- `php artisan route:cache`
- `php artisan view:cache`

### Node.js Integration
Your `package.json` is automatically detected:
- Node.js will be installed
- NPM dependencies will be installed
- `npm run build` will be executed (for Vite assets)
- Development dependencies will be pruned in production

### Startup Process
Railpack's default startup for Laravel:
1. Runs database migrations (unless `RAILPACK_SKIP_MIGRATIONS=true`)
2. Creates storage symlinks
3. Optimizes the application
4. Starts FrankenPHP server using Caddyfile

## Environment Variables

You can configure Railpack behavior with these environment variables:

| Variable | Description | Example |
|----------|-------------|---------|
| `RAILPACK_PHP_ROOT_DIR` | Override document root | `/app/public` |
| `RAILPACK_PHP_EXTENSIONS` | Additional PHP extensions | `imagick,redis` |
| `RAILPACK_SKIP_MIGRATIONS` | Disable running migrations | `true` |

## Custom Configuration (Optional)

If you need custom configuration, you can add these files to your project root:

### `/Caddyfile`
Custom Caddy server configuration for FrankenPHP

### `/php.ini`
Custom PHP configuration

### `/start-container.sh`
Custom startup script (overrides default Laravel startup)

## Benefits of Railpack

1. **Modern PHP Server**: Uses FrankenPHP instead of `php artisan serve`
2. **Automatic Optimizations**: Caches are built at build time
3. **Better Performance**: FrankenPHP is more efficient than traditional PHP-FPM
4. **Simpler Configuration**: Less manual configuration needed
5. **Node.js Support**: Automatic frontend build integration

## Next Steps

1. Deploy to Railway - Railpack will automatically detect and build your application
2. Monitor the build logs to ensure all extensions are installed correctly
3. If you need to skip migrations, set `RAILPACK_SKIP_MIGRATIONS=true` in Railway environment variables

## Troubleshooting

### Build Failures

If you encounter build failures:

1. **Missing Extensions** - Ensure all required extensions are listed in `composer.json` as `ext-*` requirements
2. **Lock File Out of Date** - Run `composer update` locally to regenerate `composer.lock`
3. **PHP Version Conflicts** - Ensure `composer.json` specifies `^8.2` and run `composer update` to resolve conflicts
4. **Procfile Conflicts** - Remove any `Procfile` that uses `php artisan serve` - Railpack handles startup automatically

### Common Issues

- **Extension not found**: Add it to `composer.json` as `ext-{name}: *` and update the lock file
- **Composer lock file errors**: Run `composer update` to regenerate the lock file
- **Wrong startup command**: Remove `Procfile` and let Railpack use its default Laravel startup

### Verification

1. **Check build logs** - Railpack will show which extensions are being installed
2. **Verify PHP version** - Your `composer.json` specifies `^8.2` which is compatible
3. **Check extension requirements** - All required extensions are now in `composer.json`
4. **Review environment variables** - Ensure database credentials are set correctly

## Reference

- [Railpack Documentation](https://docs.railway.app/deploy/builds/railpack)
- [FrankenPHP Documentation](https://frankenphp.dev/)

