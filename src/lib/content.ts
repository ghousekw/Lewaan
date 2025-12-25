/**
 * Content Loader Utility
 * Loads content from CMS JSON files with i18n support
 */

import type { Language } from '../i18n';
import { portfolioItems as hardcodedPortfolio } from '../data/portfolio';

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

const fallbackTranslations: Record<string, Record<Language, { title: string; description: string }>> = {
  'reception': {
    en: { title: 'Reception', description: 'A welcoming and elegant reception area designed to make a lasting first impression.' },
    ar: { title: 'الاستقبال', description: 'منطقة استقبال ترحيبية وأنيقة مصممة لترك انطباع أول دائم.' }
  },
  'deewaniya-mughallath': {
    en: { title: 'Deewaniya & Mughallath', description: 'Traditional Arabic gathering spaces with modern elegance and cultural authenticity.' },
    ar: { title: 'الديوانية والمقلث', description: 'مساحات تجمع عربية تقليدية بأناقة عصرية وأصالة ثقافية.' }
  },
  'living-hall': {
    en: { title: 'Living Hall', description: 'A spacious and comfortable living area designed for family gatherings and relaxation.' },
    ar: { title: 'صالة المعيشة', description: 'منطقة معيشة واسعة ومريحة مصممة لتجمعات الأسرة والاسترخاء.' }
  },
  'dining-hall': {
    en: { title: 'Dining Hall', description: 'An elegant dining space perfect for hosting family meals and special occasions.' },
    ar: { title: 'قاعة الطعام', description: 'مساحة طعام أنيقة مثالية لاستضافة وجبات الأسرة والمناسبات الخاصة.' }
  },
  'master-bedrooms': {
    en: { title: 'Master Bedrooms', description: 'Luxurious master bedrooms designed for ultimate comfort and relaxation.' },
    ar: { title: 'غرف النوم الرئيسية', description: 'غرف نوم رئيسية فاخرة مصممة للراحة والاسترخاء القصوى.' }
  },
  'child-room': {
    en: { title: 'Child Room', description: 'Playful and imaginative spaces designed to inspire creativity and fun.' },
    ar: { title: 'غرفة الأطفال', description: 'مساحات مرحة وخيالية مصممة لإلهام الإبداع والمرح.' }
  },
  'wash-bathroom': {
    en: { title: 'Wash & Bathroom', description: 'Spa-like bathrooms combining luxury, functionality, and modern design.' },
    ar: { title: 'دورة المياه والحمام', description: 'حمامات فاخرة تجمع بين الرفاهية والعملية والتصميم العصري.' }
  },
  'dressing-room': {
    en: { title: 'Dressing Room', description: 'Elegant and organized dressing rooms with custom storage solutions.' },
    ar: { title: 'غرفة الملابس', description: 'غرف ملابس أنيقة ومنظمة مع حلول تخزين مخصصة.' }
  },
  'cinema-hall': {
    en: { title: 'Cinema Hall', description: 'State-of-the-art home theaters for the ultimate entertainment experience.' },
    ar: { title: 'قاعة السينما', description: 'صالات سينما منزلية متطورة لتجربة ترفيهية مثالية.' }
  },
  'corridors': {
    en: { title: 'Corridors', description: 'Beautifully designed corridors that seamlessly connect spaces throughout the home.' },
    ar: { title: 'الممرات', description: 'ممرات مصممة بشكل جميل تربط المساحات بسلاسة في المنزل.' }
  },
  'kitchen': {
    en: { title: 'Kitchen, Pantry & Buffet', description: 'Modern kitchens designed for both functionality and aesthetic appeal.' },
    ar: { title: 'المطبخ، المخزن والبوفيه', description: 'مطابخ عصرية تجمع بين العملية والجمال.' }
  },
  'office': {
    en: { title: 'Office', description: 'Professional and inspiring home office spaces designed for productivity.' },
    ar: { title: 'المكتب', description: 'مكاتب منزلية احترافية وملهمة مصممة للإنتاجية.' }
  },
  'play-room': {
    en: { title: 'Play Room', description: 'Fun and safe playrooms designed to encourage creativity and active play.' },
    ar: { title: 'غرفة اللعب', description: 'غرف لعب ممتعة وآمنة تشجع على الإبداع واللعب النشط.' }
  },
  'staircase': {
    en: { title: 'Staircase', description: 'Stunning staircases that serve as architectural focal points.' },
    ar: { title: 'السلالم', description: 'سلالم مذهلة تمثل نقاط ارتكاز معمارية.' }
  }
};

function mapHardcodedPortfolio(lang: Language): PortfolioItem[] {
  return hardcodedPortfolio.map((item) => {
    const translation = fallbackTranslations[item.slug]?.[lang] || fallbackTranslations[item.slug]?.en;
    const title = translation?.title || item.title;
    const description = translation?.description || item.description;

    return {
      slug: item.slug,
      order: 999, // fallback items go last if mixed with CMS
      thumbnail: item.thumbnail,
      title,
      description,
      gallery: (item.gallery || []).slice(0, 5).map((g) => ({
        type: g.type,
        src: g.src,
        alt: typeof g.alt === 'string' ? g.alt : (g.alt || `${title} image`)
      }))
    };
  });
}

export async function getPortfolioItems(lang: Language): Promise<PortfolioItem[]> {
  try {
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
    
    if (items.length > 0) {
      return items.sort((a, b) => a.order - b.order);
    }

    // Fallback to hardcoded (trimmed) if no CMS items found
    return mapHardcodedPortfolio(lang);
  } catch (err) {
    console.error('[Portfolio Content] Failed to load CMS portfolio, using fallback:', err instanceof Error ? err.message : String(err));
    return mapHardcodedPortfolio(lang);
  }
}

export async function getPortfolioItem(slug: string, lang: Language): Promise<PortfolioItem | null> {
  const items = await getPortfolioItems(lang);
  return items.find(item => item.slug === slug) || null;
}
