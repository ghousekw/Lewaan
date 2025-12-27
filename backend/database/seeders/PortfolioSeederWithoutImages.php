<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Seeder;

class PortfolioSeederWithoutImages extends Seeder
{
    /**
     * Run the database seeds - Creates portfolio entries without images
     * Images can be uploaded later through the Filament admin panel
     */
    public function run(): void
    {
        $portfolioData = $this->getPortfolioData();

        foreach ($portfolioData as $index => $item) {
            echo "Creating portfolio: {$item['title_en']}...\n";
            
            Portfolio::create([
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

            echo "✓ Created {$item['title_en']}\n";
        }

        echo "\n✅ Successfully created " . count($portfolioData) . " portfolio projects!\n";
        echo "📸 You can now upload images through the admin panel at: /admin/portfolios\n";
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
            ],
            [
                'slug' => 'deewaniya-mughallath',
                'title_en' => 'Deewaniya & Mughallath',
                'description_en' => 'Traditional Arabic gathering spaces with modern elegance and cultural authenticity.',
                'title_ar' => 'الديوانية والمغلث',
                'description_ar' => 'مساحات تجمع عربية تقليدية بأناقة حديثة وأصالة ثقافية.',
                'categories' => ['living-room'],
            ],
            [
                'slug' => 'living-hall',
                'title_en' => 'Living Hall',
                'description_en' => 'A spacious and comfortable living area designed for family gatherings and relaxation.',
                'title_ar' => 'صالة المعيشة',
                'description_ar' => 'منطقة معيشة واسعة ومريحة مصممة للتجمعات العائلية والاسترخاء.',
                'categories' => ['living-room'],
            ],
            [
                'slug' => 'dining-hall',
                'title_en' => 'Dining Hall',
                'description_en' => 'An elegant dining space perfect for hosting family meals and special occasions.',
                'title_ar' => 'صالة الطعام',
                'description_ar' => 'مساحة طعام أنيقة مثالية لاستضافة وجبات العائلة والمناسبات الخاصة.',
                'categories' => ['dining'],
            ],
            [
                'slug' => 'master-bedrooms',
                'title_en' => 'Master Bedrooms',
                'description_en' => 'Luxurious master bedrooms designed for ultimate comfort and relaxation.',
                'title_ar' => 'غرف النوم الرئيسية',
                'description_ar' => 'غرف نوم رئيسية فاخرة مصممة لتوفير أقصى درجات الراحة والاسترخاء.',
                'categories' => ['bedroom'],
            ],
            [
                'slug' => 'child-room',
                'title_en' => 'Child Room',
                'description_en' => 'Playful and imaginative spaces designed to inspire creativity and fun.',
                'title_ar' => 'غرفة الأطفال',
                'description_ar' => 'مساحات مرحة وخيالية مصممة لإلهام الإبداع والمرح.',
                'categories' => ['kids'],
            ],
            [
                'slug' => 'wash-bathroom',
                'title_en' => 'Wash & Bathroom',
                'description_en' => 'Spa-like bathrooms combining luxury, functionality, and modern design.',
                'title_ar' => 'الحمامات',
                'description_ar' => 'حمامات تشبه السبا تجمع بين الفخامة والوظيفة والتصميم الحديث.',
                'categories' => ['bathroom'],
            ],
            [
                'slug' => 'dressing-room',
                'title_en' => 'Dressing Room',
                'description_en' => 'Elegant and organized dressing rooms with custom storage solutions.',
                'title_ar' => 'غرفة الملابس',
                'description_ar' => 'غرف ملابس أنيقة ومنظمة مع حلول تخزين مخصصة.',
                'categories' => ['bedroom'],
            ],
            [
                'slug' => 'cinema-hall',
                'title_en' => 'Cinema Hall',
                'description_en' => 'State-of-the-art home theaters for the ultimate entertainment experience.',
                'title_ar' => 'صالة السينما',
                'description_ar' => 'صالات سينما منزلية حديثة لتجربة ترفيهية مثالية.',
                'categories' => ['entertainment'],
            ],
            [
                'slug' => 'corridors',
                'title_en' => 'Corridors',
                'description_en' => 'Beautifully designed corridors that seamlessly connect spaces throughout the home.',
                'title_ar' => 'الممرات',
                'description_ar' => 'ممرات مصممة بشكل جميل تربط المساحات في جميع أنحاء المنزل بسلاسة.',
                'categories' => ['entrance'],
            ],
            [
                'slug' => 'kitchen',
                'title_en' => 'Kitchen, Pantry & Buffet',
                'description_en' => 'Modern kitchens designed for both functionality and aesthetic appeal.',
                'title_ar' => 'المطبخ والمخزن والبوفيه',
                'description_ar' => 'مطابخ حديثة مصممة للوظيفة والجاذبية الجمالية.',
                'categories' => ['kitchen'],
            ],
            [
                'slug' => 'office',
                'title_en' => 'Office',
                'description_en' => 'Professional and inspiring home office spaces designed for productivity.',
                'title_ar' => 'المكتب',
                'description_ar' => 'مساحات مكتبية منزلية احترافية وملهمة مصممة للإنتاجية.',
                'categories' => ['office'],
            ],
            [
                'slug' => 'playroom',
                'title_en' => 'PlayRoom',
                'description_en' => 'Fun and safe playrooms designed to encourage creativity and active play.',
                'title_ar' => 'غرفة اللعب',
                'description_ar' => 'غرف لعب ممتعة وآمنة مصممة لتشجيع الإبداع واللعب النشط.',
                'categories' => ['kids'],
            ],
            [
                'slug' => 'staircase',
                'title_en' => 'StairCase',
                'description_en' => 'Stunning staircases that serve as architectural focal points.',
                'title_ar' => 'الدرج',
                'description_ar' => 'سلالم مذهلة تعمل كنقاط محورية معمارية.',
                'categories' => ['staircase'],
            ],
        ];
    }
}
