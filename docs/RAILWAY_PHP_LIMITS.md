# Fix Upload Limits on Railway

## Problem
Your uploads are failing because PHP limits are too low:
- `upload_max_filesize`: 2M (too small!)
- `post_max_size`: 8M (too small!)
- `memory_limit`: 128M (might not be enough for image processing)

## Solution

Add these environment variables to Railway:

### Go to Railway Dashboard → Your Service → Variables

Add these:

```env
PHP_UPLOAD_MAX_FILESIZE=20M
PHP_POST_MAX_SIZE=25M
PHP_MEMORY_LIMIT=256M
PHP_MAX_EXECUTION_TIME=60
PHP_MAX_INPUT_TIME=60
```

### Alternative: Using nixpacks.toml

If the above doesn't work, update `backend/nixpacks.toml`:

```toml
[phases.setup]
nixPkgs = ['php84', 'php84Packages.composer', 'php84Extensions.pdo', 'php84Extensions.pdo_pgsql', 'php84Extensions.mbstring', 'php84Extensions.xml', 'php84Extensions.curl', 'php84Extensions.zip', 'php84Extensions.gd', 'php84Extensions.intl', 'php84Extensions.bcmath']

[phases.install]
cmds = ['composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist']

[phases.build]
cmds = [
    'php artisan view:cache',
    'echo "upload_max_filesize = 20M" > /app/public/.user.ini',
    'echo "post_max_size = 25M" >> /app/public/.user.ini',
    'echo "memory_limit = 256M" >> /app/public/.user.ini',
    'echo "max_execution_time = 60" >> /app/public/.user.ini'
]

[start]
cmd = 'php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT'
```

## After Adding Variables

1. Railway will automatically redeploy
2. Wait for deployment to complete
3. Visit: `https://api.lewaninterior.com/check-server`
4. Verify the new limits are applied
5. Try uploading again

## Expected Values After Fix

```json
{
  "upload_max_filesize": "20M",
  "post_max_size": "25M",
  "memory_limit": "256M",
  "max_execution_time": "60"
}
```

## Why These Values?

- **upload_max_filesize: 20M** - Allows individual files up to 20MB
- **post_max_size: 25M** - Allows total upload (multiple files) up to 25MB
- **memory_limit: 256M** - Enough memory for image processing
- **max_execution_time: 60s** - Enough time for Cloudinary uploads

## Troubleshooting

### Still showing old values?
- Clear cache: `https://api.lewaninterior.com/clear-cache`
- Check Railway logs for PHP errors
- Restart the service manually in Railway

### Upload still fails?
- Check file size is under 20MB
- Check Railway logs for specific error
- Try uploading a smaller test image first
