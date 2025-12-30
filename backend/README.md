# Lewan CMS API - NestJS

Modern, reliable backend for Lewan Interior Design CMS built with NestJS, Prisma, and PostgreSQL.

## Features

- ✅ **Zero deployment issues** - No PHP extensions, no driver problems
- 🚀 **Fast & Reliable** - Built on Node.js with TypeScript
- 🗄️ **PostgreSQL** - Using Prisma ORM for type-safe database access
- 🖼️ **Cloudinary Integration** - Seamless media management
- 🌍 **Multilingual** - Full English/Arabic support
- 📦 **Docker Ready** - Single container, works everywhere

## Quick Start

### Local Development

1. **Install dependencies**
   ```bash
   npm install
   ```

2. **Setup environment**
   ```bash
   cp .env.example .env
   # Edit .env with your database and Cloudinary credentials
   ```

3. **Setup database**
   ```bash
   npm run prisma:generate
   npm run prisma:migrate
   ```

4. **Start development server**
   ```bash
   npm run start:dev
   ```

   Server runs at `http://localhost:8000`
   API available at `http://localhost:8000/api/v1`

### Railway Deployment

1. **Connect your repository** to Railway

2. **Add environment variables** in Railway dashboard:
   ```
   DATABASE_URL=${{Postgres.DATABASE_URL}}
   CLOUDINARY_CLOUD_NAME=your_cloud_name
   CLOUDINARY_API_KEY=your_api_key
   CLOUDINARY_API_SECRET=your_api_secret
   CORS_ORIGIN=https://your-frontend-domain.com
   ```

3. **Deploy** - Railway will automatically build and deploy

## API Endpoints

### Portfolio

- `GET /api/v1/portfolio` - Get all published portfolios
  - Query params: `?category=residential&featured=true`
  
- `GET /api/v1/portfolio/:slug` - Get single portfolio by slug

### Response Format

Same as Laravel API for seamless frontend integration:

```json
{
  "data": [...],
  "meta": {
    "total": 10
  }
}
```

## Migration from Laravel

Your existing PostgreSQL database works as-is! The Prisma schema matches your Laravel migrations.

### Data Migration (if needed)

If you want to migrate data from Laravel to this new backend:

1. Both use the same PostgreSQL database
2. Just point `DATABASE_URL` to your existing database
3. Run `npm run prisma:generate`
4. Done! Your data is accessible

## Project Structure

```
src/
├── main.ts              # Application entry point
├── app.module.ts        # Root module
├── prisma/              # Database service
│   ├── prisma.module.ts
│   └── prisma.service.ts
├── cloudinary/          # Media management
│   ├── cloudinary.module.ts
│   └── cloudinary.service.ts
└── portfolio/           # Portfolio feature
    ├── portfolio.module.ts
    ├── portfolio.controller.ts
    └── portfolio.service.ts
```

## Why NestJS?

- ✅ **No extension hell** - Pure JavaScript/TypeScript
- ✅ **Works everywhere** - Railway, Vercel, AWS, anywhere
- ✅ **Type-safe** - Catch errors before deployment
- ✅ **Modern** - Built for microservices and APIs
- ✅ **Scalable** - Easy to add features and modules

## Troubleshooting

### Database Connection Issues

Make sure your `DATABASE_URL` is correct:
```
postgresql://user:password@host:port/database?schema=public
```

### Cloudinary Not Working

Verify your credentials in `.env`:
- `CLOUDINARY_CLOUD_NAME`
- `CLOUDINARY_API_KEY`
- `CLOUDINARY_API_SECRET`

## Support

For issues or questions, check the NestJS documentation: https://docs.nestjs.com
