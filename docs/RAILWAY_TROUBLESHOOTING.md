# Railway Deployment Troubleshooting

## "Application failed to respond" Error

This error means your Laravel application isn't starting or responding to requests.

### Step 1: Check Deployment Logs

1. Go to Railway dashboard
2. Click your backend service
3. Go to **Deployments** tab
4. Click the latest deployment
5. Read through the logs

### Common Issues & Solutions

#### Issue 1: Missing Environment Variables ⚠️

**Symptoms:**
- Logs show: "No application encryption key has been specified"
- Or: "Database connection failed"

**Solution:**
Add these required variables in Railway Settings → Variables:

```env
APP_NAME=Lewan CMS
APP_ENV=production
APP_KEY=base64:z/A07LuOD1zZj1RR52FrgmX5DWGTyO2to48W7+XMHQ0=
APP_DEBUG=false
APP_URL=https://your-service.railway.app

# Database - Railway provides these automatically
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
```

#### Issue 2: Database Not Connected

**Symptoms:**
- Logs show: "SQLSTATE[08006] Connection refused"
- Or: "could not connect to server"

**Solution:**
1. Verify PostgreSQL service is running in Railway
2. Check database variables are set correctly
3. Ensure both services are in the same project
4. Railway auto-injects: `PGHOST`, `PGPORT`, `PGDATABASE`, `PGUSER`, `PGPASSWORD`

#### Issue 3: Migration Failures

**Symptoms:**
- Logs show: "Migration failed"
- Or: "SQLSTATE[42P01]: Undefined table"

**Solution:**
Migrations run automatically on startup. If they fail:
1. Check database connection is working
2. Verify `APP_KEY` is set
3. Check logs for specific migration errors

#### Issue 4: Port Configuration

**Symptoms:**
- App starts but Railway can't reach it
- Logs show server started but still get 502

**Solution:**
Verify start command uses Railway's PORT variable:
```bash
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
```

This is already configured in `backend/nixpacks.toml`.

#### Issue 5: PHP Version Mismatch

**Symptoms:**
- Logs show: "requires php >=8.4"
- Composer install fails

**Solution:**
Already fixed - using PHP 8.4 in `backend/nixpacks.toml`.

#### Issue 6: Storage Directory Permissions

**Symptoms:**
- Logs show: "The stream or file could not be opened"
- Permission denied errors

**Solution:**
Add to start command (already included):
```bash
php artisan storage:link
```

### Step 2: Verify Configuration Files

#### Check nixpacks.toml
File: `backend/nixpacks.toml`
```toml
[phases.setup]
nixPkgs = ['php84', 'php84Packages.composer', ...]

[start]
cmd = 'php artisan migrate --force && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}'
```

#### Check Root Directory
In Railway Settings → Source:
- Root Directory: `backend`

### Step 3: Manual Debugging

If logs aren't clear, try these commands in Railway's terminal:

1. Check PHP version:
```bash
php -v
```

2. Check environment variables:
```bash
env | grep DB_
env | grep APP_
```

3. Test database connection:
```bash
php artisan tinker
DB::connection()->getPdo();
```

4. Run migrations manually:
```bash
php artisan migrate --force
```

### Step 4: Common Log Messages

#### ✅ Success Logs (What you want to see):
```
Installing dependencies from lock file
✓ Composer install successful
✓ Config cached successfully
✓ Routes cached successfully
✓ Views cached successfully
✓ Migration completed
✓ Storage link created
Laravel development server started: http://0.0.0.0:8000
```

#### ❌ Error Logs (Problems):
```
"No application encryption key" → Missing APP_KEY
"Connection refused" → Database not connected
"composer install failed" → PHP version mismatch
"Migration failed" → Database connection or schema issue
"Port already in use" → Port configuration issue
```

### Step 5: Force Redeploy

Sometimes Railway needs a fresh deployment:

1. In Railway, go to your service
2. Click **Settings**
3. Scroll to bottom
4. Click **"Redeploy"**

Or trigger via Git:
```bash
git commit --allow-empty -m "Trigger Railway redeploy"
git push
```

### Step 6: Check Service Health

In Railway dashboard:
- **Deployments**: Should show "Active"
- **Metrics**: Should show CPU/Memory usage
- **Logs**: Should show server running

### Quick Checklist

- [ ] PostgreSQL database is running
- [ ] All environment variables are set
- [ ] `APP_KEY` is configured
- [ ] `APP_URL` matches your Railway domain
- [ ] Database variables use `${PGHOST}` syntax
- [ ] Root directory is set to `backend`
- [ ] Latest code is pushed to GitHub
- [ ] Deployment shows "Active" status

### Still Not Working?

1. **Share the logs** - Copy the full deployment logs
2. **Check Railway status** - https://status.railway.app
3. **Try Railway CLI** for more control:
```bash
npm i -g @railway/cli
railway login
railway logs
```

### Emergency: Start Fresh

If nothing works, redeploy from scratch:

1. Delete the current service (keep database)
2. Create new service from GitHub
3. Set root directory to `backend`
4. Add all environment variables
5. Link to existing database

### Contact Support

If issue persists:
- Railway Discord: https://discord.gg/railway
- Railway Help: https://help.railway.app
- Check Railway status page for outages
