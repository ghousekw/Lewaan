# Fix Upload Error on Railway

## The Problem
You're getting "Error during upload" when trying to upload images to your portfolio on Railway.

## Root Cause
Railway's filesystem is **ephemeral** - files get deleted on redeploy. You need cloud storage (Cloudinary).

---

## Quick Fix Steps

### Step 1: Check Current Configuration

Visit: `https://api.lewaninterior.com/debug-config`

This will show you:
- Current filesystem disk
- Whether Cloudinary is configured
- PHP upload limits
- Image processing libraries

### Step 2: Add Cloudinary to Railway

1. **Go to Railway Dashboard** → Your Backend Service → **Variables**

2. **Add these environment variables**:
```env
FILESYSTEM_DISK=cloudinary
MEDIA_DISK=cloudinary

CLOUDINARY_CLOUD_NAME=your_cloud_name_here
CLOUDINARY_API_KEY=your_api_key_here
CLOUDINARY_API_SECRET=your_api_secret_here
CLOUDINARY_URL=cloudinary://api_key:api_secret@cloud_name
```

3. **Get Cloudinary credentials**:
   - Sign up at: https://cloudinary.com/users/register_free
   - Go to Dashboard: https://console.cloudinary.com/
   - Copy: Cloud Name, API Key, API Secret

### Step 3: Increase PHP Upload Limits (if needed)

Add to Railway Variables:
```env
PHP_UPLOAD_MAX_FILESIZE=20M
PHP_POST_MAX_SIZE=25M
PHP_MEMORY_LIMIT=256M
```

### Step 4: Deploy Changes

Railway will automatically redeploy when you add variables.

Wait for deployment to complete (check Railway logs).

### Step 5: Test Upload

1. Go to: `https://api.lewaninterior.com/admin/portfolios`
2. Edit a portfolio
3. Try uploading an image
4. Should work now! ✅

---

## Alternative: Use Public Disk Temporarily

If you want to test locally first:

### Update Railway Variables:
```env
FILESYSTEM_DISK=public
MEDIA_DISK=public
```

**⚠️ WARNING**: Files will be deleted on redeploy! Only use for testing.

---

## Troubleshooting

### Still Getting Errors?

1. **Check Railway Logs**:
   - Railway Dashboard → Your Service → Deployments → View Logs
   - Look for PHP errors or upload failures

2. **Check File Size**:
   - Max thumbnail: 5MB (5120KB)
   - Max gallery: 10MB (10240KB)
   - Reduce image size if needed

3. **Check Image Format**:
   - Supported: JPG, PNG, WEBP, GIF
   - Not supported: HEIC, TIFF, BMP

4. **Clear Cache**:
   ```bash
   # In Railway terminal or via CLI
   php artisan config:clear
   php artisan cache:clear
   php artisan optimize:clear
   ```

### Error: "Class 'Cloudinary' not found"

The package isn't installed. Run locally:
```bash
cd backend
composer require cloudinary-labs/cloudinary-laravel
git add composer.json composer.lock
git commit -m "Add Cloudinary package"
git push
```

### Error: "Invalid credentials"

Check your Cloudinary credentials:
- Cloud Name: Should be like `dxxxxx` (no spaces)
- API Key: Should be numbers only
- API Secret: Should be alphanumeric string
- CLOUDINARY_URL format: `cloudinary://API_KEY:API_SECRET@CLOUD_NAME`

### Images Upload But Show 404

This means files are on local filesystem (will be deleted).

**Solution**: Configure Cloudinary as shown above.

---

## Verify It's Working

After setup, check:

1. **Upload an image** through admin panel
2. **Check the URL** in browser network tab
3. Should be: `https://res.cloudinary.com/your_cloud_name/...`
4. NOT: `https://api.lewaninterior.com/storage/...`

---

## Example: Complete Railway Variables

```env
# App
APP_NAME="Lewan CMS"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://api.lewaninterior.com
APP_KEY=base64:your_key_here

# Database (Railway auto-provides)
DB_CONNECTION=pgsql
DB_HOST=${PGHOST}
DB_PORT=${PGPORT}
DB_DATABASE=${PGDATABASE}
DB_USERNAME=${PGUSER}
DB_PASSWORD=${PGPASSWORD}

# Session
SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax

# Storage - CLOUDINARY
FILESYSTEM_DISK=cloudinary
MEDIA_DISK=cloudinary

CLOUDINARY_CLOUD_NAME=dxxxxx
CLOUDINARY_API_KEY=123456789012345
CLOUDINARY_API_SECRET=abcdefghijklmnopqrstuvwxyz
CLOUDINARY_URL=cloudinary://123456789012345:abcdefghijklmnopqrstuvwxyz@dxxxxx

# PHP Limits
PHP_UPLOAD_MAX_FILESIZE=20M
PHP_POST_MAX_SIZE=25M
PHP_MEMORY_LIMIT=256M
```

---

## Need Help?

1. Check Railway logs for specific errors
2. Visit `/debug-config` to see current configuration
3. Verify Cloudinary credentials are correct
4. Make sure composer.json includes `cloudinary-labs/cloudinary-laravel`

---

**After fixing, you can remove the `/debug-config` route for security.**
