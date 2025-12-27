/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./src/**/*.{astro,html,js,jsx,md,mdx,svelte,ts,tsx,vue}'],
  theme: {
    extend: {
      colors: {
        'brand-background': '#0A192F',
        'brand-text-primary': '#CCD6F6',
        'brand-text-secondary': '#E6F1FF',
        'brand-primary': '#D4AF37',
        'brand-secondary': '#F5E6D3',
        'brand-gold': '#D4AF37',
        'brand-gold-light': '#F5E6D3',
        'brand-gold-dark': '#AA8C2C',
      },
      fontFamily: {
        'sans': ['Montserrat', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'sans-serif'],
        'serif': ['Playfair Display', 'Georgia', 'Times New Roman', 'serif'],
      },
    },
  },
  plugins: [],
}