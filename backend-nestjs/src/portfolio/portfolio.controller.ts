import { Controller, Get, Param, Query } from '@nestjs/common';
import { PortfolioService } from './portfolio.service';

@Controller('portfolio')
export class PortfolioController {
  constructor(private readonly portfolioService: PortfolioService) {}

  @Get()
  async findAll(
    @Query('category') category?: string,
    @Query('featured') featured?: string,
  ) {
    const filters: any = {};
    
    if (category) {
      filters.category = category;
    }
    
    if (featured !== undefined) {
      filters.featured = featured === 'true' || featured === '1';
    }

    const data = await this.portfolioService.findAll(filters);
    
    return {
      data,
      meta: {
        total: data.length,
      },
    };
  }

  @Get(':slug')
  async findOne(@Param('slug') slug: string) {
    const data = await this.portfolioService.findBySlug(slug);
    
    return {
      data,
    };
  }
}
