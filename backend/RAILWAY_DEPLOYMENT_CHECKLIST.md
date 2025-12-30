# Railway Deployment Checklist - NestJS Backend

## ⚠️ CRITICAL: Environment Variables Required

**The deployment will fail if DATABASE_URL is not set!**

In Railway → Your Service → Variables tab, you MUST add:

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

### How to Link PostgreSQL Database:

1. **If you already have a PostgreSQL service:**
   - In your backend service, go to Variables
   - Click "New Variable" → "Add Reference"
   - Select your PostgreSQL service
   - Choose `DATABASE_URL`
   - This will create: `DATABASE_URL=${{Postgres.DATABASE_URL}}`

2. **If you don't have PostgreSQL yet:**
   - In your Railway project, click "New"
   - Select "Database" → "PostgreSQL"
   - Railway will create a new database
   - Then follow step 1 above to link it

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

### Issue: "Can't reach database server at dummy:5432"
**Cause**: DATABASE_URL environment variable is not set in Railway
**Solution**: 
1. Go to Railway → Your Service → Variables
2. Add `DATABASE_URL=${{Postgres.DATABASE_URL}}`
3. Make sure your PostgreSQL service is running
4. Redeploy

### Issue: "Connection url is empty"
**Solution**: Make sure `DATABASE_URL` is set in Railway variables (see above)

### Issue: "Prisma generate fails"
**Solution**: The Dockerfile uses a dummy URL for build-time generation. This is normal and expected.

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

## Still Having Issues?

Check the deployment logs for this specific error message:
```
❌ ERROR: DATABASE_URL environment variable is not set!
```

If you see this, it means Railway isn't providing the DATABASE_URL. Double-check:
- [ ] PostgreSQL service exists in your project
- [ ] PostgreSQL service is running (green status)
- [ ] DATABASE_URL variable is added to your backend service
- [ ] DATABASE_URL references the PostgreSQL service: `${{Postgres.DATABASE_URL}}`
