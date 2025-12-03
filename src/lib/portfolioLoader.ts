/**
 * Portfolio Loader Utility
 * Loads all portfolio items from CMS JSON files
 * Falls back to hardcoded data if CMS files don't exist
 */

import fs from 'fs';
import path from 'path';
import { portfolioItems as hardcodedItems } from '../data/portfolio';

export interface PortfolioItem {
  slug: string;
  title: string;
  description: string;
  thumbnail: string;
  gallery: Array<{
    type: 'image' | 'video';
    src: string;
    alt?: string | { en: string; ar: string };
    thumbnail?: string;
  }>;
}

export function loadPortfolioItems(): PortfolioItem[] {
  const portfolioPath = path.join(process.cwd(), 'src/content/portfolio');
  let items: PortfolioItem[] = [];

  try {
    // Check if portfolio directory exists
    if (!fs.existsSync(portfolioPath)) {
      return hardcodedItems;
    }

    // Read all JSON files from portfolio directory
    const files = fs.readdirSync(portfolioPath).filter(file => file.endsWith('.json'));
    
    if (files.length === 0) {
      // No CMS files, use hardcoded data
      return hardcodedItems;
    }

    // Load all CMS portfolio items
    const cmsItems: PortfolioItem[] = files
      .map(file => {
        try {
          const filePath = path.join(portfolioPath, file);
          const data = JSON.parse(fs.readFileSync(filePath, 'utf-8'));
          
          return {
            slug: data.slug,
            title: data.en?.title || data.title || '',
            description: data.en?.description || data.description || '',
            thumbnail: data.thumbnail,
            gallery: data.gallery || [],
            order: data.order || 0
          };
        } catch (err) {
          console.warn(`Failed to parse ${file}:`, err);
          return null;
        }
      })
      .filter((item): item is { slug: string; title: string; description: string; thumbnail: string; gallery: any[]; order: number } => item !== null)
      .sort((a, b) => a.order - b.order)
      .map(({ order, ...item }) => item as PortfolioItem)

    return cmsItems.length > 0 ? cmsItems : hardcodedItems;
  } catch (err) {
    console.warn('Failed to load portfolio items from CMS, using hardcoded data:', err);
    return hardcodedItems;
  }
}
