/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./src/**/*.{astro,html,js,jsx,md,mdx,svelte,ts,tsx,vue}'],
  theme: {
    extend: {
      colors: {
        'brand-background': '#0A192F',
        'brand-text-primary': '#CCD6F6',
        'brand-text-secondary': '#E6F1FF',
        'brand-primary': '#007BFF',
        'brand-secondary': '#64FFDA',
      },
      fontFamily: {
        'sans': ['Montserrat', 'sans-serif'],
        'serif': ['Playfair Display', 'serif'],
      },
    },
  },
  plugins: [],
}