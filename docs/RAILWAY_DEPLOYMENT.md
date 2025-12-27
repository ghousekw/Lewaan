# Railway Deployment Guide

## Prerequisites
- Railway account with Hobby plan ($5/month)
- GitHub repository connected
- Frontend already deployed on Netlify

## Step 1: Create New Project on Railway

1. Go to https://railway.app/dashboard
2. Click "New Project"
3. Select "Deploy from GitHub repo"
4. Choose your repository
5. Select the `backend` folder as the root directory

## Step 2: Add PostgreSQL Database

1. In your Railway project, click "New"
2. Select "Database" → "PostgreSQL"
3. Railway will automatically create a database
4. Note: Database credentials are auto-generated

## Step 3: Configure Environment Variables

In Railway project settings, add these environment variables:

### Required Variables
```
APP_NAME=Lewan CMS
APP_ENV=production
APP_KEY=base64:z/A07LuOD1zZj1RR52FrgmX5DWGTyO2to48W7+XMHQ0=
APP_DEBUG=false
APP_URL=https://your-backend-url.railway.app

# Database (Railway auto-provides these as DATABASE_URL)
# Railway will inject: DATABASE_URL, PGHOST, PGPORT, PGDATABASE, PGUSER, PGPASSWORD
DB_CONNECTION=pgsql
DB_HOST=${PGHOST}
DB_PORT=${PGPORT}
DB_DATABASE=${PGDATABASE}
DB_USERNAME=${PGUSER}
DB_PASSWORD=${PGPASSWORD}

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Filesystem
FILESYSTEM_DISK=local

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error

# Mail (configure later if needed)
MAIL_MAILER=log
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Important Notes:
- Railway automatically provides `DATABASE_URL` and PostgreSQL variables
- Use `${PGHOST}` syntax to reference Railway's database variables
- Set `APP_DEBUG=false` for production
- Update `APP_URL` with your Railway domain

## Step 4: Configure CORS for Frontend

You'll need to allow your Netlify frontend to access the backend.

Update `config/cors.php` (we'll do this next) to allow your Netlify domain.

## Step 5: Deploy

1. Railway will automatically deploy when you push to GitHub
2. First deployment will:
   - Install PHP dependencies
   - Run migrations
   - Cache configuration
   - Start the server

## Step 6: Get Your Backend URL

1. In Railway project, click on your service
2. Go to "Settings" → "Domains"
3. Click "Generate Domain"
4. Copy the URL (e.g., `https://your-app.railway.app`)

## Step 7: Update Frontend Configuration

Update your Netlify frontend to use the Railway backend URL:
- Update API endpoint in frontend environment variables
- Redeploy frontend

## Step 8: Test Your Deployment

1. Visit your Railway URL
2. Test API endpoints
3. Access Filament admin at: `https://your-app.railway.app/admin`

## Monitoring & Logs

- View logs in Railway dashboard
- Monitor resource usage
- Check deployment status

## Storage Configuration (Optional)

For file uploads, consider:
1. **Railway Volumes** - For persistent storage (5GB included)
2. **Cloudinary** - For images/media (25GB free)

### Using Railway Volumes:
1. In Railway, add a Volume to your service
2. Mount path: `/app/storage/app/public`
3. Update `FILESYSTEM_DISK=public` in env

## Troubleshooting

### Database Connection Issues
- Verify Railway database is running
- Check environment variables are set correctly
- Ensure `DB_CONNECTION=pgsql`

### Migration Errors
- Check logs in Railway dashboard
- Verify database credentials
- Run migrations manually: `php artisan migrate --force`

### 500 Errors
- Check `APP_KEY` is set
- Verify `APP_DEBUG=false` for production
- Check logs for specific errors

## Cost Estimate

With Hobby plan ($5/month):
- Backend service: ~$2-5/month
- PostgreSQL database: ~$1-3/month
- Total: Within $5 credit (for small traffic)

## Next Steps

1. Set up Cloudinary for media storage
2. Configure custom domain (optional)
3. Set up automated backups
4. Configure email service (if needed)
