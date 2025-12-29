# Railway Build Cache Management

## Problem
Railway may use cached Docker layers during builds, which can cause issues if:
- PHP extensions aren't properly installed
- Dependencies are outdated
- Configuration changes aren't applied

## Solutions

### 1. Force Fresh Build via Railway Dashboard

**Method 1: Redeploy**
1. Go to Railway Dashboard
2. Select your service
3. Click **Settings** → Scroll to bottom
4. Click **"Redeploy"** button
5. Check **"Clear build cache"** checkbox (if available)

**Method 2: Empty Commit**
```bash
git commit --allow-empty -m "Force rebuild - clear cache"
git push
```

### 2. Force Fresh Build via Railway CLI

```bash
# Navigate to backend directory
cd backend

# Force redeploy without cache
railway up --detach

# Or trigger a new deployment
railway redeploy
```

### 3. Update Cache-Busting Value in Dockerfile

The Dockerfile includes a `CACHE_BUST` argument. To force a rebuild:

1. Edit `backend/Dockerfile`
2. Change the `CACHE_BUST` value:
   ```dockerfile
   ARG CACHE_BUST=2  # Change from 1 to 2, 3, etc.
   ```
3. Commit and push:
   ```bash
   git add backend/Dockerfile
   git commit -m "Force rebuild: update cache-bust value"
   git push
   ```

### 4. Use Build Arguments (Recommended)

Railway supports build arguments. You can set them in Railway Dashboard:

1. Go to Railway Dashboard → Your Service → Variables
2. Add a new variable:
   - **Name**: `CACHE_BUST`
   - **Value**: `$(date +%s)` or any changing value
3. Railway will pass this as a build argument

Or via CLI:
```bash
railway variables set CACHE_BUST=$(date +%s)
```

### 5. Disable Cache for Specific Layers

If you need to ensure certain steps always run fresh, you can add a cache-busting step before them:

```dockerfile
# Force apt-get to run fresh (example)
RUN echo "Cache bust: $(date)" && apt-get update && apt-get install -y ...
```

### 6. Verify Build is Fresh

After deployment, verify extensions are installed:

```bash
railway run php -m | grep pgsql
railway run php -r "print_r(PDO::getAvailableDrivers());"
```

## Best Practices

### ✅ DO:
- Use `CACHE_BUST` argument when you need fresh builds
- Update the value in Dockerfile when making critical changes
- Use Railway's redeploy feature for quick cache clearing
- Verify extensions after deployment

### ❌ DON'T:
- Don't disable cache permanently (slows down builds)
- Don't commit empty commits frequently (pollutes git history)
- Don't ignore build verification steps

## When to Clear Cache

Clear build cache when:
- ✅ PHP extensions aren't loading correctly
- ✅ Dependencies are outdated
- ✅ Configuration changes aren't taking effect
- ✅ After updating Dockerfile base image
- ✅ When switching PHP versions
- ✅ After adding new system packages

## Quick Reference

```bash
# Force rebuild via CLI
cd backend
railway redeploy

# Check extensions after build
railway run php -m | grep pgsql

# View build logs
railway logs --deployment

# Check current build
railway status
```

## Troubleshooting

### Build Still Using Cache?

1. **Check Railway Settings**: Some Railway plans cache more aggressively
2. **Update CACHE_BUST**: Increment the value in Dockerfile
3. **Use Build Arguments**: Set `CACHE_BUST` as Railway variable
4. **Contact Support**: If cache persists, Railway support can help

### Build Takes Too Long?

If you disable cache completely, builds will be slower. Instead:
- Only clear cache when necessary
- Use cache-busting for specific layers
- Keep base image layers cached (they change less frequently)

