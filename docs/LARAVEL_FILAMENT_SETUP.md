# Laravel + Filament CMS Setup Guide

## 🎯 Project Overview

**Architecture:**
```
┌─────────────────────────────────────┐
│  Astro Site (lewaninterior.com)     │
│  - Hosted on Netlify                │
│  - Fetches data from Laravel API    │
└──────────────┬──────────────────────┘
               │
               │ REST API
               │
┌──────────────▼──────────────────────┐
│  Laravel Backend (api.lewaninterior.com) │
│  - Filament Admin Panel (/admin)    │
│  - REST API for Astro               │
│  - Hosted on Railway (free)         │
│  - PostgreSQL Database              │
│  - Cloudinary for media             │
└─────────────────────────────────────┘
```

## 📋 Prerequisites

- PHP 8.2+ installed
- Composer installed
- Node.js & npm installed
- Git installed

## 🛠️ Step 1: Create Laravel Project

```bash
# Create new Laravel project
composer create-project laravel/laravel lewan-cms
cd lewan-cms

# Install Filament
composer require filament/filament:"^3.2" -W

# Install Filament Panel
php artisan filament:install --panels

# Install additional Filament plugins
composer require filament/spatie-laravel-media-library-plugin:"^3.2" -W
```

## 🗄️ Step 2: Database Setup

**Option A: Local Development (SQLite)**
```bash
# Update .env
DB_CONNECTION=sqlite
# DB_DATABASE will use database/database.sqlite
```

**Option B: PostgreSQL (Production-ready)**
```bash
# Update .env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=lewan_cms
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## 📦 Step 3: Create Models & Migrations

```bash
# Create Portfolio model with migration
php artisan make:model Portfolio -m

# Create Category model (optional)
php artisan make:model Category -m
```

## 🎨 Step 4: Install Media Library

```bash
# Install Spatie Media Library
composer require "spatie/laravel-medialibrary:^11.0.0"

# Publish config
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"

# Run migrations
php artisan migrate
```

## 🔐 Step 5: Create Admin User

```bash
# Create Filament user
php artisan make:filament-user

# Follow prompts:
# Name: Admin
# Email: admin@lewaninterior.com
# Password: (your secure password)
```

## 📁 Step 6: Create Filament Resources

```bash
# Create Portfolio resource
php artisan make:filament-resource Portfolio --generate

# This creates:
# - app/Filament/Resources/PortfolioResource.php
# - app/Filament/Resources/PortfolioResource/Pages/
```

## 🌐 Step 7: Setup API Routes

```bash
# Install Laravel Sanctum (for API)
php artisan install:api
```

## 🚀 Step 8: Local Development

```bash
# Start Laravel server
php artisan serve

# Access admin panel
# http://localhost:8000/admin

# Login with credentials from Step 5
```

## ☁️ Step 9: Media Storage Setup

### Option A: Cloudinary
```bash
composer require cloudinary-labs/cloudinary-laravel

# Publish config
php artisan vendor:publish --provider="CloudinaryLabs\CloudinaryLaravel\CloudinaryServiceProvider" --tag="cloudinary-laravel-config"

# Update .env
CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
```

### Option B: Cloudflare R2
```bash
composer require league/flysystem-aws-s3-v3 "^3.0"

# Update .env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_r2_access_key
AWS_SECRET_ACCESS_KEY=your_r2_secret_key
AWS_DEFAULT_REGION=auto
AWS_BUCKET=your_bucket_name
AWS_ENDPOINT=https://your-account-id.r2.cloudflarestorage.com
AWS_URL=https://your-custom-domain.com
AWS_USE_PATH_STYLE_ENDPOINT=false
```

## 🚢 Step 10: Deploy to Railway

### Railway Setup:
1. Go to https://railway.app
2. Sign up with GitHub
3. Click "New Project" → "Deploy from GitHub repo"
4. Select your Laravel repo
5. Add PostgreSQL database (click "New" → "Database" → "PostgreSQL")

### Environment Variables (Railway):
```env
APP_NAME="Lewan CMS"
APP_ENV=production
APP_KEY=base64:... (generate with: php artisan key:generate --show)
APP_DEBUG=false
APP_URL=https://your-app.railway.app

DB_CONNECTION=pgsql
DB_HOST=${{PGHOST}}
DB_PORT=${{PGPORT}}
DB_DATABASE=${{PGDATABASE}}
DB_USERNAME=${{PGUSER}}
DB_PASSWORD=${{PGPASSWORD}}

# Cloudinary or R2 credentials
CLOUDINARY_CLOUD_NAME=...
CLOUDINARY_API_KEY=...
CLOUDINARY_API_SECRET=...
```

### Railway Deployment:
```bash
# Railway will auto-detect Laravel and run:
# - composer install
# - php artisan migrate --force
# - php artisan config:cache
```

## 🔗 Step 11: Connect Astro to Laravel API

Update your Astro site to fetch from Laravel API:

```typescript
// src/lib/api.ts
const API_URL = import.meta.env.PUBLIC_API_URL || 'https://your-app.railway.app/api';

export async function getPortfolioProjects() {
  const response = await fetch(`${API_URL}/portfolio`);
  return response.json();
}

export async function getPortfolioProject(slug: string) {
  const response = await fetch(`${API_URL}/portfolio/${slug}`);
  return response.json();
}
```

## 📊 What You'll Get

### Filament Admin Features:
- ✅ Beautiful, modern UI
- ✅ Drag & drop image reordering
- ✅ Image count display
- ✅ Bulk actions
- ✅ Search & filters
- ✅ Export data
- ✅ User management
- ✅ Activity logs
- ✅ Mobile responsive

### Custom Features You Can Add:
- Image optimization
- Video transcoding
- SEO fields
- Analytics
- Client portal
- Approval workflows
- Version history

## 💰 Cost Breakdown

| Service | Free Tier | Cost |
|---------|-----------|------|
| Railway | 500 hours/month + $5 credit | $0/month |
| PostgreSQL | Included with Railway | $0/month |
| Cloudinary | 25GB storage + bandwidth | $0/month |
| Domain | Use subdomain | $0/month |
| **Total** | | **$0/month** |

## 🎯 Next Steps

1. Follow steps 1-8 for local development
2. Test admin panel locally
3. Migrate your 14 portfolio projects
4. Deploy to Railway (step 10)
5. Update Astro to use API (step 11)
6. Deploy Astro to Netlify

## 📚 Resources

- Laravel Docs: https://laravel.com/docs
- Filament Docs: https://filamentphp.com/docs
- Railway Docs: https://docs.railway.app
- Spatie Media Library: https://spatie.be/docs/laravel-medialibrary

## ⏱️ Estimated Timeline

- Local setup: 2-3 hours
- Data migration: 1-2 hours
- Customization: 2-4 hours
- Deployment: 1 hour
- Testing: 1 hour
- **Total: 7-11 hours (1-2 days)**

---

Ready to start? Let me know when you want to begin with the detailed code implementation!
