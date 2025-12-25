# Portfolio Management Guide - Admin Panel

## Overview
The portfolio section has been enhanced with powerful features for managing your interior design projects.

## Features

### 📊 Enhanced List View
- **Image Count Display**: Each project shows the number of images (e.g., "📸 10 images")
- **Order Number**: Quick reference for project ordering
- **Project Title**: Displayed in English
- **Sortable Columns**: Sort by order, title, or date
- **Filter Options**: Filter by Featured, Published, or Draft status
- **Group By**: Group projects by Status or Category

### 🎯 Project Fields

#### Basic Information
- **Slug**: URL-friendly identifier (auto-validated)
- **Display Order**: 0-100 (lower = appears first)
- **Featured**: Mark important projects
- **Status**: Published / Draft / Private
- **Category**: Multiple categories (Bedroom, Living Room, Kitchen, etc.)
- **Thumbnail**: Main preview image

#### Content (Bilingual)
- **Title**: English & Arabic
- **Short Description**: Brief 2-3 sentence description
- **Full Description**: Detailed markdown content (optional)
- **Project Details**: Location, Year, Area, Style (optional)

#### Gallery
- **Drag to Reorder**: Simply drag images up/down
- **Media Type**: Image or Video
- **Alt Text**: For accessibility (EN/AR)
- **Captions**: Optional image captions (EN/AR)
- **Auto Count**: Image count updates automatically

#### Additional
- **Tags**: Searchable keywords
- **SEO Metadata**: Custom meta titles and descriptions

## How to Use

### Adding a New Project
1. Click **"New Project"** button
2. Fill in the slug (e.g., "luxury-villa")
3. Set display order (0 = top)
4. Upload thumbnail image
5. Add English & Arabic content
6. Upload gallery images
7. Drag images to reorder them
8. Click **"Save"**

### Reordering Projects
**Method 1: Using Order Numbers**
1. Edit each project
2. Change the "Display Order" number
3. Save

**Method 2: Drag and Drop** (when sorted by order)
1. Click "Sort by" → Select "order"
2. Drag project cards up/down
3. Order numbers update automatically

### Reordering Gallery Images
1. Open any project
2. Scroll to "Project Gallery"
3. Grab any image card
4. Drag it up or down
5. Release to drop in new position
6. Save the project

### Filtering Projects
- **By Status**: Click "Filter by" → Select status
- **By Featured**: Click "Filter by" → "Featured Projects"
- **By Category**: Click "Group by" → "Category"

### Image Count
The image count is automatically calculated and displayed:
- In the list view: "📸 10 images"
- Updates automatically when you add/remove gallery images
- Stored in the `imageCount` field

## Tips

### Best Practices
- Use order numbers in increments of 5 or 10 (easier to insert projects later)
- Keep thumbnails under 2MB
- Keep gallery images under 5MB
- Use .webp format for best performance
- Add meaningful alt text for accessibility
- Use categories to help visitors filter projects

### Recommended Image Sizes
- **Thumbnails**: 800x600px
- **Gallery Images**: 1200x800px or larger
- **Format**: .webp (best compression)

### SEO Tips
- Write descriptive titles (50-60 characters)
- Keep meta descriptions under 160 characters
- Use relevant keywords in descriptions
- Add location information when relevant

## Troubleshooting

### Image Count Not Showing?
- Save the project once to trigger auto-calculation
- The count updates on every save

### Can't Drag to Reorder?
- Make sure you're sorted by "order" field
- Try refreshing the page
- Check that you're logged in

### Changes Not Appearing?
- Wait 2-3 minutes for site rebuild
- Clear browser cache (Ctrl+Shift+R)
- Check that changes are published (not just saved)

## Technical Details

### Auto-Calculated Fields
- `imageCount`: Automatically set on save via preSave event listener
- Updates whenever gallery is modified

### File Structure
```
src/content/portfolio/
├── project-slug.json
└── ...
```

### JSON Structure
```json
{
  "slug": "project-name",
  "order": 1,
  "imageCount": 10,
  "featured": false,
  "status": "published",
  "category": ["bedroom", "luxury"],
  "thumbnail": "/path/to/image.webp",
  "en": { "title": "...", "description": "..." },
  "ar": { "title": "...", "description": "..." },
  "gallery": [...],
  "tags": ["modern", "luxury"],
  "seo": {...}
}
```

## Support
For technical issues or feature requests, contact your web developer.
