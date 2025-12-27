# Railway Session/Auth Fix

## Problem
Authentication works via CLI but fails in browser with "credentials do not match" error.

## Root Cause
Session cookies are not being properly configured for HTTPS in production.

## Solution

### Add These Environment Variables to Railway:

Go to Railway → Backend Service → Settings → Variables and add:

```env
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
SESSION_DOMAIN=api.lewaninterior.com
```

### Complete Environment Variables List

Make sure you have ALL of these in Railway:

```env
APP_NAME=Lewan CMS
APP_ENV=production
APP_KEY=base64:z/A07LuOD1zZj1RR52FrgmX5DWGTyO2to48W7+XMHQ0=
APP_DEBUG=false
APP_URL=https://api.lewaninterior.com

DB_CONNECTION=pgsql
DB_HOST=${{Postgres.PGHOST}}
DB_PORT=${{Postgres.PGPORT}}
DB_DATABASE=${{Postgres.PGDATABASE}}
DB_USERNAME=${{Postgres.PGUSER}}
DB_PASSWORD=${{Postgres.PGPASSWORD}}

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
SESSION_DOMAIN=api.lewaninterior.com

CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local

LOG_CHANNEL=stack
LOG_LEVEL=error

MAIL_MAILER=log
MAIL_FROM_ADDRESS=info@lewaninterior.com
MAIL_FROM_NAME=Lewan CMS
```

## After Adding Variables

1. Railway will automatically redeploy
2. Wait 2 minutes for deployment
3. Clear browser cookies or use incognito
4. Login with:
   - Email: `info@lewaninterior.com`
   - Password: `Lewan2025!`

## Why This Fixes It

- `SESSION_SECURE_COOKIE=true` - Ensures cookies only sent over HTTPS
- `SESSION_HTTP_ONLY=true` - Prevents JavaScript access (security)
- `SESSION_SAME_SITE=lax` - Allows cookies in same-site requests
- `SESSION_DOMAIN` - Explicitly sets cookie domain

Without these, Laravel's session cookies weren't being properly set/read in the browser, causing authentication to fail even though the credentials were correct.
