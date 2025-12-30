# Lewan Interior Design - CMS

Full-stack interior design portfolio and CMS application.

## Project Structure

```
├── backend/           # NestJS API backend (Node.js + PostgreSQL + Prisma)
├── frontend/          # Next.js frontend application
├── docs/              # Project documentation
└── scripts/           # Utility scripts
```

## Backend (NestJS)

Modern, reliable API built with NestJS, TypeScript, and PostgreSQL.

**Features:**
- ✅ Portfolio API with multilingual support (EN/AR)
- ✅ PostgreSQL database with Prisma ORM
- ✅ Cloudinary media management
- ✅ Docker ready for easy deployment
- ✅ Zero deployment issues - works everywhere

**Quick Start:**
```bash
cd backend
npm install
npm run start:dev
```

See [backend/README.md](backend/README.md) for full documentation.

## Frontend

Next.js application for the public-facing website.

```bash
cd frontend
npm install
npm run dev
```

## Deployment

### Railway (Recommended)

1. Connect your GitHub repository to Railway
2. Set root directory to `backend`
3. Add environment variables (see backend/.env.example)
4. Deploy!

See [backend/MIGRATION_GUIDE.md](backend/MIGRATION_GUIDE.md) for detailed deployment instructions.

## API Endpoints

- `GET /api/v1/portfolio` - List all portfolios
- `GET /api/v1/portfolio/:slug` - Get single portfolio
- Query params: `?category=bedroom&featured=true`

## Tech Stack

**Backend:**
- NestJS (Node.js framework)
- TypeScript
- PostgreSQL
- Prisma ORM
- Cloudinary

**Frontend:**
- Next.js
- React
- TypeScript

## License

Private - All rights reserved
