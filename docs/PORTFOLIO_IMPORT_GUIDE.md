# 📦 Portfolio Import Guide

This guide will help you import all 14 existing portfolio projects into your Laravel + Filament CMS.

## 🎯 What Will Be Imported

**14 Portfolio Projects:**
1. Reception (26 images)
2. Deewaniya & Mughallath (8 images)
3. Living Hall (11 images)
4. Dining Hall (30 images)
5. Master Bedrooms (39 images)
6. Child Room (12 images)
7. Wash & Bathroom (43 images)
8. Dressing Room (38 images)
9. Cinema Hall (4 images)
10. Corridors (26 images)
11. Kitchen, Pantry & Buffet (26 images)
12. Office (10 images)
13. PlayRoom (4 images)
14. StairCase (39 images)

**Total: ~316 images** with bilingual content (English & Arabic)

## 🚀 Quick Import (Automated)

Run this single command to import everything:

```powershell
.\import-portfolio.ps1
```

This script will:
1. ✅ Copy all portfolio images from Astro `public/` to Laravel `lewan-cms/public/`
2. ✅ Import all portfolio data into the database
3. ✅ Create thumbnails and gallery images
4. ✅ Set up categories and metadata

**Estimated time:** 2-5 minutes depending on your system

## 📋 Manual Import (Step by Step)

If you prefer to do it manually:

### Step 1: Copy Images

```powershell
# Copy each portfolio folder
Copy-Item -Path "public\Reception" -Destination "lewan-cms\public\Reception" -Recurse -Force
Copy-Item -Path "public\Deewaniya & Mughallath" -Destination "lewan-cms\public\Deewaniya & Mughallath" -Recurse -Force
Copy-Item -Path "public\Living Hall" -Destination "lewan-cms\public\Living Hall" -Recurse -Force
Copy-Item -Path "public\Dining Hall" -Destination "lewan-cms\public\Dining Hall" -Recurse -Force
Copy-Item -Path "public\Master Bedrooms" -Destination "lewan-cms\public\Master Bedrooms" -Recurse -Force
Copy-Item -Path "public\Child Room" -Destination "lewan-cms\public\Child Room" -Recurse -Force
Copy-Item -Path "public\Wash & Bathrooms" -Destination "lewan-cms\public\Wash & Bathrooms" -Recurse -Force
Copy-Item -Path "public\Dressing Room" -Destination "lewan-cms\public\Dressing Room" -Recurse -Force
Copy-Item -Path "public\Cinema Hall" -Destination "lewan-cms\public\Cinema Hall" -Recurse -Force
Copy-Item -Path "public\Corridors" -Destination "lewan-cms\public\Corridors" -Recurse -Force
Copy-Item -Path "public\Kitchen,Pantry & Buffet" -Destination "lewan-cms\public\Kitchen,Pantry & Buffet" -Recurse -Force
Copy-Item -Path "public\Office" -Destination "lewan-cms\public\Office" -Recurse -Force
Copy-Item -Path "public\Play Room" -Destination "lewan-cms\public\Play Room" -Recurse -Force
Copy-Item -Path "public\Staircase" -Destination "lewan-cms\public\Staircase" -Recurse -Force
```

### Step 2: Run Database Seeder

```powershell
cd lewan-cms
php artisan db:seed --class=PortfolioSeeder
```

## ✅ Verify Import

After import, verify everything worked:

### 1. Check Database

```powershell
cd lewan-cms
php artisan tinker
```

Then in tinker:
```php
Portfolio::count(); // Should return 14
Portfolio::first()->getMedia('gallery')->count(); // Check image count
```

### 2. Check Admin Panel

1. Start server: `php artisan serve`
2. Visit: http://localhost:8000/admin
3. Login: info@lewaninterior.com / admin123
4. Go to: http://localhost:8000/admin/portfolios
5. You should see all 14 projects with thumbnails

### 3. Check API

Visit: http://localhost:8000/api/v1/portfolio

You should see JSON response with all 14 projects.

## 🎨 What's Included in Each Project

Each imported project includes:

- ✅ **Slug** - URL-friendly identifier
- ✅ **Order** - Display order (1-14)
- ✅ **Status** - Published
- ✅ **Featured** - Reception, Master Bedrooms, and Dining Hall are featured
- ✅ **English Content** - Title and description
- ✅ **Arabic Content** - Title and description (العنوان والوصف)
- ✅ **Categories** - Bedroom, Living Room, Kitchen, etc.
- ✅ **Thumbnail** - Main preview image
- ✅ **Gallery** - All project images (drag & drop reorderable)

## 🔧 Troubleshooting

### Images Not Showing?

```powershell
cd lewan-cms
php artisan storage:link
php artisan optimize:clear
```

### Seeder Fails?

Check if images exist:
```powershell
Test-Path "lewan-cms\public\Reception"
```

If false, run the copy commands again.

### Database Already Has Data?

To start fresh:
```powershell
cd lewan-cms
php artisan migrate:fresh
php artisan db:seed --class=PortfolioSeeder
```

⚠️ **Warning:** This will delete ALL data including your admin user!

To recreate admin user:
```powershell
php artisan make:filament-user
```

### Some Images Missing?

The seeder will show warnings for missing images:
```
⚠ Warning: Image not found: /path/to/image.webp
```

Check if the image exists in the public folder and the path is correct.

## 📊 After Import

Once imported, you can:

1. **Edit Projects** - Update titles, descriptions, add more images
2. **Reorder Images** - Drag & drop in the gallery field
3. **Add Categories** - Assign multiple categories
4. **Add Tags** - For better searchability
5. **Set Featured** - Mark projects to show on homepage
6. **Add SEO** - Meta titles and descriptions
7. **Add Details** - Location, year, area, style

## 🌐 Connect to Astro Frontend

After import, update your Astro site to use the Laravel API:

### Update API Client

Create `src/lib/api.ts`:
```typescript
const API_URL = 'http://localhost:8000/api/v1';

export async function getPortfolioProjects() {
  const response = await fetch(`${API_URL}/portfolio`);
  return response.json();
}

export async function getPortfolioProject(slug: string) {
  const response = await fetch(`${API_URL}/portfolio/${slug}`);
  return response.json();
}
```

### Use in Pages

```astro
---
import { getPortfolioProjects } from '@/lib/api';
const { data: projects } = await getPortfolioProjects();
---

{projects.map(project => (
  <div>
    <img src={project.thumbnail_thumb} alt={project.en.title} />
    <h3>{project.en.title}</h3>
    <p>{project.en.description}</p>
    <span>{project.image_count} images</span>
  </div>
))}
```

## 🎉 Success!

Once imported, you'll have:
- ✅ 14 portfolio projects in database
- ✅ ~316 images in media library
- ✅ Bilingual content (EN/AR)
- ✅ Full admin panel control
- ✅ RESTful API for Astro
- ✅ Image thumbnails auto-generated

**Start managing your portfolio now!**

Visit: http://localhost:8000/admin/portfolios

---

**Need help?** Check the main setup guide: `SETUP_COMPLETE_SUMMARY.md`
