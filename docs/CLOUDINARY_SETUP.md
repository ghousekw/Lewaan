# Cloudinary Setup for Railway Deployment

## Why You Need This

Railway's filesystem is **ephemeral** - any files uploaded (like portfolio images) get deleted when:
- You redeploy your app
- Railway restarts your service
- You push new code

This is why your images return 404 errors. You need **cloud storage** to persist uploaded files.

## Solution: Cloudinary (Free Tier)

Cloudinary offers:
- ✅ 25GB storage (free)
- ✅ 25GB bandwidth/month (free)
- ✅ Automatic image optimization
- ✅ CDN delivery
- ✅ Image transformations (resize, crop, etc.)

---

## Step 1: Create Cloudinary Account

1. Go to https://cloudinary.com/users/register_free
2. Sign up for a free account
3. Verify your email

## Step 2: Get Your Credentials

1. Go to your Cloudinary Dashboard: https://console.cloudinary.com/
2. You'll see your credentials:
   - **Cloud Name**: e.g., `dxxxxx`
   - **API Key**: e.g., `123456789012345`
   - **API Secret**: e.g., `abcdefghijklmnopqrstuvwxyz`

## Step 3: Install Cloudinary Package

Run this in your local backend directory:

```bash
cd backend
composer require cloudinary-labs/cloudinary-laravel
```

## Step 4: Publish Cloudinary Config

```bash
php artisan vendor:publish --provider="CloudinaryLabs\CloudinaryLaravel\CloudinaryServiceProvider" --tag="cloudinary-laravel-config"
```

## Step 5: Update Filesystem Configuration

Add this to `backend/config/filesystems.php` in the `disks` array:

```php
'cloudinary' => [
    'driver' => 'cloudinary',
    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
    'api_key' => env('CLOUDINARY_API_KEY'),
    'api_secret' => env('CLOUDINARY_API_SECRET'),
    'url' => [
        'secure' => true,
    ],
],
```

## Step 6: Update Environment Variables

### Local (.env)
```env
FILESYSTEM_DISK=cloudinary
MEDIA_DISK=cloudinary

CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
CLOUDINARY_URL=cloudinary://your_api_key:your_api_secret@your_cloud_name
```

### Railway (Production)

Go to Railway Dashboard → Your Service → Variables, and add:

```env
FILESYSTEM_DISK=cloudinary
MEDIA_DISK=cloudinary

CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
CLOUDINARY_URL=cloudinary://your_api_key:your_api_secret@your_cloud_name
```

## Step 7: Update Portfolio Model

The Portfolio model should use the cloudinary disk. Update `backend/app/Models/Portfolio.php`:

```php
public function registerMediaCollections(): void
{
    $this->addMediaCollection('thumbnail')
        ->useDisk('cloudinary') // Add this line
        ->singleFile()
        ->registerMediaConversions(function (Media $media) {
            $this->addMediaConversion('thumb')
                ->width(400)
                ->height(300)
                ->sharpen(10);
            
            $this->addMediaConversion('large')
                ->width(1200)
                ->height(900)
                ->sharpen(10);
        });

    $this->addMediaCollection('gallery')
        ->useDisk('cloudinary') // Add this line
        ->registerMediaConversions(function (Media $media) {
            $this->addMediaConversion('thumb')
                ->width(400)
                ->height(300)
                ->sharpen(10);
            
            $this->addMediaConversion('large')
                ->width(1920)
                ->height(1080)
                ->sharpen(10);
        });
}
```

## Step 8: Clear Cache and Test

```bash
php artisan config:clear
php artisan cache:clear
```

## Step 9: Re-upload Images

Since your current images are stored locally and will be lost:

1. Go to https://api.lewaninterior.com/admin/portfolios
2. Edit each portfolio
3. Re-upload the thumbnail and gallery images
4. Save

The images will now be stored on Cloudinary and persist across deployments!

## Step 10: Commit and Deploy

```bash
git add .
git commit -m "Add Cloudinary for persistent media storage"
git push
```

Railway will automatically redeploy with Cloudinary configured.

---

## Verification

After setup, your image URLs should look like:
```
https://res.cloudinary.com/your_cloud_name/image/upload/v1234567890/1/conversions/xxx-thumb.jpg
```

Instead of:
```
https://api.lewaninterior.com/storage/1/conversions/xxx-thumb.jpg
```

---

## Alternative: AWS S3

If you prefer AWS S3:

1. Create an S3 bucket
2. Install: `composer require league/flysystem-aws-s3-v3 "^3.0"`
3. Update `.env`:
```env
FILESYSTEM_DISK=s3
MEDIA_DISK=s3

AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_bucket_name
AWS_URL=https://your_bucket.s3.amazonaws.com
```

4. Update Portfolio model to use `->useDisk('s3')`

---

## Troubleshooting

### Images still 404?
- Clear cache: `php artisan config:clear`
- Check Railway environment variables are set
- Verify Cloudinary credentials are correct

### Upload fails?
- Check Cloudinary free tier limits (25GB)
- Verify API credentials
- Check file size limits in `config/media-library.php`

### Old images still showing?
- Delete old media records from database
- Re-upload images through admin panel

---

**Need help?** Check Cloudinary docs: https://cloudinary.com/documentation/laravel_integration
