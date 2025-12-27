import { en } from './en';
import { ar } from './ar';

export type Language = 'en' | 'ar';
export type Translations = typeof en;

export const translations = {
  en,
  ar,
};

export function getTranslations(lang: Language): Translations {
  return translations[lang];
}

export function getDefaultLanguage(): Language {
  if (typeof window === 'undefined') {
    return 'en';
  }
  
  const stored = localStorage.getItem('language') as Language;
  if (stored && (stored === 'en' || stored === 'ar')) {
    return stored;
  }
  
  // Try to detect from browser
  const browserLang = navigator.language.split('-')[0];
  return browserLang === 'ar' ? 'ar' : 'en';
}

