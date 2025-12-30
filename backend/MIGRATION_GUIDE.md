# Migration Guide: Laravel → NestJS

## Why This Migration Solves Your Problems

### Before (Laravel + PHP)
- ❌ PostgreSQL driver issues on Railway
- ❌ PHP extension dependencies
- ❌ Build cache problems
- ❌ Metal build environment incompatibilities

### After (NestJS + Node.js)
- ✅ Zero driver issues - pure JavaScript
- ✅ No extensions needed
- ✅ Works on any platform
- ✅ Faster builds, reliable deployments

## Step-by-Step Migration

### 1. Local Setup (5 minutes)

```bash
cd backend-nestjs

# Install dependencies
npm install

# Copy environment file
cp .env.example .env
```

Edit `.env` with your credentials:
```env
DATABASE_URL="postgresql://postgres:areeb528@127.0.0.1:5432/lewan_cms?schema=public"
CLOUDINARY_CLOUD_NAME=daz1c9aum
CLOUDINARY_API_KEY=471497292313541
CLOUDINARY_API_SECRET=UVNSoT9ZqAdikEU4cb-XvDS6fxw
CORS_ORIGIN=http://localhost:3000
```

```bash
# Generate Prisma client
npm run prisma:generate

# Test locally
npm run start:dev
```

Visit `http://localhost:8000/api/v1/portfolio` - you should see your data!

### 2. Railway Deployment (10 minutes)

#### Option A: New Service (Recommended)

1. **Create new service** in Railway
   - Click "New" → "GitHub Repo"
   - Select your repository
   - Set root directory to `backend-nestjs`

2. **Add PostgreSQL** (if not already added)
   - Click "New" → "Database" → "PostgreSQL"
   - Railway will auto-generate connection variables

3. **Add environment variables**:
   ```
   DATABASE_URL=${{Postgres.DATABASE_URL}}
   CLOUDINARY_CLOUD_NAME=daz1c9aum
   CLOUDINARY_API_KEY=471497292313541
   CLOUDINARY_API_SECRET=UVNSoT9ZqAdikEU4cb-XvDS6fxw
   CORS_ORIGIN=https://lewaninterior.com
   NODE_ENV=production
   ```

4. **Deploy**
   - Railway will automatically build and deploy
   - No driver errors, no extension issues!

5. **Update your domain**
   - Go to Settings → Networking
   - Add custom domain: `api.lewaninterior.com`

#### Option B: Replace Existing Service

1. **In your existing backend service**:
   - Settings → Build → Change root directory to `backend-nestjs`
   - Settings → Build → Verify Dockerfile path is `Dockerfile`

2. **Update environment variables** (same as above)

3. **Redeploy** - Railway will use the new NestJS backend

### 3. Frontend Update (2 minutes)

Your frontend needs **zero changes**! The API endpoints and response format are identical:

- ✅ `GET /api/v1/portfolio` - Same response
- ✅ `GET /api/v1/portfolio/:slug` - Same response
- ✅ Same JSON structure
- ✅ Same query parameters

Just update your API base URL if it changed.

### 4. Database Migration

**Good news**: You don't need to migrate data! 

The NestJS backend uses the **same PostgreSQL database** as Laravel. Just point `DATABASE_URL` to your existing database and it works.

If you want a fresh start:

```bash
# Run migrations
npm run prisma:migrate

# Optional: Seed data (you'll need to create a seeder)
npm run prisma:studio  # Visual database editor
```

### 5. Verify Everything Works

Test these endpoints:

```bash
# Get all portfolios
curl https://api.lewaninterior.com/api/v1/portfolio

# Get featured portfolios
curl https://api.lewaninterior.com/api/v1/portfolio?featured=true

# Get single portfolio
curl https://api.lewaninterior.com/api/v1/portfolio/your-slug
```

## What's Different?

### File Structure
- Laravel: `app/Models`, `app/Http/Controllers`
- NestJS: `src/portfolio/portfolio.service.ts`, `src/portfolio/portfolio.controller.ts`

### Database Access
- Laravel: Eloquent ORM
- NestJS: Prisma ORM (more type-safe!)

### Configuration
- Laravel: `.env` + `config/` files
- NestJS: `.env` + `@nestjs/config`

## Rollback Plan

If something goes wrong:

1. Keep your old Laravel service running
2. Deploy NestJS to a new service
3. Test thoroughly
4. Switch DNS when ready
5. Delete old service

## Benefits You'll Notice

1. **Instant deployments** - No more waiting for PHP extensions
2. **Better error messages** - TypeScript catches issues early
3. **Faster builds** - Node.js builds in seconds
4. **More reliable** - Works on any platform
5. **Modern tooling** - Better IDE support, debugging

## Need Help?

- NestJS Docs: https://docs.nestjs.com
- Prisma Docs: https://www.prisma.io/docs
- Railway Docs: https://docs.railway.app

## Next Steps

After migration, you can add:
- Admin API endpoints (create, update, delete portfolios)
- Authentication (JWT, sessions)
- File upload endpoints
- More features without deployment headaches!
