# Project Structure

This repository contains both the frontend and backend for Lewan Interior Design website.

## Directory Structure

```
/
├── backend/          # Laravel 12 + Filament 4 CMS
│   ├── app/         # Application code (Models, Controllers, Resources)
│   ├── database/    # Migrations, seeders, factories
│   ├── public/      # Public assets and uploaded images
│   └── ...          # Standard Laravel structure
│
├── frontend/        # Astro static site
│   ├── src/        # Astro components, pages, layouts
│   ├── public/     # Static assets
│   └── ...         # Astro configuration files
│
├── docs/           # Project documentation
│   ├── START_HERE.md
│   ├── PORTFOLIO_IMPORT_GUIDE.md
│   └── ...         # Setup guides and references
│
└── scripts/        # Utility scripts
    ├── import-portfolio.ps1
    ├── verify-import.ps1
    └── ...         # Setup and maintenance scripts
```

## Quick Start

### Backend (Laravel CMS)
```bash
cd backend
php artisan serve
# Access admin panel at: http://localhost:8000/admin
# Credentials: info@lewaninterior.com / admin123
```

### Frontend (Astro)
```bash
cd frontend
npm run dev
# Access site at: http://localhost:4321
```

## API Integration

The backend provides REST API endpoints at `/api/v1/portfolio` that the frontend consumes to display portfolio projects.

## Documentation

See the `docs/` folder for detailed setup guides:
- `docs/START_HERE.md` - Complete setup guide
- `docs/PORTFOLIO_IMPORT_GUIDE.md` - Portfolio management
- `docs/LARAVEL_FILAMENT_SETUP.md` - Backend configuration
