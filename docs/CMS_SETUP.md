# Lewan Interior Design - CMS Setup Guide

This guide explains how to set up and use the Decap CMS (Content Management System) for managing your website content.

## Overview

The CMS allows you to:
- Edit text content in both English and Arabic
- Update images throughout the site
- Manage portfolio projects
- Add/remove gallery images

## Initial Setup (One-time)

### Step 1: Enable Netlify Identity

1. Log in to your [Netlify Dashboard](https://app.netlify.com)
2. Select your site (lewaninterior.com)
3. Go to **Site settings** → **Identity**
4. Click **Enable Identity**

### Step 2: Configure Registration

1. Under **Identity** → **Registration preferences**
2. Select **Invite only** (recommended for security)
3. Save changes

### Step 3: Enable Git Gateway

1. Under **Identity** → **Services**
2. Click **Enable Git Gateway**
3. This allows the CMS to make changes to your website

### Step 4: Invite Users

1. Under **Identity** → **Invite users**
2. Enter the email addresses of people who need CMS access
3. They will receive an invitation email to create their account

## Accessing the CMS

1. Go to: **https://lewaninterior.com/admin/**
2. Click **Login with Netlify Identity**
3. Enter your email and password
4. You're now in the CMS!

## Using the CMS

### Dashboard Overview

The CMS is organized into sections:
- **Site Settings** - General site configuration
- **Home Page** - Hero section, About section, Why Choose Us, etc.
- **Navigation** - Menu labels in both languages
- **Portfolio Projects** - All portfolio items
- **About Page** - About page content
- **Services Page** - Services page content
- **Contact Page** - Contact page content
- **Footer** - Footer text

### Editing Content

1. Click on any section in the left sidebar
2. Select the item you want to edit
3. Make your changes in the editor
4. For bilingual content, use the **EN** / **AR** tabs at the top
5. Click **Save** when done

### Managing Images

1. Click the image field you want to change
2. Click **Choose an image** or drag and drop
3. Upload your new image
4. Click **Choose selected** to confirm

**Image Tips:**
- Use `.webp` format for best performance
- Keep images under 500KB when possible
- Recommended sizes:
  - Hero images: 1920x1080px
  - Portfolio thumbnails: 800x600px
  - Gallery images: 1200x800px

### Adding Portfolio Projects

1. Go to **Portfolio Projects**
2. Click **New Project**
3. Fill in:
   - **Title** (in both English and Arabic)
   - **Slug** (URL-friendly name, e.g., "master-bedroom")
   - **Description** (in both languages)
   - **Thumbnail** (main image for the project)
   - **Order** (lower number = appears first)
   - **Gallery** (add multiple images)
4. Click **Save**

### Publishing Changes

1. After saving, your changes go to **Editorial Workflow**
2. Review your changes in the **Workflow** section
3. Move the entry to **Ready** status
4. Click **Publish** to make changes live
5. Wait 1-2 minutes for the site to rebuild

## Troubleshooting

### Can't Log In?
- Check your email for the invitation
- Try resetting your password
- Clear browser cookies and try again

### Changes Not Showing?
- Wait 2-3 minutes for the site to rebuild
- Clear your browser cache (Ctrl+Shift+R)
- Check if changes are published (not just saved)

### Image Upload Failed?
- Check file size (max 10MB)
- Try a different image format
- Ensure stable internet connection

## Need Help?

Contact your web developer if you:
- Need additional user accounts
- Want to add new content sections
- Experience technical issues
- Need training on specific features

---

**CMS URL:** https://lewaninterior.com/admin/

**Technical Notes:**
- CMS: Decap CMS (formerly Netlify CMS)
- Authentication: Netlify Identity
- Content Storage: Git (automatic version control)
- Languages: English (en), Arabic (ar)
