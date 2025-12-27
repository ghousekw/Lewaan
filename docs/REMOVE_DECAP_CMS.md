# 🗑️ Remove Decap CMS Setup

## Files to Remove

### 1. Admin Panel Files
- `public/admin/config.yml`
- `public/admin/index.html`
- `public/admin/` (entire folder)

### 2. Documentation Files (Optional - keep for reference)
- `docs/CMS_SETUP.md`

### 3. Content Files (Keep for migration)
- `src/content/portfolio/*.json` - Keep these for data migration
- `src/content/home/*.json` - Keep if you want to migrate home content
- `src/content/about/*.json` - Keep if you want to migrate about content
- etc.

## What to Keep

✅ **Keep these for now:**
- All JSON files in `src/content/` - You'll migrate this data to Laravel
- All images in `public/` folders - You'll upload these to Cloudinary/R2
- Your Astro site structure - You'll update API calls later

## Removal Steps

### Step 1: Remove Admin Panel
```bash
# Remove admin folder
rm -rf public/admin
```

### Step 2: Remove Netlify Identity (if configured)
Remove from `astro.config.mjs` or any layout files:
```html
<!-- Remove this script if present -->
<script src="https://identity.netlify.com/v1/netlify-identity-widget.js"></script>
```

### Step 3: Update .gitignore (Optional)
Add if you want to keep content files locally but not commit:
```
# src/content/portfolio/*.json  # Uncomment after migration
```

### Step 4: Clean up package.json (if any CMS-related packages)
Check for any Decap/Netlify CMS related packages and remove them.

## After Removal

Your project will be clean and ready for Laravel + Filament integration!

**Note:** Don't delete content JSON files until after you've successfully migrated them to Laravel!
