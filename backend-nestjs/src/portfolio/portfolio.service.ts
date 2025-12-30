import { Injectable, NotFoundException } from '@nestjs/common';
import { PrismaService } from '../prisma/prisma.service';
import { CloudinaryService } from '../cloudinary/cloudinary.service';

@Injectable()
export class PortfolioService {
  constructor(
    private prisma: PrismaService,
    private cloudinary: CloudinaryService,
  ) {}

  async findAll(filters?: { category?: string; featured?: boolean }) {
    const where: any = {
      status: 'published',
      deletedAt: null,
    };

    if (filters?.category) {
      where.categories = {
        path: '$',
        array_contains: filters.category,
      };
    }

    if (filters?.featured !== undefined) {
      where.featured = filters.featured;
    }

    const portfolios = await this.prisma.portfolio.findMany({
      where,
      orderBy: { order: 'asc' },
    });

    return portfolios.map(p => this.formatPortfolio(p, false));
  }

  async findBySlug(slug: string) {
    const portfolio = await this.prisma.portfolio.findFirst({
      where: {
        slug,
        status: 'published',
        deletedAt: null,
      },
    });

    if (!portfolio) {
      throw new NotFoundException(`Portfolio with slug "${slug}" not found`);
    }

    return this.formatPortfolio(portfolio, true);
  }

  private formatPortfolio(portfolio: any, includeGallery: boolean) {
    const thumbnail = portfolio.thumbnail as any;
    const gallery = portfolio.gallery as any[];

    const data: any = {
      slug: portfolio.slug,
      order: portfolio.order,
      featured: portfolio.featured,
      thumbnail: thumbnail?.url || null,
      thumbnail_thumb: thumbnail?.url ? this.cloudinary.getThumbUrl(thumbnail.url) : null,
      en: {
        title: portfolio.titleEn,
        description: portfolio.descriptionEn,
        full_description: portfolio.fullDescriptionEn,
        details: portfolio.detailsEn,
      },
      ar: {
        title: portfolio.titleAr,
        description: portfolio.descriptionAr,
        full_description: portfolio.fullDescriptionAr,
        details: portfolio.detailsAr,
      },
      categories: portfolio.categories || [],
      tags: portfolio.tags || [],
      image_count: gallery?.length || 0,
    };

    if (includeGallery && gallery) {
      data.gallery = gallery.map(img => ({
        type: 'image',
        src: this.cloudinary.getLargeUrl(img.url),
        thumb: this.cloudinary.getThumbUrl(img.url),
        original: img.url,
        alt: img.alt || { en: 'Project image', ar: 'صورة المشروع' },
      }));
    }

    return data;
  }
}
