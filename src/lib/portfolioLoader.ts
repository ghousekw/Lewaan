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

  try {
    // Check if portfolio directory exists
    if (!fs.existsSync(portfolioPath)) {
      console.log('Portfolio directory not found, using hardcoded data');
      return hardcodedItems;
    }

    // Read all JSON files from portfolio directory
    const files = fs.readdirSync(portfolioPath).filter(file => file.endsWith('.json'));
    
    console.log(`Found ${files.length} portfolio files in CMS`);
    
    if (files.length === 0) {
      console.log('No CMS files found, using hardcoded data');
      return hardcodedItems;
    }

    // Load all CMS portfolio items
    const cmsItems: any[] = [];
    
    for (const file of files) {
      try {
        const filePath = path.join(portfolioPath, file);
        const data = JSON.parse(fs.readFileSync(filePath, 'utf-8'));
        
        if (!data.slug) {
          console.warn(`Skipping ${file}: missing slug`);
          continue;
        }
        
        cmsItems.push({
          slug: data.slug,
          title: data.en?.title || data.title || file.replace('.json', ''),
          description: data.en?.description || data.description || '',
          thumbnail: data.thumbnail || '',
          gallery: data.gallery || [],
          order: data.order || 999
        });
      } catch (err) {
        console.warn(`Failed to parse ${file}:`, err);
      }
    }

    if (cmsItems.length === 0) {
      console.log('No valid CMS items found, using hardcoded data');
      return hardcodedItems;
    }

    // Sort by order and remove order field
    const sortedItems = cmsItems
      .sort((a, b) => a.order - b.order)
      .map(({ order, ...item }) => item as PortfolioItem);

    console.log(`Loaded ${sortedItems.length} portfolio items from CMS`);
    return sortedItems;
  } catch (err) {
    console.error('Error loading portfolio items from CMS:', err);
    return hardcodedItems;
  }
}
