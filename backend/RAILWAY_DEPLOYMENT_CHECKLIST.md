# Railway Deployment Checklist - NestJS Backend

## Environment Variables Required

In Railway → Your Service → Variables, add:

```env
# Database (Reference your PostgreSQL service)
DATABASE_URL=${{Postgres.DATABASE_URL}}

# Cloudinary
CLOUDINARY_CLOUD_NAME=daz1c9aum
CLOUDINARY_API_KEY=471497292313541
CLOUDINARY_API_SECRET=UVNSoT9ZqAdikEU4cb-XvDS6fxw

# CORS (Update with your frontend URL)
CORS_ORIGIN=https://lewaninterior.com

# Node Environment
NODE_ENV=production
PORT=8000
```

## Build Settings

In Railway → Settings → Build:

- **Root Directory**: `backend`
- **Builder**: Dockerfile
- **Dockerfile Path**: `Dockerfile`

## Deployment Process

1. **Push to GitHub** - Railway auto-deploys
2. **Check Build Logs** - Watch for errors
3. **Check Deploy Logs** - Verify migrations run successfully
4. **Test API** - Visit your Railway URL + `/api/v1/portfolio`

## Common Issues & Solutions

### Issue: "Connection url is empty"
**Solution**: Make sure `DATABASE_URL` is set in Railway variables

### Issue: "Prisma generate fails"
**Solution**: The Dockerfile now uses a fallback dummy URL for build-time generation. Real URL is used at runtime.

### Issue: "Migrations fail"
**Solution**: Check that your PostgreSQL service is running and DATABASE_URL is correctly referencing it

### Issue: "Port binding error"
**Solution**: Railway automatically sets PORT variable. The app uses `process.env.PORT || 8000`

## Verify Deployment

Test these endpoints after deployment:

```bash
# Health check
curl https://your-app.railway.app/

# Get portfolios
curl https://your-app.railway.app/api/v1/portfolio

# Get featured
curl https://your-app.railway.app/api/v1/portfolio?featured=true
```

## Monitoring

- **Logs**: Railway → Your Service → Deployments → View Logs
- **Metrics**: Railway → Your Service → Metrics
- **Database**: Railway → PostgreSQL Service → Data tab

## Rollback

If deployment fails:
1. Go to Deployments tab
2. Find last working deployment
3. Click "Redeploy"
