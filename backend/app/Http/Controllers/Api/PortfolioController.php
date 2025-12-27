<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * Get all published portfolios
     */
    public function index(Request $request)
    {
        $query = Portfolio::published()->ordered();
        
        // Filter by category
        if ($request->has('category')) {
            $query->whereJsonContains('categories', $request->category);
        }
        
        // Filter by featured
        if ($request->boolean('featured')) {
            $query->featured();
        }
        
        $portfolios = $query->get()->map(function ($portfolio) {
            return $this->formatPortfolio($portfolio);
        });
        
        return response()->json([
            'data' => $portfolios,
            'meta' => [
                'total' => $portfolios->count(),
            ],
        ]);
    }

    /**
     * Get single portfolio by slug
     */
    public function show($slug)
    {
        $portfolio = Portfolio::where('slug', $slug)
            ->published()
            ->firstOrFail();
        
        return response()->json([
            'data' => $this->formatPortfolio($portfolio, true),
        ]);
    }

    /**
     * Format portfolio data for API response
     */
    private function formatPortfolio(Portfolio $portfolio, $includeGallery = false)
    {
        $data = [
            'slug' => $portfolio->slug,
            'order' => $portfolio->order,
            'featured' => $portfolio->featured,
            'thumbnail' => $portfolio->getFirstMediaUrl('thumbnail', 'large'),
            'thumbnail_thumb' => $portfolio->getFirstMediaUrl('thumbnail', 'thumb'),
            'en' => [
                'title' => $portfolio->title_en,
                'description' => $portfolio->description_en,
                'full_description' => $portfolio->full_description_en,
                'details' => $portfolio->details_en,
            ],
            'ar' => [
                'title' => $portfolio->title_ar,
                'description' => $portfolio->description_ar,
                'full_description' => $portfolio->full_description_ar,
                'details' => $portfolio->details_ar,
            ],
            'categories' => $portfolio->categories,
            'tags' => $portfolio->tags,
            'image_count' => $portfolio->image_count,
        ];
        
        if ($includeGallery) {
            $data['gallery'] = $portfolio->getMedia('gallery')->map(function ($media) {
                return [
                    'type' => 'image',
                    'src' => $media->getUrl('large'),
                    'thumb' => $media->getUrl('thumb'),
                    'original' => $media->getUrl(),
                    'alt' => [
                        'en' => $media->getCustomProperty('alt_en', 'Project image'),
                        'ar' => $media->getCustomProperty('alt_ar', 'صورة المشروع'),
                    ],
                ];
            });
        }
        
        return $data;
    }
}
