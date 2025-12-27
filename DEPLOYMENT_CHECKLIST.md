# Railway Deployment Checklist

## ✅ Pre-Deployment (Completed)
- [x] Railway configuration files created
- [x] CORS configured for Netlify
- [x] PostgreSQL database configuration ready
- [x] Deployment guide created

## 🚀 Railway Setup (Do This Now)

### 1. Create Railway Project
1. Go to https://railway.app/dashboard
2. Click **"New Project"**
3. Select **"Deploy from GitHub repo"**
4. Choose your repository
5. **Important**: Set root directory to `backend`

### 2. Add PostgreSQL Database
1. In your Railway project, click **"New"**
2. Select **"Database"** → **"PostgreSQL"**
3. Wait for database to provision (1-2 minutes)

### 3. Configure Environment Variables
In Railway service settings → Variables, add:

```env
APP_NAME=Lewan CMS
APP_ENV=production
APP_KEY=base64:z/A07LuOD1zZj1RR52FrgmX5DWGTyO2to48W7+XMHQ0=
APP_DEBUG=false
APP_URL=https://your-backend.railway.app

DB_CONNECTION=pgsql
DB_HOST=${PGHOST}
DB_PORT=${PGPORT}
DB_DATABASE=${PGDATABASE}
DB_USERNAME=${PGUSER}
DB_PASSWORD=${PGPASSWORD}

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local

LOG_CHANNEL=stack
LOG_LEVEL=error

MAIL_MAILER=log
MAIL_FROM_ADDRESS=hello@lewaninterior.com
MAIL_FROM_NAME=Lewan CMS
```

**Note**: Railway automatically provides `PGHOST`, `PGPORT`, `PGDATABASE`, `PGUSER`, `PGPASSWORD` when you add PostgreSQL.

### 4. Generate Domain
1. Go to service **Settings** → **Networking**
2. Click **"Generate Domain"**
3. Copy the URL (e.g., `https://backend-production-xxxx.railway.app`)
4. Update `APP_URL` variable with this URL

### 5. Deploy
Railway will automatically deploy. Monitor in the **Deployments** tab.

## 📝 Post-Deployment

### 1. Verify Backend is Running
- Visit: `https://your-backend.railway.app`
- Should see Laravel welcome or API response

### 2. Access Filament Admin
- Visit: `https://your-backend.railway.app/admin`
- Login with your admin credentials

### 3. Update Frontend
Update your Netlify frontend environment variables:
```
VITE_API_URL=https://your-backend.railway.app
```
Redeploy frontend on Netlify.

### 4. Test API Connection
- Test API endpoints from frontend
- Verify data is loading correctly

## 🔧 Optional Enhancements

### Add Custom Domain (Optional)
1. In Railway Settings → Networking
2. Add custom domain (e.g., `api.lewaninterior.com`)
3. Update DNS records as instructed

### Set Up Storage (For File Uploads)
**Option A: Railway Volume**
1. Add Volume in Railway
2. Mount to `/app/storage/app/public`

**Option B: Cloudinary (Recommended)**
1. Sign up at cloudinary.com (free 25GB)
2. Add Cloudinary credentials to Railway env
3. Update Laravel filesystem config

## 📊 Monitor Usage
- Check Railway dashboard for resource usage
- Monitor costs (should stay within $5 credit for small traffic)
- View logs for errors

## 🆘 Troubleshooting

**Deployment Failed?**
- Check logs in Railway dashboard
- Verify all environment variables are set
- Ensure `backend` is set as root directory

**Database Connection Error?**
- Verify PostgreSQL service is running
- Check database variables are correctly referenced
- Ensure `DB_CONNECTION=pgsql`

**500 Error?**
- Check `APP_KEY` is set
- Verify `APP_DEBUG=false`
- Check logs for specific error

**CORS Error from Frontend?**
- Verify frontend URL is in `config/cors.php`
- Check `APP_URL` is set correctly

## 📚 Resources
- Full guide: `docs/RAILWAY_DEPLOYMENT.md`
- Railway docs: https://docs.railway.app
- Laravel deployment: https://laravel.com/docs/deployment

---

**Current Status**: Ready to deploy! Follow steps above.
