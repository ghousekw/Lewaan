# Custom Domain Setup Guide

## Domain Structure
- **Main Domain**: lewaninterior.com (Netlify - Frontend)
- **API Subdomain**: api.lewaninterior.com (Railway - Backend)

## Railway Backend Domain Setup

### Step 1: Add Custom Domain in Railway
1. Open Railway dashboard
2. Select your backend service
3. Go to **Settings** → **Networking**
4. Click **"Add Domain"**
5. Enter: `api.lewaninterior.com`
6. Copy the DNS records Railway provides

### Step 2: Configure DNS in GoDaddy

#### Login to GoDaddy
1. Go to https://dcc.godaddy.com/
2. Navigate to **My Products** → **DNS**
3. Click **Manage** next to your domain

#### Add CNAME Record
| Type  | Name | Value                          | TTL |
|-------|------|--------------------------------|-----|
| CNAME | api  | your-service.railway.app       | 600 |

**Important Notes:**
- Replace `your-service.railway.app` with the actual value Railway provides
- Don't include the full domain in "Name" - just use `api`
- If Railway provides an A record instead, use that

#### Example DNS Configuration
```
Type: CNAME
Name: api
Points to: backend-production-xxxx.railway.app
TTL: 600 seconds
```

### Step 3: Verify DNS Propagation

Check if DNS is working:
```bash
# Windows Command Prompt
nslookup api.lewaninterior.com

# Should return Railway's IP address
```

Or use online tools:
- https://dnschecker.org/
- https://www.whatsmydns.net/

### Step 4: Update Railway Environment Variables

Once domain is active, update in Railway:
```env
APP_URL=https://api.lewaninterior.com
```

### Step 5: Update Frontend Configuration

Update your Netlify environment variables:
```env
VITE_API_URL=https://api.lewaninterior.com
```

Then redeploy your frontend on Netlify.

### Step 6: Update CORS Configuration

Your backend CORS is already configured, but verify it includes your domain:

File: `backend/config/cors.php`
```php
'allowed_origins' => [
    'http://localhost:4321',
    'https://lewaninterior.com',
    'https://www.lewaninterior.com',
    'https://*.netlify.app',
],
```

## SSL Certificate

Railway automatically provisions and renews SSL certificates for custom domains.
- Certificate is issued via Let's Encrypt
- Automatic renewal every 90 days
- No configuration needed

## Testing Your Setup

### 1. Test Backend API
```bash
curl https://api.lewaninterior.com
```

### 2. Test Filament Admin
Visit: `https://api.lewaninterior.com/admin`

### 3. Test from Frontend
Open browser console on your frontend and check API calls are going to the custom domain.

## Troubleshooting

### DNS Not Resolving
- Wait 30 minutes for propagation
- Clear DNS cache: `ipconfig /flushdns` (Windows)
- Verify CNAME record is correct in GoDaddy

### SSL Certificate Error
- Wait for Railway to provision certificate (can take 10-15 minutes)
- Ensure DNS is fully propagated first
- Check Railway logs for certificate errors

### CORS Errors
- Verify frontend domain is in `config/cors.php`
- Check `APP_URL` is set correctly in Railway
- Clear browser cache

### 502 Bad Gateway
- Check Railway service is running
- Verify environment variables are set
- Check Railway logs for errors

## Alternative: Using Root Domain for Backend

If you want to use the root domain for backend instead:

**Not Recommended** because:
- You already have frontend on the root domain
- Would require complex routing setup
- Subdomain approach is cleaner and standard practice

## DNS Record Examples

### Current Setup (Recommended)
```
lewaninterior.com          → Netlify (Frontend)
www.lewaninterior.com      → Netlify (Frontend)
api.lewaninterior.com      → Railway (Backend)
```

### GoDaddy DNS Table
| Type  | Name | Value                          | TTL |
|-------|------|--------------------------------|-----|
| A     | @    | 75.2.60.5 (Netlify)           | 600 |
| CNAME | www  | apex-loadbalancer.netlify.com | 600 |
| CNAME | api  | backend-prod.railway.app      | 600 |

## Security Considerations

1. **Always use HTTPS** - Railway provides this automatically
2. **Keep APP_KEY secret** - Never commit to Git
3. **Set APP_DEBUG=false** in production
4. **Use environment variables** for sensitive data

## Cost

Custom domains on Railway:
- **Free** on all plans
- SSL certificates included
- No additional charges

## Support

- Railway Docs: https://docs.railway.app/deploy/custom-domains
- GoDaddy DNS Help: https://www.godaddy.com/help/manage-dns-680
