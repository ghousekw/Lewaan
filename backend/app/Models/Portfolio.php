<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Portfolio extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'slug',
        'order',
        'featured',
        'status',
        'title_en',
        'description_en',
        'full_description_en',
        'title_ar',
        'description_ar',
        'full_description_ar',
        'details_en',
        'details_ar',
        'categories',
        'tags',
        'meta_title_en',
        'meta_title_ar',
        'meta_description_en',
        'meta_description_ar',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'details_en' => 'array',
        'details_ar' => 'array',
        'categories' => 'array',
        'tags' => 'array',
    ];

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnail')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->width(400)
                    ->height(300)
                    ->sharpen(10);
                
                $this->addMediaConversion('large')
                    ->width(1200)
                    ->height(900)
                    ->sharpen(10);
            });

        $this->addMediaCollection('gallery')
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->width(400)
                    ->height(300)
                    ->sharpen(10);
                
                $this->addMediaConversion('large')
                    ->width(1920)
                    ->height(1080)
                    ->sharpen(10);
            });
    }

    /**
     * Scope for published portfolios
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope for featured portfolios
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope for ordering
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Get image count
     */
    public function getImageCountAttribute(): int
    {
        return $this->getMedia('gallery')->count();
    }
}
