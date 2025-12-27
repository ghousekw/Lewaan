# 🎯 START HERE - Portfolio Import Guide

Welcome! This guide will help you import your 14 existing portfolio projects into the new Laravel + Filament CMS.

## 📦 What You Have

- ✅ Laravel 12 + Filament 4 CMS (fully configured)
- ✅ PostgreSQL database (lewan_cms)
- ✅ Portfolio management system
- ✅ 14 existing projects with ~316 images
- ✅ Bilingual content (English & Arabic)
- ✅ RESTful API for Astro frontend

## 🚀 Quick Import (3 Steps)

### Step 1: Run Import Script

**Double-click this file:**
```
import-portfolio.bat
```

Or run in PowerShell:
```powershell
.\import-portfolio.ps1
```

This will:
- Copy all images from `public/` to `lewan-cms/public/`
- Import all 14 projects into database
- Create thumbnails automatically

**Time:** 2-5 minutes

### Step 2: Verify Import

**Double-click this file:**
```
verify-import.bat
```

This will show you:
- How many projects were imported
- Image count for each project
- Any issues or warnings

### Step 3: View in Admin Panel

Start the Laravel server:
```powershell
cd lewan-cms
php artisan serve
```

Then visit:
- **Admin Panel:** http://localhost:8000/admin
- **Login:** info@lewaninterior.com / admin123
- **Portfolios:** http://localhost:8000/admin/portfolios

## 📋 What Gets Imported

| Project | Images | Category |
|---------|--------|----------|
| Reception | 26 | Entrance |
| Deewaniya & Mughallath | 8 | Living Room |
| Living Hall | 11 | Living Room |
| Dining Hall | 30 | Dining |
| Master Bedrooms | 39 | Bedroom |
| Child Room | 12 | Kids |
| Wash & Bathroom | 43 | Bathroom |
| Dressing Room | 38 | Bedroom |
| Cinema Hall | 4 | Entertainment |
| Corridors | 26 | Entrance |
| Kitchen, Pantry & Buffet | 26 | Kitchen |
| Office | 10 | Office |
| PlayRoom | 4 | Kids |
| StairCase | 39 | Staircase |

**Total: 14 projects, ~316 images**

## ✨ Features You'll Get

### In Admin Panel:
- ✅ Create/Edit/Delete projects
- ✅ Drag & drop image upload
- ✅ Reorder images (drag & drop)
- ✅ Bilingual content (EN/AR)
- ✅ Categories & tags
- ✅ Featured projects
- ✅ Status control (Published/Draft/Private)
- ✅ SEO fields
- ✅ Search & filters
- ✅ Image count display

### API Endpoints:
- `GET /api/v1/portfolio` - List all projects
- `GET /api/v1/portfolio/{slug}` - Get single project

## 🎨 After Import

Once imported, you can:

### 1. Edit Projects
- Update titles and descriptions
- Add more images
- Change categories
- Set featured status
- Add SEO metadata

### 2. Manage Images
- Drag & drop to reorder
- Delete unwanted images
- Upload new images
- Auto-generate thumbnails

### 3. Connect Astro Frontend
Update your Astro site to fetch from Laravel API instead of JSON files.

See: `SETUP_COMPLETE_SUMMARY.md` for API integration guide.

## 📚 Documentation Files

- **IMPORT_READY.md** - Quick import overview
- **PORTFOLIO_IMPORT_GUIDE.md** - Detailed import instructions
- **SETUP_COMPLETE_SUMMARY.md** - Full CMS setup documentation
- **LARAVEL_FILAMENT_SETUP.md** - Technical setup details

## 🔧 Troubleshooting

### Import Script Fails?

1. Make sure Laravel server is NOT running
2. Check if images exist in `public/` folder
3. Run manually: See `PORTFOLIO_IMPORT_GUIDE.md`

### Images Not Showing?

```powershell
cd lewan-cms
php artisan storage:link
php artisan optimize:clear
```

### Can't Login to Admin?

Default credentials:
- Email: info@lewaninterior.com
- Password: admin123

Create new admin:
```powershell
cd lewan-cms
php artisan make:filament-user
```

### Database Issues?

Start fresh (⚠️ deletes all data):
```powershell
cd lewan-cms
php artisan migrate:fresh
php artisan db:seed --class=PortfolioSeeder
```

## 🎯 Ready to Start?

### Option A: Automated Import (Recommended)
```
1. Double-click: import-portfolio.bat
2. Wait 2-5 minutes
3. Double-click: verify-import.bat
4. Start server and view in admin panel
```

### Option B: Manual Import
See detailed guide: `PORTFOLIO_IMPORT_GUIDE.md`

## 🌐 Next Steps After Import

1. **Test Admin Panel** - Create/edit a test project
2. **Test API** - Visit http://localhost:8000/api/v1/portfolio
3. **Update Astro** - Connect frontend to Laravel API
4. **Deploy** - When ready, deploy Laravel to production

## 📞 Need Help?

Check these files:
- `PORTFOLIO_IMPORT_GUIDE.md` - Import troubleshooting
- `SETUP_COMPLETE_SUMMARY.md` - CMS documentation
- `TROUBLESHOOT_SERVER.md` - Server issues

## 🎉 Let's Go!

**Run the import now:**

```
import-portfolio.bat
```

Then verify:

```
verify-import.bat
```

---

**Good luck! Your portfolio CMS is ready to use! 🚀**
