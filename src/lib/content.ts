/**
 * Content Loader Utility
 * Loads content from CMS JSON files with i18n support
 */

import type { Language } from '../i18n';

// Import JSON content files
import heroContent from '../content/home/hero.json';
import aboutContent from '../content/home/about.json';
import whyChooseUsContent from '../content/home/why-choose-us.json';
import ctaContent from '../content/home/cta.json';
import navContent from '../content/navigation/nav.json';
import footerContent from '../content/footer/content.json';
import settingsContent from '../content/settings/general.json';

// Type definitions for content
export interface HeroContent {
  tagline: string;
  title1: string;
  title2: string;
  description: string;
  exploreWork: string;
  getInTouch: string;
  heroImage?: string;
}

export interface AboutContent {
  label: string;
  title: string;
  description1: string;
  description2: string;
  stats: {
    projects: string;
    clients: string;
    experience: string;
    awards: string;
  };
  statsNumbers: {
    projectsCount: number;
    clientsCount: number;
    experienceCount: number;
    awardsCount: number;
  };
  image?: string;
}

export interface WhyChooseUsContent {
  label: string;
  title: string;
  description: string;
  reasons: Array<{
    icon: string;
    title: string;
    description: string;
  }>;
}

export interface CTAContent {
  label: string;
  title: string;
  description: string;
  getInTouch: string;
  learnMore: string;
}

export interface NavContent {
  home: string;
  about: string;
  services: string;
  portfolio: string;
  contact: string;
}

export interface FooterContent {
  copyright: string;
}

export interface SiteSettings {
  siteName: string;
  phone: string;
  email: string;
  instagram: string;
  address: string;
}

// Content getters with language support
export function getHeroContent(lang: Language): HeroContent & { heroImage?: string } {
  const content = heroContent as any;
  return {
    ...content[lang],
    heroImage: content.heroImage,
  };
}

export function getAboutContent(lang: Language): AboutContent {
  const content = aboutContent as any;
  return {
    ...content[lang],
    statsNumbers: content.statsNumbers,
    image: content.image,
  };
}

export function getWhyChooseUsContent(lang: Language): WhyChooseUsContent {
  const content = whyChooseUsContent as any;
  return content[lang];
}

export function getCTAContent(lang: Language): CTAContent {
  const content = ctaContent as any;
  return content[lang];
}

export function getNavContent(lang: Language): NavContent {
  const content = navContent as any;
  return content[lang];
}

export function getFooterContent(lang: Language): FooterContent {
  const content = footerContent as any;
  return content[lang];
}

export function getSiteSettings(): SiteSettings {
  return settingsContent as SiteSettings;
}

// Portfolio content loader
export interface PortfolioItem {
  slug: string;
  order: number;
  thumbnail: string;
  title: string;
  description: string;
  gallery: Array<{
    type: 'image' | 'video';
    src: string;
    alt: string;
  }>;
}

export async function getPortfolioItems(lang: Language): Promise<PortfolioItem[]> {
  // Import all portfolio JSON files from the content/portfolio directory
  const portfolioFiles = import.meta.glob('../content/portfolio/*.json', { eager: true });
  
  const items: PortfolioItem[] = [];
  
  for (const path in portfolioFiles) {
    const content = portfolioFiles[path] as any;
    const langContent = content[lang] || content.en;
    
    items.push({
      slug: content.slug,
      order: content.order || 0,
      thumbnail: content.thumbnail,
      title: langContent.title,
      description: langContent.description,
      gallery: content.gallery?.map((item: any) => ({
        type: item.type,
        src: item.src,
        alt: typeof item.alt === 'object' ? item.alt[lang] || item.alt.en : item.alt,
      })) || [],
    });
  }
  
  // Sort by order
  return items.sort((a, b) => a.order - b.order);
}

export async function getPortfolioItem(slug: string, lang: Language): Promise<PortfolioItem | null> {
  const items = await getPortfolioItems(lang);
  return items.find(item => item.slug === slug) || null;
}
