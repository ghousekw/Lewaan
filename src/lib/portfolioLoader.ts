/**
 * Portfolio Loader Utility
 * Loads all portfolio items from CMS JSON files
 * Falls back to hardcoded data if CMS files don't exist
 */

import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import { portfolioItems as hardcodedItems } from '../data/portfolio';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const projectRoot = path.resolve(__dirname, '../..');

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
  const portfolioPath = path.join(projectRoot, 'src/content/portfolio');

  try {
    // Check if portfolio directory exists
    if (!fs.existsSync(portfolioPath)) {
      console.log(`[Portfolio Loader] Directory not found at ${portfolioPath}, using hardcoded data`);
      return hardcodedItems;
    }

    // Read all JSON files from portfolio directory
    const files = fs.readdirSync(portfolioPath).filter(file => file.endsWith('.json'));
    
    console.log(`[Portfolio Loader] Found ${files.length} portfolio files in CMS at ${portfolioPath}`);
    
    if (files.length === 0) {
      console.log('[Portfolio Loader] No CMS files found, using hardcoded data');
      return hardcodedItems;
    }

    // Load all CMS portfolio items
    const cmsItems: any[] = [];
    
    for (const file of files) {
      try {
        const filePath = path.join(portfolioPath, file);
        const fileContent = fs.readFileSync(filePath, 'utf-8');
        const data = JSON.parse(fileContent);
        
        if (!data.slug) {
          console.warn(`[Portfolio Loader] Skipping ${file}: missing slug`);
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
        console.log(`[Portfolio Loader] Loaded ${data.slug} from ${file}`);
      } catch (err) {
        console.warn(`[Portfolio Loader] Failed to parse ${file}:`, err instanceof Error ? err.message : String(err));
      }
    }

    if (cmsItems.length === 0) {
      console.log('[Portfolio Loader] No valid CMS items found, using hardcoded data');
      return hardcodedItems;
    }

    // Sort by order and remove order field
    const sortedItems = cmsItems
      .sort((a, b) => a.order - b.order)
      .map(({ order, ...item }) => item as PortfolioItem);

    console.log(`[Portfolio Loader] Successfully loaded ${sortedItems.length} portfolio items from CMS`);
    return sortedItems;
  } catch (err) {
    console.error('[Portfolio Loader] Fatal error:', err instanceof Error ? err.message : String(err));
    return hardcodedItems;
  }
}
