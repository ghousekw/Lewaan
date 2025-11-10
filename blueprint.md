# Lewaan Interior Design - Website Blueprint

## Overview

A public-facing website for Lewaan Interior Design to showcase their portfolio, services, and company information. The website is visually appealing, modern, and fast, built with Astro.js.

---

## Style, Design, and Features (v2.1 - Current)

This version pivots to a rich, high-contrast blue theme, creating a classic, luxurious, and modern aesthetic.

### Design & Aesthetics
*   **Color Palette:** A sophisticated and bold blue-based palette.
    *   **Background:** A deep, dark navy blue (`#0A192F`) with a subtle noise texture.
    *   **Text:** A soft, light blue-gray (`#CCD6F6`) for primary text, with a lighter off-white (`#E6F1FF`) for headings and important elements.
    *   **Primary Accent:** A vibrant, rich blue (`#007BFF`) for buttons and key interactive elements.
    *   **Secondary Accent:** An electric, minty cyan (`#64FFDA`) for highlights, links, and hover effects.
*   **Typography:** A modern and elegant font pairing.
    *   **Headings:** "Playfair Display" for a classic, sophisticated feel.
    *   **Body & UI:** "Montserrat" for clean, modern readability.
*   **Layout:** Dynamic, visually engaging, and mobile-first.
    *   **Spacing:** Generous use of white space for a clean, uncluttered feel.
    *   **Visual Effects:**
        *   **Depth:** Multi-layered drop shadows on cards and key elements to create a "lifted" look against the dark background.
        *   **Interactivity:** Buttons and links have a subtle "glow" or transition effect on hover, often using the secondary accent color.
*   **Imagery:** High-quality, atmospheric images remain central, now contrasted against the dark blue theme.

### Features
*   **Homepage:**
    *   **Hero Section:** A full-bleed hero section with a stunning interior design photo, a semi-transparent overlay for text contrast, and a bold headline.
    *   **About Us Section:** A concise and elegant introduction to the studio.
    *   **Featured Projects Section:** A grid of interactive project cards with hover effects, adapted for the dark theme.
    *   **Call-to-Action (CTA):** A clear and compelling section urging users to get in touch.
*   **Navigation:** A minimalist and sticky header that is transparent at the top and transitions to a solid, dark background on scroll.
*   **Footer:** A clean, professional footer with essential links and social media icons, adapted for the dark theme.
*   **Project Cards:** Reusable component for showcasing projects, redesigned to stand out on the dark background.

### Technical Stack
*   **Framework:** Astro.js
*   **Styling:** Tailwind CSS (with a custom configuration for the new design system).
*   **Fonts:** Google Fonts (Playfair Display and Montserrat).
*   **Components:** Modular components for `Header`, `Footer`, `ProjectCard`, etc.

---

## Current Request: Implement a Rich Blue Theme

**Plan:**
1.  **Update `blueprint.md`:** Define the new v2.1 "Rich Blue" design system. (Complete)
2.  **Update Tailwind Config:** Modify `tailwind.config.cjs` to use the new blue color palette.
3.  **Update Global Styles:** Change `src/styles/global.css` to set the new dark navy background and default text colors.
4.  **Update Homepage (`index.astro`):** Adjust colors and styles for the new theme, especially in the About and CTA sections.
5.  **Update `ProjectCard.astro`:** Redesign the cards for the dark theme.
6.  **Redesign `Header.astro` and `Footer.astro`:** Adapt the components to the new dark, high-contrast aesthetic.
7.  **Restart and Verify:** Run the dev server and ensure the new design is implemented correctly.
