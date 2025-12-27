# 🚀 Quick Reference Card

## Import Portfolio (3 Steps)

### 1. Import
```
Double-click: import-portfolio.bat
```

### 2. Verify
```
Double-click: verify-import.bat
```

### 3. View
```powershell
cd lewan-cms
php artisan serve
```
Visit: http://localhost:8000/admin

---

## Admin Panel

**URL:** http://localhost:8000/admin

**Login:**
- Email: info@lewaninterior.com
- Password: admin123

**Portfolios:** http://localhost:8000/admin/portfolios

---

## API Endpoints

**List All:**
```
GET http://localhost:8000/api/v1/portfolio
```

**Get Single:**
```
GET http://localhost:8000/api/v1/portfolio/{slug}
```

**Filter by Category:**
```
GET http://localhost:8000/api/v1/portfolio?category=bedroom
```

**Featured Only:**
```
GET http://localhost:8000/api/v1/portfolio?featured=true
```

---

## Useful Commands

### Start Server
```powershell
cd lewan-cms
php artisan serve
```

### Clear Cache
```powershell
cd lewan-cms
php artisan optimize:clear
```

### Create Admin User
```powershell
cd lewan-cms
php artisan make:filament-user
```

### Re-import Portfolio
```powershell
cd lewan-cms
php artisan db:seed --class=PortfolioSeeder
```

### Fresh Start (⚠️ Deletes ALL data)
```powershell
cd lewan-cms
php artisan migrate:fresh
php artisan db:seed --class=PortfolioSeeder
```

---

## File Structure

```
Project Root/
├── import-portfolio.bat          ← Double-click to import
├── verify-import.bat             ← Double-click to verify
├── START_HERE.md                 ← Read this first!
├── PORTFOLIO_IMPORT_GUIDE.md     ← Detailed guide
├── SETUP_COMPLETE_SUMMARY.md     ← Full CMS docs
│
├── public/                       ← Astro images (source)
│   ├── Reception/
│   ├── Dining Hall/
│   └── ... (14 folders)
│
└── lewan-cms/                    ← Laravel CMS
    ├── public/                   ← Laravel images (destination)
    ├── app/
    │   ├── Models/Portfolio.php
    │   ├── Filament/Resources/PortfolioResource.php
    │   └── Http/Controllers/Api/PortfolioController.php
    └── database/
        └── seeders/PortfolioSeeder.php
```

---

## Categories

- `bedroom` - 🛏️ Bedroom
- `living-room` - 🛋️ Living Room
- `dining` - 🍽️ Dining
- `kitchen` - 👨‍🍳 Kitchen
- `bathroom` - 🚿 Bathroom
- `entertainment` - 🎬 Entertainment
- `office` - 💼 Office
- `kids` - 🎮 Kids & Play
- `entrance` - 🚪 Entrance & Corridors
- `staircase` - 🪜 Staircase
- `other` - 🏠 Other

---

## Troubleshooting

### Images not showing?
```powershell
cd lewan-cms
php artisan storage:link
```

### Server won't start?
- Check if port 8000 is free
- Try: `php artisan serve --port=8001`

### Can't login?
- Email: info@lewaninterior.com
- Password: admin123
- Or create new: `php artisan make:filament-user`

### Import fails?
- Close Laravel server first
- Check images exist in `public/`
- See: `PORTFOLIO_IMPORT_GUIDE.md`

---

## What Gets Imported

| # | Project | Images |
|---|---------|--------|
| 1 | Reception | 26 |
| 2 | Deewaniya & Mughallath | 8 |
| 3 | Living Hall | 11 |
| 4 | Dining Hall | 30 |
| 5 | Master Bedrooms | 39 |
| 6 | Child Room | 12 |
| 7 | Wash & Bathroom | 43 |
| 8 | Dressing Room | 38 |
| 9 | Cinema Hall | 4 |
| 10 | Corridors | 26 |
| 11 | Kitchen, Pantry & Buffet | 26 |
| 12 | Office | 10 |
| 13 | PlayRoom | 4 |
| 14 | StairCase | 39 |

**Total: 14 projects, ~316 images**

---

## Documentation

- `START_HERE.md` - Quick start
- `IMPORT_READY.md` - Import overview
- `PORTFOLIO_IMPORT_GUIDE.md` - Detailed guide
- `SETUP_COMPLETE_SUMMARY.md` - Full docs
- `PORTFOLIO_MIGRATION_COMPLETE.md` - Migration info

---

## Ready?

**Import now:**
```
import-portfolio.bat
```

**Verify:**
```
verify-import.bat
```

**View:**
```
http://localhost:8000/admin
```

---

**That's it! 🎉**
