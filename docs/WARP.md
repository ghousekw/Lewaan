# WARP.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Project Overview

Lewaan Interior Design website is a modern, high-performance website built with **Astro.js** and **Tailwind CSS**. The site showcases interior design services and portfolio projects with a sophisticated dark blue theme, bilingual support (English/Arabic), and responsive design. It uses Astro's Islands Architecture for optimal performance.

## Build & Development Commands

All commands are run from the project root:

| Command | Purpose |
|---------|---------|
| `npm install` | Install dependencies |
| `npm run dev` | Start development server at `http://localhost:3000` |
| `npm run build` | Build production site to `./dist/` directory |
| `npm run preview` | Preview production build locally |
| `npm run astro -- --help` | Access Astro CLI for additional commands |

## Project Structure

```
Lewaan/
├── src/
│   ├── pages/              # File-based routing (each .astro file = route)
│   │   ├── index.astro     # Homepage (/)
│   │   ├── about.astro     # About page (/about)
│   │   ├── services.astro  # Services (/services)
│   │   ├── contact.astro   # Contact (/contact)
│   │   ├── portfolio.astro # Portfolio listing (/portfolio)
│   │   └── portfolio/
│   │       └── [slug].astro # Dynamic portfolio detail (/portfolio/[slug])
│   │
│   ├── components/         # Reusable Astro components
│   │   ├── Header.astro    # Navigation header with language toggle
│   │   ├── Footer.astro    # Footer with links and social media
│   │   ├── ProjectCard.astro # Card component for project showcase
│   │   ├── Gallery.astro   # Image gallery component
│   │   └── LanguageToggle.astro # Language switcher (en/ar)
│   │
│   ├── layouts/            # Layout wrappers
│   │   └── MainLayout.astro # Main layout with header/footer
│   │
│   ├── data/               # Data files and utilities
│   │   └── portfolio.ts    # Portfolio items data
│   │
│   ├── i18n/               # Internationalization
│   │   ├── index.ts        # i18n utilities and type definitions
│   │   ├── en.ts           # English translations
│   │   └── ar.ts           # Arabic translations
│   │
│   ├── styles/
│   │   └── global.css      # Global Tailwind directives and custom styles
│   │
│   └── assets/             # Static images and media
│
├── public/                 # Public static files (favicon, images, etc.)
├── package.json           # Dependencies and scripts
├── tailwind.config.cjs    # Tailwind configuration with brand colors
├── astro.config.mjs       # Astro configuration
├── tsconfig.json          # TypeScript configuration
└── .cursor/rules/         # Cursor AI rules for development
```

## Architecture & Key Concepts

### Astro Islands Architecture

This site uses Astro's **Islands Architecture**:
- **Static by default**: All components render on the server as HTML, zero JavaScript shipped initially
- **Partial hydration**: Only interactive components (LanguageToggle, forms) use `client:` directives
- **File-based routing**: Pages in `src/pages/` automatically create routes
- **Component types**:
  - `.astro` files: Server-rendered static components (layouts, headers, cards)
  - Framework components: Used sparingly for interactivity

### Design System

The site uses a **custom Tailwind theme** with brand colors defined in `tailwind.config.cjs`:

```
- brand-background: #0A192F (dark navy)
- brand-text-primary: #CCD6F6 (light blue-gray)
- brand-text-secondary: #E6F1FF (off-white)
- brand-primary: #007BFF (vibrant blue)
- brand-secondary: #64FFDA (cyan/mint)
```

Font families:
- Body/UI: Montserrat
- Headings: Playfair Display

### Internationalization (i18n)

The site supports **English and Arabic** with RTL support:
- Language detection from URL parameters (`?lang=en` or `?lang=ar`)
- LocalStorage fallback for language preference
- Browser language detection as default
- CSS RTL utilities in `global.css` for layout direction
- Separate translation files in `src/i18n/` (en.ts, ar.ts)
- `getTranslations(language)` utility function to fetch translations

**Key pattern**: Use `addLangToUrl(url, language)` helper to preserve language when navigating between pages.

### Data & Portfolio Management

- Portfolio items are stored in `src/data/portfolio.ts`
- Dynamic routes via `src/pages/portfolio/[slug].astro` for individual project pages
- Project slugs and content centralized for easy updates

## Important Development Patterns

### Adding New Pages

1. Create a new `.astro` file in `src/pages/`
2. Import `MainLayout` for consistent header/footer
3. Add corresponding translations in `src/i18n/en.ts` and `src/i18n/ar.ts`
4. Use the language utility to preserve language state across navigation

Example:
```astro path=null start=null
---
import MainLayout from '../layouts/MainLayout.astro';
import { getTranslations, type Language } from '../i18n';

const language = (Astro.url.searchParams.get('lang') as Language) || 'en';
const t = getTranslations(language);
---

<MainLayout>
  <h1>{t.myPage.title}</h1>
</MainLayout>
```

### Adding Portfolio Items

Edit `src/data/portfolio.ts` and add new items to the `portfolioItems` array with: `id`, `slug`, `title`, `description`, `thumbnail`, and `gallery` properties.

### Styling Approach

- Use Tailwind utility classes for responsive design
- Custom CSS in `global.css` for global styles, noise texture, and RTL utilities
- Component-scoped styles can use Astro's `<style scoped>` tag

## External Rules & Guidelines

The `.cursor/rules/byterover-rules.mdc` file specifies using Byterover MCP for:
- Storing learned patterns and solutions
- Retrieving context before starting new tasks
- Always document significant implementations and debugging solutions

Follow the **GEMINI.md** guidelines for Astro best practices, particularly:
- Leverage Astro's static-first approach
- Use server-side data fetching in frontmatter
- Implement partial hydration with `client:` directives
- Maintain accessibility (A11Y) standards
- Update `blueprint.md` when making architectural changes

## Common Tasks

### Starting development
```
npm install
npm run dev
```

### Building for production
```
npm run build
```

### Adding translations
Update both `src/i18n/en.ts` and `src/i18n/ar.ts` with matching keys, then reference in components using `t.sectionName.key`.

### Debugging style issues
Check `global.css` for RTL utilities and brand color definitions in `tailwind.config.cjs`.

### Adding new components
Place new components in `src/components/` and import them in pages or layouts. Keep components minimal and focus on static rendering when possible.

## Dependencies

- **astro**: ^5.15.3 - Static site builder
- **tailwindcss**: ^3.4.18 - Utility-first CSS framework
- **@astrojs/tailwind**: ^6.0.2 - Astro integration for Tailwind

## Notes for Future Development

- The site currently uses a rich blue theme (v2.1) as defined in `blueprint.md`
- RTL support for Arabic is implemented via CSS utilities and HTML `dir="rtl"` attribute
- Image optimization uses `.webp` format where possible (e.g., `/heroimage.webp`)
- The `blueprint.md` file documents design system and implementation status—review before making design changes
- Language preference is preserved via URL parameters and localStorage
