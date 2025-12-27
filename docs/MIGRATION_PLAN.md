# 🚀 Migration Plan: Decap CMS → Laravel + Filament

## 📋 What You Have Now

✅ Complete Laravel + Filament code structure
✅ Portfolio resource with all features
✅ API endpoints for Astro integration
✅ Database migrations
✅ Media library setup
✅ CORS configuration

## 🎯 Quick Start Guide

### 1. Create Laravel Project (5 minutes)

```bash
# Create project
composer create-project laravel/laravel lewan-cms
cd lewan-cms

# Copy the files I created into your project:
# - app/Models/Portfolio.php
# - app/Filament/Resources/PortfolioResource.php
# - app/Http/Controllers/Api/PortfolioController.php
# - database/migrations/create_portfolios_table.php
# - routes/api.php
# - config/cors.php
# - .env.example

# Install Filament
composer require filament/filament:"^3.2" -W
php artisan filament:install --panels

# Install Media Library
composer require "spatie/laravel-medialibrary:^11.0.0"
composer require filament/spatie-laravel-media-library-plugin:"^3.2" -W

# Publish migrations
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"

# Run migrations
php artisan migrate

# Create admin user
php artisan make:filament-user
```

### 2. Configure Database (2 minutes)

**Option A: SQLite (Quick Testing)**
```env
DB_CONNECTION=sqlite
```

**Option B: PostgreSQL (Production)**
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=lewan_cms
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

### 3. Start Development Server (1 minute)

```bash
php artisan serve

# Access admin panel:
# http://localhost:8000/admin
```

## 🎨 What You'll See in Filament Admin

### Dashboard Features:
- ✅ **Beautiful UI** - Modern, clean interface
- ✅ **Portfolio List** - Shows thumbnail, title, order, image count, status
- ✅ **Drag & Drop** - Reorder projects by dragging
- ✅ **Image Count Badge** - Shows number of images per project
- ✅ **Filters** - Filter by status, featured, categories
- ✅ **Search** - Search by title
- ✅ **Bulk Actions** - Delete multiple projects at once

### Edit Form Features:
- ✅ **Organized Sections** - Basic Info, English, Arabic, Media, SEO
- ✅ **Image Upload** - Drag & drop with preview
- ✅ **Gallery Management** - Reorder images by dragging
- ✅ **Rich Text Editor** - For full descriptions
- ✅ **Category Selection** - Multi-select with emojis
- ✅ **Status Control** - Published/Draft/Private
- ✅ **Featured Toggle** - Mark special projects
- ✅ **SEO Fields** - Meta titles and descriptions

## 📊 Data Migration Script

Create a migration script to import your existing portfolio data:

```bash
php artisan make:command ImportPortfolio
```

```php
<?php
// app/Console/Commands/ImportPortfolio.php

namespace App\Console\Commands;

use App\Models\Portfolio;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportPortfolio extends Command
{
    protected $signature = 'portfolio:import';
    protected $description = 'Import portfolio from JSON files';

    public function handle()
    {
        $files = File::files(base_path('../src/content/portfolio'));
        
        foreach ($files as $file) {
            $data = json_decode(File::get($file), true);
            
            $portfolio = Portfolio::create([
                'slug' => $data['slug'],
                'order' => $data['order'],
                'title_en' => $data['en']['title'],
                'description_en' => $data['en']['description'],
                'title_ar' => $data['ar']['title'],
                'description_ar' => $data['ar']['description'],
                'status' => 'published',
            ]);
            
            // Add thumbnail
            if (isset($data['thumbnail'])) {
                $thumbnailPath = public_path($data['thumbnail']);
                if (file_exists($thumbnailPath)) {
                    $portfolio->addMedia($thumbnailPath)
                        ->toMediaCollection('thumbnail');
                }
            }
            
            // Add gallery images
            foreach ($data['gallery'] as $image) {
                $imagePath = public_path($image['src']);
                if (file_exists($imagePath)) {
                    $media = $portfolio->addMedia($imagePath)
                        ->toMediaCollection('gallery');
                    
                    $media->setCustomProperty('alt_en', $image['alt']['en']);
                    $media->setCustomProperty('alt_ar', $image['alt']['ar']);
                    $media->save();
                }
            }
            
            $this->info("Imported: {$data['en']['title']}");
        }
        
        $this->info('Import completed!');
    }
}
```

Run import:
```bash
php artisan portfolio:import
```

## 🌐 Update Astro to Use Laravel API

### 1. Create API Client

```typescript
// src/lib/api.ts
const API_URL = import.meta.env.PUBLIC_API_URL || 'http://localhost:8000/api/v1';

export interface Portfolio {
  slug: string;
  order: number;
  featured: boolean;
  thumbnail: string;
  thumbnail_thumb: string;
  en: {
    title: string;
    description: string;
    full_description?: string;
    details?: any;
  };
  ar: {
    title: string;
    description: string;
    full_description?: string;
    details?: any;
  };
  categories?: string[];
  tags?: string[];
  image_count: number;
  gallery?: Array<{
    type: string;
    src: string;
    thumb: string;
    alt: { en: string; ar: string };
  }>;
}

export async function getPortfolioProjects(): Promise<Portfolio[]> {
  const response = await fetch(`${API_URL}/portfolio`);
  const data = await response.json();
  return data.data;
}

export async function getPortfolioProject(slug: string): Promise<Portfolio> {
  const response = await fetch(`${API_URL}/portfolio/${slug}`);
  const data = await response.json();
  return data.data;
}

export async function getFeaturedProjects(): Promise<Portfolio[]> {
  const response = await fetch(`${API_URL}/portfolio?featured=true`);
  const data = await response.json();
  return data.data;
}
```

### 2. Update Astro Pages

```astro
---
// src/pages/portfolio/index.astro
import { getPortfolioProjects } from '@/lib/api';

const projects = await getPortfolioProjects();
---

<div class="portfolio-grid">
  {projects.map(project => (
    <a href={`/portfolio/${project.slug}`}>
      <img src={project.thumbnail_thumb} alt={project.en.title} />
      <h3>{project.en.title}</h3>
      <p>{project.image_count} images</p>
    </a>
  ))}
</div>
```

### 3. Add Environment Variable

```env
# .env
PUBLIC_API_URL=https://your-app.railway.app/api/v1
```

## 🚢 Deploy to Railway

### 1. Push to GitHub

```bash
cd lewan-cms
git init
git add .
git commit -m "Initial Laravel + Filament setup"
git remote add origin https://github.com/yourusername/lewan-cms.git
git push -u origin main
```

### 2. Deploy on Railway

1. Go to https://railway.app
2. Sign up with GitHub
3. Click "New Project" → "Deploy from GitHub repo"
4. Select `lewan-cms` repo
5. Add PostgreSQL database:
   - Click "New" → "Database" → "PostgreSQL"
6. Add environment variables (from .env.example)
7. Railway will auto-deploy!

### 3. Run Migrations on Railway

```bash
# Railway will automatically run:
php artisan migrate --force
```

### 4. Create Admin User on Railway

```bash
# In Railway dashboard, go to your app
# Click "Settings" → "Deploy" → "Custom Start Command"
# Or use Railway CLI:
railway run php artisan make:filament-user
```

## 💰 Cost Summary

| Service | Usage | Cost |
|---------|-------|------|
| Railway | 500 hours/month + $5 credit | $0/month |
| PostgreSQL | Included with Railway | $0/month |
| Cloudinary | 25GB storage + bandwidth | $0/month |
| Netlify | Astro site hosting | $0/month |
| **Total** | | **$0/month** |

## ⏱️ Timeline

- ✅ Setup Laravel locally: **30 minutes**
- ✅ Import existing data: **1 hour**
- ✅ Test admin panel: **30 minutes**
- ✅ Update Astro API calls: **1 hour**
- ✅ Deploy to Railway: **30 minutes**
- ✅ Test production: **30 minutes**
- **Total: 4-5 hours**

## 🎯 Next Steps

1. **Today**: Set up Laravel locally and test admin panel
2. **Tomorrow**: Import your 14 portfolio projects
3. **Day 3**: Update Astro to use API and deploy

## 📚 Resources

- **Filament Docs**: https://filamentphp.com/docs
- **Laravel Docs**: https://laravel.com/docs
- **Railway Docs**: https://docs.railway.app
- **Spatie Media Library**: https://spatie.be/docs/laravel-medialibrary

## 🆘 Need Help?

If you get stuck:
1. Check the setup guide: `LARAVEL_FILAMENT_SETUP.md`
2. Review the code files in `laravel-cms/` folder
3. Ask me for help with specific errors

---

**Ready to start?** Begin with Step 1 and let me know if you need any clarification!
