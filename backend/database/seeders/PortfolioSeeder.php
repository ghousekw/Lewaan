<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $portfolioData = $this->getPortfolioData();

        foreach ($portfolioData as $index => $item) {
            echo "Creating portfolio: {$item['title_en']}...\n";
            
            $portfolio = Portfolio::create([
                'slug' => $item['slug'],
                'order' => $index + 1,
                'featured' => in_array($item['slug'], ['reception', 'master-bedrooms', 'dining-hall']),
                'status' => 'published',
                'title_en' => $item['title_en'],
                'description_en' => $item['description_en'],
                'title_ar' => $item['title_ar'],
                'description_ar' => $item['description_ar'],
                'categories' => $item['categories'],
                'tags' => [],
            ]);

            // Add thumbnail
            $this->addMediaFromPublic($portfolio, $item['thumbnail'], 'thumbnail');

            // Add gallery images
            foreach ($item['gallery'] as $galleryItem) {
                $this->addMediaFromPublic($portfolio, $galleryItem, 'gallery');
            }

            echo "✓ Created {$item['title_en']} with " . count($item['gallery']) . " images\n";
        }

        echo "\n✅ Successfully imported " . count($portfolioData) . " portfolio projects!\n";
    }

    /**
     * Add media from public directory
     */
    private function addMediaFromPublic($portfolio, $imagePath, $collection)
    {
        // Remove leading slash
        $imagePath = ltrim($imagePath, '/');
        
        // Full path to the image in public directory
        $publicPath = public_path($imagePath);
        
        // Check if file exists
        if (!File::exists($publicPath)) {
            echo "  ⚠ Warning: Image not found: {$imagePath}\n";
            return;
        }

        try {
            $portfolio->addMedia($publicPath)
                ->preservingOriginal()
                ->toMediaCollection($collection);
        } catch (\Exception $e) {
            echo "  ⚠ Error adding image {$imagePath}: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Portfolio data array
     */
    private function getPortfolioData(): array
    {
        return [
            [
                'slug' => 'reception',
                'title_en' => 'Reception',
                'description_en' => 'A welcoming and elegant reception area designed to make a lasting first impression.',
                'title_ar' => 'الاستقبال',
                'description_ar' => 'منطقة استقبال مرحبة وأنيقة مصممة لترك انطباع أول دائم.',
                'categories' => ['entrance'],
                'thumbnail' => '/Reception/reception & living (2).webp',
                'gallery' => [
                    '/Reception/reception & living (2).webp',
                    '/Reception/reception & living (3).webp',
                    '/Reception/reception & living (4).webp',
                    '/Reception/reception & living (5).webp',
                    '/Reception/reception & living (6).webp',
                    '/Reception/reception & living (7).webp',
                    '/Reception/reception & living (8).webp',
                    '/Reception/reception & living (9).webp',
                    '/Reception/reception & living (10).webp',
                    '/Reception/reception & living (11).webp',
                    '/Reception/reception & living (12).webp',
                    '/Reception/reception & living (13).webp',
                    '/Reception/reception & living (14).webp',
                    '/Reception/reception & living (15).webp',
                    '/Reception/reception & living (16).webp',
                    '/Reception/reception & living (17).webp',
                    '/Reception/reception & living (18).webp',
                    '/Reception/reception & living (19).webp',
                    '/Reception/reception & living (20).webp',
                    '/Reception/reception & living (21).webp',
                    '/Reception/reception & living (22).webp',
                    '/Reception/reception & living (23).webp',
                    '/Reception/reception & living (24).webp',
                    '/Reception/reception & living (25).webp',
                    '/Reception/reception & living (26).webp',
                    '/Reception/reception & living (27).webp',
                ]
            ],
            [
                'slug' => 'deewaniya-mughallath',
                'title_en' => 'Deewaniya & Mughallath',
                'description_en' => 'Traditional Arabic gathering spaces with modern elegance and cultural authenticity.',
                'title_ar' => 'الديوانية والمغلث',
                'description_ar' => 'مساحات تجمع عربية تقليدية بأناقة حديثة وأصالة ثقافية.',
                'categories' => ['living-room'],
                'thumbnail' => '/Deewaniya & Mughallath/dewania (1).webp',
                'gallery' => [
                    '/Deewaniya & Mughallath/dewania (1).webp',
                    '/Deewaniya & Mughallath/dewania (8).webp',
                    '/Deewaniya & Mughallath/dewania (9).webp',
                    '/Deewaniya & Mughallath/dewania (10).webp',
                    '/Deewaniya & Mughallath/dewania (11).webp',
                    '/Deewaniya & Mughallath/dewania (12).webp',
                    '/Deewaniya & Mughallath/dewania (13).webp',
                    '/Deewaniya & Mughallath/dewania (14).webp',
                ]
            ],
            [
                'slug' => 'living-hall',
                'title_en' => 'Living Hall',
                'description_en' => 'A spacious and comfortable living area designed for family gatherings and relaxation.',
                'title_ar' => 'صالة المعيشة',
                'description_ar' => 'منطقة معيشة واسعة ومريحة مصممة للتجمعات العائلية والاسترخاء.',
                'categories' => ['living-room'],
                'thumbnail' => '/Living Hall/03.Living Hall (1).webp',
                'gallery' => [
                    '/Living Hall/03.Living Hall (1).webp',
                    '/Living Hall/03.Living Hall (2).webp',
                    '/Living Hall/03.Living Hall (3).webp',
                    '/Living Hall/03.Living Hall (4).webp',
                    '/Living Hall/03.Living Hall (5).webp',
                    '/Living Hall/03.Living Hall (6).webp',
                    '/Living Hall/03.Living Hall (7).webp',
                    '/Living Hall/03.Living Hall (8).webp',
                    '/Living Hall/03.Living Hall (9).webp',
                    '/Living Hall/03.Living Hall (10).webp',
                    '/Living Hall/03.Living Hall (11).webp',
                ]
            ],
            [
                'slug' => 'dining-hall',
                'title_en' => 'Dining Hall',
                'description_en' => 'An elegant dining space perfect for hosting family meals and special occasions.',
                'title_ar' => 'صالة الطعام',
                'description_ar' => 'مساحة طعام أنيقة مثالية لاستضافة وجبات العائلة والمناسبات الخاصة.',
                'categories' => ['dining'],
                'thumbnail' => '/Dining Hall/04.Dining Hall (2).webp',
                'gallery' => [
                    '/Dining Hall/dining (1).webp',
                    '/Dining Hall/04.Dining Hall (2).webp',
                    '/Dining Hall/04.Dining Hall (3).webp',
                    '/Dining Hall/04.Dining Hall (4).webp',
                    '/Dining Hall/dining (5).webp',
                    '/Dining Hall/dining (6).webp',
                    '/Dining Hall/04.Dining Hall (7).webp',
                    '/Dining Hall/dining (7).webp',
                    '/Dining Hall/dining (8).webp',
                    '/Dining Hall/04.Dining Hall (8).webp',
                    '/Dining Hall/04.Dining Hall (9).webp',
                    '/Dining Hall/04.Dining Hall (10).webp',
                    '/Dining Hall/04.Dining Hall (11).webp',
                    '/Dining Hall/04.Dining Hall (12).webp',
                    '/Dining Hall/04.Dining Hall (13).webp',
                    '/Dining Hall/04.Dining Hall (14).webp',
                    '/Dining Hall/04.Dining Hall (15).webp',
                    '/Dining Hall/04.Dining Hall (16).webp',
                    '/Dining Hall/04.Dining Hall (17).webp',
                    '/Dining Hall/04.Dining Hall (18).webp',
                    '/Dining Hall/04.Dining Hall (19).webp',
                    '/Dining Hall/04.Dining Hall (20).webp',
                    '/Dining Hall/04.Dining Hall (21).webp',
                    '/Dining Hall/04.Dining Hall (22).webp',
                    '/Dining Hall/04.Dining Hall (23).webp',
                    '/Dining Hall/04.Dining Hall (24).webp',
                    '/Dining Hall/04.Dining Hall (25).webp',
                    '/Dining Hall/04.Dining Hall (26).webp',
                    '/Dining Hall/04.Dining Hall (27).webp',
                    '/Dining Hall/04.Dining Hall (28).webp',
                ]
            ],
            [
                'slug' => 'master-bedrooms',
                'title_en' => 'Master Bedrooms',
                'description_en' => 'Luxurious master bedrooms designed for ultimate comfort and relaxation.',
                'title_ar' => 'غرف النوم الرئيسية',
                'description_ar' => 'غرف نوم رئيسية فاخرة مصممة لتوفير أقصى درجات الراحة والاسترخاء.',
                'categories' => ['bedroom'],
                'thumbnail' => '/Master Bedrooms/05.Master Bedrooms (1).webp',
                'gallery' => [
                    '/Master Bedrooms/bedroom (1).webp',
                    '/Master Bedrooms/05.Master Bedrooms (1).webp',
                    '/Master Bedrooms/bedroom (7).webp',
                    '/Master Bedrooms/bedroom (8).webp',
                    '/Master Bedrooms/bedroom (9).webp',
                    '/Master Bedrooms/bedroom (10).webp',
                    '/Master Bedrooms/bedroom (11).webp',
                    '/Master Bedrooms/bedroom (12).webp',
                    '/Master Bedrooms/bedroom (13).webp',
                    '/Master Bedrooms/bedroom (14).webp',
                    '/Master Bedrooms/bedroom (15).webp',
                    '/Master Bedrooms/05.Master Bedrooms (48).webp',
                    '/Master Bedrooms/05.Master Bedrooms (49).webp',
                    '/Master Bedrooms/05.Master Bedrooms (50).webp',
                    '/Master Bedrooms/05.Master Bedrooms (51).webp',
                    '/Master Bedrooms/05.Master Bedrooms (52).webp',
                    '/Master Bedrooms/05.Master Bedrooms (53).webp',
                    '/Master Bedrooms/05.Master Bedrooms (54).webp',
                    '/Master Bedrooms/05.Master Bedrooms (55).webp',
                    '/Master Bedrooms/05.Master Bedrooms (56).webp',
                    '/Master Bedrooms/05.Master Bedrooms (57).webp',
                    '/Master Bedrooms/05.Master Bedrooms (58).webp',
                    '/Master Bedrooms/05.Master Bedrooms (59).webp',
                    '/Master Bedrooms/05.Master Bedrooms (60).webp',
                    '/Master Bedrooms/05.Master Bedrooms (61).webp',
                    '/Master Bedrooms/05.Master Bedrooms (62).webp',
                    '/Master Bedrooms/05.Master Bedrooms (63).webp',
                    '/Master Bedrooms/05.Master Bedrooms (64).webp',
                    '/Master Bedrooms/05.Master Bedrooms (65).webp',
                    '/Master Bedrooms/05.Master Bedrooms (66).webp',
                    '/Master Bedrooms/05.Master Bedrooms (67).webp',
                    '/Master Bedrooms/05.Master Bedrooms (68).webp',
                    '/Master Bedrooms/05.Master Bedrooms (70).webp',
                    '/Master Bedrooms/05.Master Bedrooms (71).webp',
                    '/Master Bedrooms/05.Master Bedrooms (72).webp',
                    '/Master Bedrooms/05.Master Bedrooms (73).webp',
                    '/Master Bedrooms/05.Master Bedrooms (74).webp',
                    '/Master Bedrooms/05.Master Bedrooms (75).webp',
                    '/Master Bedrooms/05.Master Bedrooms (76).webp',
                ]
            ],
            [
                'slug' => 'child-room',
                'title_en' => 'Child Room',
                'description_en' => 'Playful and imaginative spaces designed to inspire creativity and fun.',
                'title_ar' => 'غرفة الأطفال',
                'description_ar' => 'مساحات مرحة وخيالية مصممة لإلهام الإبداع والمرح.',
                'categories' => ['kids'],
                'thumbnail' => '/Child Room/06.Child Room (1).webp',
                'gallery' => [
                    '/Child Room/06.Child Room (1).webp',
                    '/Child Room/06.Child Room (2).webp',
                    '/Child Room/06.Child Room (3).webp',
                    '/Child Room/06.Child Room (4).webp',
                    '/Child Room/06.Child Room (5).webp',
                    '/Child Room/06.Child Room (6).webp',
                    '/Child Room/06.Child Room (7).webp',
                    '/Child Room/06.Child Room (8).webp',
                    '/Child Room/06.Child Room (9).webp',
                    '/Child Room/06.Child Room (10).webp',
                    '/Child Room/06.Child Room (11).webp',
                    '/Child Room/06.Child Room (12).webp',
                ]
            ],
            [
                'slug' => 'wash-bathroom',
                'title_en' => 'Wash & Bathroom',
                'description_en' => 'Spa-like bathrooms combining luxury, functionality, and modern design.',
                'title_ar' => 'الحمامات',
                'description_ar' => 'حمامات تشبه السبا تجمع بين الفخامة والوظيفة والتصميم الحديث.',
                'categories' => ['bathroom'],
                'thumbnail' => '/Wash & Bathrooms/07.Wash & Bathrooms (270).webp',
                'gallery' => [
                    '/Wash & Bathrooms/07.Wash & Bathrooms (270).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (271).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (272).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (273).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (274).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (275).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (276).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (277).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (278).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (279).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (280).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (281).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (282).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (283).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (284).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (285).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (286).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (287).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (288).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (289).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (290).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (291).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (292).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (293).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (294).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (295).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (296).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (297).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (298).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (299).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (300).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (301).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (302).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (303).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (304).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (305).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (306).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (307).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (308).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (309).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (310).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (311).webp',
                    '/Wash & Bathrooms/07.Wash & Bathrooms (312).webp',
                ]
            ],
            [
                'slug' => 'dressing-room',
                'title_en' => 'Dressing Room',
                'description_en' => 'Elegant and organized dressing rooms with custom storage solutions.',
                'title_ar' => 'غرفة الملابس',
                'description_ar' => 'غرف ملابس أنيقة ومنظمة مع حلول تخزين مخصصة.',
                'categories' => ['bedroom'],
                'thumbnail' => '/Dressing Room/08.Dressing Room (33).webp',
                'gallery' => [
                    '/Dressing Room/08.Dressing Room (33).webp',
                    '/Dressing Room/08.Dressing Room (34).webp',
                    '/Dressing Room/08.Dressing Room (35).webp',
                    '/Dressing Room/08.Dressing Room (36).webp',
                    '/Dressing Room/08.Dressing Room (37).webp',
                    '/Dressing Room/08.Dressing Room (38).webp',
                    '/Dressing Room/08.Dressing Room (39).webp',
                    '/Dressing Room/08.Dressing Room (40).webp',
                    '/Dressing Room/08.Dressing Room (41).webp',
                    '/Dressing Room/08.Dressing Room (42).webp',
                    '/Dressing Room/08.Dressing Room (43).webp',
                    '/Dressing Room/08.Dressing Room (44).webp',
                    '/Dressing Room/08.Dressing Room (45).webp',
                    '/Dressing Room/08.Dressing Room (46).webp',
                    '/Dressing Room/08.Dressing Room (47).webp',
                    '/Dressing Room/08.Dressing Room (48).webp',
                    '/Dressing Room/08.Dressing Room (49).webp',
                    '/Dressing Room/08.Dressing Room (50).webp',
                    '/Dressing Room/08.Dressing Room (51).webp',
                    '/Dressing Room/08.Dressing Room (52).webp',
                    '/Dressing Room/08.Dressing Room (53).webp',
                    '/Dressing Room/08.Dressing Room (54).webp',
                    '/Dressing Room/08.Dressing Room (55).webp',
                    '/Dressing Room/08.Dressing Room (56).webp',
                    '/Dressing Room/08.Dressing Room (57).webp',
                    '/Dressing Room/08.Dressing Room (58).webp',
                    '/Dressing Room/08.Dressing Room (59).webp',
                    '/Dressing Room/08.Dressing Room (60).webp',
                    '/Dressing Room/08.Dressing Room (61).webp',
                    '/Dressing Room/08.Dressing Room (62).webp',
                    '/Dressing Room/08.Dressing Room (63).webp',
                    '/Dressing Room/08.Dressing Room (64).webp',
                    '/Dressing Room/08.Dressing Room (65).webp',
                    '/Dressing Room/08.Dressing Room (73).webp',
                    '/Dressing Room/08.Dressing Room (74).webp',
                    '/Dressing Room/08.Dressing Room (75).webp',
                    '/Dressing Room/08.Dressing Room (76).webp',
                    '/Dressing Room/08.Dressing Room (77).webp',
                ]
            ],
            [
                'slug' => 'cinema-hall',
                'title_en' => 'Cinema Hall',
                'description_en' => 'State-of-the-art home theaters for the ultimate entertainment experience.',
                'title_ar' => 'صالة السينما',
                'description_ar' => 'صالات سينما منزلية حديثة لتجربة ترفيهية مثالية.',
                'categories' => ['entertainment'],
                'thumbnail' => '/Cinema Hall/Cinema Hall (1).webp',
                'gallery' => [
                    '/Cinema Hall/Cinema Hall (1).webp',
                    '/Cinema Hall/Cinema Hall (2).webp',
                    '/Cinema Hall/Cinema Hall (3).webp',
                    '/Cinema Hall/Cinema Hall (4).webp',
                ]
            ],
            [
                'slug' => 'corridors',
                'title_en' => 'Corridors',
                'description_en' => 'Beautifully designed corridors that seamlessly connect spaces throughout the home.',
                'title_ar' => 'الممرات',
                'description_ar' => 'ممرات مصممة بشكل جميل تربط المساحات في جميع أنحاء المنزل بسلاسة.',
                'categories' => ['entrance'],
                'thumbnail' => '/Corridors/Corridors (17).webp',
                'gallery' => [
                    '/Corridors/Corridors (17).webp',
                    '/Corridors/Corridors (18).webp',
                    '/Corridors/Corridors (19).webp',
                    '/Corridors/Corridors (20).webp',
                    '/Corridors/Corridors (21).webp',
                    '/Corridors/Corridors (22).webp',
                    '/Corridors/Corridors (23).webp',
                    '/Corridors/Corridors (24).webp',
                    '/Corridors/Corridors (25).webp',
                    '/Corridors/Corridors (26).webp',
                    '/Corridors/Corridors (27).webp',
                    '/Corridors/Corridors (28).webp',
                    '/Corridors/Corridors (29).webp',
                    '/Corridors/Corridors (30).webp',
                    '/Corridors/Corridors (31).webp',
                    '/Corridors/Corridors (32).webp',
                    '/Corridors/Corridors (33).webp',
                    '/Corridors/Corridors (34).webp',
                    '/Corridors/Corridors (35).webp',
                    '/Corridors/Corridors (36).webp',
                    '/Corridors/Corridors (37).webp',
                    '/Corridors/Corridors (43).webp',
                    '/Corridors/Corridors (44).webp',
                    '/Corridors/Corridors (45).webp',
                    '/Corridors/Corridors (46).webp',
                    '/Corridors/Corridors (47).webp',
                ]
            ],
            [
                'slug' => 'kitchen',
                'title_en' => 'Kitchen, Pantry & Buffet',
                'description_en' => 'Modern kitchens designed for both functionality and aesthetic appeal.',
                'title_ar' => 'المطبخ والمخزن والبوفيه',
                'description_ar' => 'مطابخ حديثة مصممة للوظيفة والجاذبية الجمالية.',
                'categories' => ['kitchen'],
                'thumbnail' => '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (1).webp',
                'gallery' => [
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (1).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (2).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (3).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (4).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (5).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (6).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (7).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (8).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (9).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (10).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (11).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (12).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (13).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (14).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (15).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (16).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (20).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (21).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (22).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (23).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (24).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (25).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (26).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (27).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (28).webp',
                    '/Kitchen,Pantry & Buffet/Kitchen,Pantry & Buffet (29).webp',
                ]
            ],
            [
                'slug' => 'office',
                'title_en' => 'Office',
                'description_en' => 'Professional and inspiring home office spaces designed for productivity.',
                'title_ar' => 'المكتب',
                'description_ar' => 'مساحات مكتبية منزلية احترافية وملهمة مصممة للإنتاجية.',
                'categories' => ['office'],
                'thumbnail' => '/Office/Office (1).webp',
                'gallery' => [
                    '/Office/Office (1).webp',
                    '/Office/Office (2).webp',
                    '/Office/Office (3).webp',
                    '/Office/Office (4).webp',
                    '/Office/Office (5).webp',
                    '/Office/Office (6).webp',
                    '/Office/Office (7).webp',
                    '/Office/Office (8).webp',
                    '/Office/Office (9).webp',
                    '/Office/Office (10).webp',
                ]
            ],
            [
                'slug' => 'playroom',
                'title_en' => 'PlayRoom',
                'description_en' => 'Fun and safe playrooms designed to encourage creativity and active play.',
                'title_ar' => 'غرفة اللعب',
                'description_ar' => 'غرف لعب ممتعة وآمنة مصممة لتشجيع الإبداع واللعب النشط.',
                'categories' => ['kids'],
                'thumbnail' => '/Play Room/Play Room (1).webp',
                'gallery' => [
                    '/Play Room/Play Room (1).webp',
                    '/Play Room/Play Room (2).webp',
                    '/Play Room/Play Room (3).webp',
                    '/Play Room/Play Room (4).webp',
                ]
            ],
            [
                'slug' => 'staircase',
                'title_en' => 'StairCase',
                'description_en' => 'Stunning staircases that serve as architectural focal points.',
                'title_ar' => 'الدرج',
                'description_ar' => 'سلالم مذهلة تعمل كنقاط محورية معمارية.',
                'categories' => ['staircase'],
                'thumbnail' => '/Staircase/Staircase (1).webp',
                'gallery' => [
                    '/Staircase/Staircase (1).webp',
                    '/Staircase/Staircase (2).webp',
                    '/Staircase/Staircase (3).webp',
                    '/Staircase/Staircase (4).webp',
                    '/Staircase/Staircase (5).webp',
                    '/Staircase/Staircase (6).webp',
                    '/Staircase/Staircase (7).webp',
                    '/Staircase/Staircase (8).webp',
                    '/Staircase/Staircase (9).webp',
                    '/Staircase/Staircase (10).webp',
                    '/Staircase/Staircase (11).webp',
                    '/Staircase/Staircase (12).webp',
                    '/Staircase/Staircase (13).webp',
                    '/Staircase/Staircase (14).webp',
                    '/Staircase/Staircase (15).webp',
                    '/Staircase/Staircase (16).webp',
                    '/Staircase/Staircase (17).webp',
                    '/Staircase/Staircase (18).webp',
                    '/Staircase/Staircase (19).webp',
                    '/Staircase/Staircase (20).webp',
                    '/Staircase/Staircase (21).webp',
                    '/Staircase/Staircase (22).webp',
                    '/Staircase/Staircase (23).webp',
                    '/Staircase/Staircase (24).webp',
                    '/Staircase/Staircase (25).webp',
                    '/Staircase/Staircase (26).webp',
                    '/Staircase/Staircase (27).webp',
                    '/Staircase/Staircase (28).webp',
                    '/Staircase/Staircase (29).webp',
                    '/Staircase/Staircase (30).webp',
                    '/Staircase/Staircase (31).webp',
                    '/Staircase/Staircase (32).webp',
                    '/Staircase/Staircase (33).webp',
                    '/Staircase/Staircase (34).webp',
                    '/Staircase/Staircase (35).webp',
                    '/Staircase/Staircase (36).webp',
                    '/Staircase/Staircase (37).webp',
                    '/Staircase/Staircase (38).webp',
                    '/Staircase/Staircase (39).webp',
                ]
            ],
        ];
    }
}
