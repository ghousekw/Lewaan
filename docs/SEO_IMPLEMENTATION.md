# SEO Implementation Guide - Lewan Interior Design

## Overview

This document outlines the complete SEO (Search Engine Optimization) implementation for the Lewan Interior Design website. The site is built with Astro and supports both English and Arabic languages.

## Table of Contents

1. [SEO Fundamentals](#seo-fundamentals)
2. [Implementation Details](#implementation-details)
3. [Files Created/Modified](#files-createdmodified)
4. [Configuration](#configuration)
5. [Page-Specific SEO](#page-specific-seo)
6. [Testing & Validation](#testing--validation)
7. [Maintenance](#maintenance)

---

## SEO Fundamentals

### What is SEO?

SEO helps search engines (Google, Bing) understand and rank your website. Better SEO = higher visibility in search results = more visitors.

### Key SEO Elements Implemented

| Element | Purpose | Location |
|---------|---------|----------|
| **Title Tag** | Clickable headline in search results | `<title>` in `<head>` |
| **Meta Description** | Preview text below title | `<meta name="description">` |
| **Open Graph Tags** | Social media sharing preview | `<meta property="og:*">` |
| **Twitter Cards** | Twitter sharing preview | `<meta name="twitter:*">` |
| **Canonical URL** | Prevents duplicate content issues | `<link rel="canonical">` |
| **Hreflang Tags** | Multi-language SEO | `<link rel="alternate" hreflang>` |
| **Structured Data** | Rich search results (JSON-LD) | `<script type="application/ld+json">` |
| **Sitemap** | Helps search engines find all pages | `/sitemap-index.xml` |
| **robots.txt** | Crawling instructions | `/robots.txt` |

---

## Implementation Details

### 1. SEO Component (`src/components/SEO.astro`)

A reusable component that generates all SEO-related meta tags.

**Props:**

```typescript
interface SEOProps {
  title: string;           // Page title (max 60 chars recommended)
  description: string;     // Meta description (max 160 chars recommended)
  image?: string;          // OG image URL (default: /heroimage.webp)
  type?: string;           // OG type (default: website)
  language: 'en' | 'ar';   // Current language
  canonicalPath?: string;  // Path without language prefix
  noindex?: boolean;       // Prevent indexing (default: false)
}
```

**Usage in pages:**

```astro
---
import SEO from '../components/SEO.astro';
---
<head>
  <SEO 
    title="Page Title | Lewan"
    description="Page description here"
    language={language}
    canonicalPath="/about"
  />
</head>
```

### 2. Structured Data (JSON-LD)

The SEO component includes:

- **Organization Schema**: Company information
- **LocalBusiness Schema**: Kuwait location, contact info
- **WebSite Schema**: Site search potential
- **BreadcrumbList**: Navigation hierarchy

### 3. Sitemap Generation

Using `@astrojs/sitemap` integration for automatic sitemap generation at build time.

**Configuration in `astro.config.mjs`:**

```javascript
import sitemap from '@astrojs/sitemap';

export default defineConfig({
  site: 'https://lewaninterior.com',
  integrations: [sitemap()]
});
```

### 4. robots.txt

Located at `public/robots.txt`:

```
User-agent: *
Allow: /

Sitemap: https://lewaninterior.com/sitemap-index.xml
```

---

## Files Created/Modified

### New Files

| File | Description |
|------|-------------|
| `src/components/SEO.astro` | Reusable SEO component |
| `public/robots.txt` | Crawler instructions |
| `docs/SEO_IMPLEMENTATION.md` | This documentation |

### Modified Files

| File | Changes |
|------|---------|
| `astro.config.mjs` | Added sitemap integration & site URL |
| `src/layouts/MainLayout.astro` | Added SEO component integration |
| `src/pages/[lang]/index.astro` | Added SEO metadata |
| `src/pages/[lang]/about.astro` | Added SEO metadata |
| `src/pages/[lang]/services.astro` | Added SEO metadata |
| `src/pages/[lang]/portfolio.astro` | Added SEO metadata |
| `src/pages/[lang]/portfolio/[slug].astro` | Added dynamic SEO metadata |
| `src/pages/[lang]/contact.astro` | Added SEO metadata |

---

## Configuration

### Required: Set Your Production URL

**IMPORTANT:** Update the site URL in `astro.config.mjs`:

```javascript
export default defineConfig({
  site: 'https://lewaninterior.com',
  // ...
});
```

Also update in `src/components/SEO.astro`:

```javascript
const siteUrl = 'https://lewaninterior.com';
```

### Optional: Customize OG Image

Replace `/public/og-image.jpg` with your custom social share image.

**Recommended dimensions:** 1200 x 630 pixels

---

## Page-Specific SEO

### Homepage (`/en/` and `/ar/`)

**English:**
- Title: "Lewan Interior Design | Premium Interior Design Services in Kuwait"
- Description: "Transform your space with Lewan - Kuwait's leading interior design firm since 2015. Specializing in luxury residential and commercial interiors."

**Arabic:**
- Title: "ليوان للتصميم الداخلي | خدمات التصميم الداخلي الفاخرة في الكويت"
- Description: "حوّل مساحتك مع ليوان - شركة التصميم الداخلي الرائدة في الكويت منذ 2015. متخصصون في التصميم الداخلي الفاخر للمنازل والمشاريع التجارية."

### About Page (`/en/about` and `/ar/about`)

**English:**
- Title: "About Lewan | Award-Winning Interior Designers in Kuwait"
- Description: "Founded in 2015 by Engr. Ebtehal Al Ameer. 1,238+ projects completed. Discover why Lewan is Kuwait's most trusted interior design company."

### Services Page (`/en/services` and `/ar/services`)

**English:**
- Title: "Interior Design Services | 2D Planning, 3D Visualization | Lewan Kuwait"
- Description: "Complete interior design services: 2D master plans, 3D visualization, turnkey execution. Modern, minimalist, Islamic, and contemporary styles."

### Portfolio Page (`/en/portfolio` and `/ar/portfolio`)

**English:**
- Title: "Portfolio | Luxury Interior Design Projects | Lewan Kuwait"
- Description: "Browse our stunning portfolio of residential and commercial interior projects. Reception halls, living rooms, bedrooms, and more."

### Contact Page (`/en/contact` and `/ar/contact`)

**English:**
- Title: "Contact Lewan | Book Your Interior Design Consultation in Kuwait"
- Description: "Ready to transform your space? Contact Lewan Interior Design for a consultation. Available 24/7 for all your interior design needs in Kuwait."

---

## Testing & Validation

### Tools to Validate SEO

1. **Google Rich Results Test**
   - URL: https://search.google.com/test/rich-results
   - Tests structured data (JSON-LD)

2. **Facebook Sharing Debugger**
   - URL: https://developers.facebook.com/tools/debug/
   - Tests Open Graph tags

3. **Twitter Card Validator**
   - URL: https://cards-dev.twitter.com/validator
   - Tests Twitter Card tags

4. **Google Search Console**
   - URL: https://search.google.com/search-console
   - Monitor indexing, submit sitemap

5. **Lighthouse (Chrome DevTools)**
   - Press F12 → Lighthouse tab → Run SEO audit

### Manual Checklist

- [ ] Title tags are unique for each page
- [ ] Meta descriptions are unique and under 160 characters
- [ ] All images have alt text
- [ ] Sitemap is accessible at `/sitemap-index.xml`
- [ ] robots.txt is accessible at `/robots.txt`
- [ ] Hreflang tags link EN ↔ AR pages correctly
- [ ] Structured data passes validation
- [ ] OG images display correctly when sharing

---

## Maintenance

### Regular Tasks

1. **Monthly:** Check Google Search Console for errors
2. **After content changes:** Verify meta descriptions are updated
3. **After new pages:** Ensure SEO component is included
4. **Quarterly:** Run Lighthouse SEO audit

### Adding New Pages

When creating a new page, always include SEO:

```astro
---
import MainLayout from '../../layouts/MainLayout.astro';

const seo = {
  title: "Page Title | Lewan",
  description: "Description under 160 characters",
  canonicalPath: "/new-page"
};
---

<MainLayout language={language} seo={seo}>
  <!-- Page content -->
</MainLayout>
```

---

## Target Keywords

### English Keywords

- Interior design Kuwait
- Interior designer Kuwait
- Best interior design company Kuwait
- Kuwait interior decoration
- Villa interior design Kuwait
- Luxury interior design Kuwait
- 3D visualization Kuwait
- Home decoration Kuwait

### Arabic Keywords

- تصميم داخلي الكويت
- ديكور الكويت
- شركة تصميم داخلي
- تصميم فلل الكويت
- ديكورات منازل الكويت
- تصميم داخلي فاخر

---

## Troubleshooting

### Issue: Pages not appearing in Google

1. Submit sitemap in Google Search Console
2. Request indexing for specific URLs
3. Check robots.txt isn't blocking pages
4. Verify `noindex` isn't set

### Issue: Wrong image on social share

1. Clear Facebook/Twitter cache using their debug tools
2. Verify `og:image` URL is absolute (starts with https://)
3. Check image dimensions (1200x630px recommended)

### Issue: Duplicate content warnings

1. Verify canonical URLs are set correctly
2. Check hreflang tags link to correct language variants
3. Ensure trailing slashes are consistent

---

## Resources

- [Google SEO Starter Guide](https://developers.google.com/search/docs/fundamentals/seo-starter-guide)
- [Schema.org Documentation](https://schema.org/)
- [Open Graph Protocol](https://ogp.me/)
- [Astro SEO Guide](https://docs.astro.build/en/guides/seo/)

---

*Document created: December 2025*
*Last updated: December 2025*

