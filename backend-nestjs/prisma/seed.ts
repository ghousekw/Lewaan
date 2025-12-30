import { PrismaClient, Status } from '@prisma/client';

const prisma = new PrismaClient();

const portfolioData = [
  {
    slug: 'reception',
    order: 1,
    featured: true,
    status: Status.published,
    titleEn: 'Reception',
    descriptionEn: 'A welcoming and elegant reception area designed to make a lasting first impression.',
    titleAr: 'الاستقبال',
    descriptionAr: 'منطقة استقبال مرحبة وأنيقة مصممة لترك انطباع أول دائم.',
    categories: ['entrance'],
    tags: [],
    thumbnail: {
      url: 'https://res.cloudinary.com/daz1c9aum/image/upload/v1735527600/reception-living-2.webp',
      thumbUrl: 'https://res.cloudinary.com/daz1c9aum/image/upload/w_400,h_300,c_fill/v1735527600/reception-living-2.webp',
    },
    gallery: [
      { url: 'https://res.cloudinary.com/daz1c9aum/image/upload/v1735527600/reception-living-2.webp', alt: { en: 'Reception area', ar: 'منطقة الاستقبال' } },
      { url: 'https://res.cloudinary.com/daz1c9aum/image/upload/v1735527600/reception-living-3.webp', alt: { en: 'Reception area', ar: 'منطقة الاستقبال' } },
    ],
  },
  {
    slug: 'master-bedrooms',
    order: 2,
    featured: true,
    status: Status.published,
    titleEn: 'Master Bedrooms',
    descriptionEn: 'Luxurious master bedrooms designed for ultimate comfort and relaxation.',
    titleAr: 'غرف النوم الرئيسية',
    descriptionAr: 'غرف نوم رئيسية فاخرة مصممة لتوفير أقصى درجات الراحة والاسترخاء.',
    categories: ['bedroom'],
    tags: [],
    thumbnail: {
      url: 'https://res.cloudinary.com/daz1c9aum/image/upload/v1735527600/master-bedroom-1.webp',
      thumbUrl: 'https://res.cloudinary.com/daz1c9aum/image/upload/w_400,h_300,c_fill/v1735527600/master-bedroom-1.webp',
    },
    gallery: [
      { url: 'https://res.cloudinary.com/daz1c9aum/image/upload/v1735527600/master-bedroom-1.webp', alt: { en: 'Master bedroom', ar: 'غرفة النوم الرئيسية' } },
    ],
  },
  {
    slug: 'dining-hall',
    order: 3,
    featured: true,
    status: Status.published,
    titleEn: 'Dining Hall',
    descriptionEn: 'An elegant dining space perfect for hosting family meals and special occasions.',
    titleAr: 'صالة الطعام',
    descriptionAr: 'مساحة طعام أنيقة مثالية لاستضافة وجبات العائلة والمناسبات الخاصة.',
    categories: ['dining'],
    tags: [],
    thumbnail: {
      url: 'https://res.cloudinary.com/daz1c9aum/image/upload/v1735527600/dining-hall-2.webp',
      thumbUrl: 'https://res.cloudinary.com/daz1c9aum/image/upload/w_400,h_300,c_fill/v1735527600/dining-hall-2.webp',
    },
    gallery: [
      { url: 'https://res.cloudinary.com/daz1c9aum/image/upload/v1735527600/dining-hall-2.webp', alt: { en: 'Dining hall', ar: 'صالة الطعام' } },
    ],
  },
  {
    slug: 'living-hall',
    order: 4,
    featured: false,
    status: Status.published,
    titleEn: 'Living Hall',
    descriptionEn: 'A spacious and comfortable living area designed for family gatherings and relaxation.',
    titleAr: 'صالة المعيشة',
    descriptionAr: 'منطقة معيشة واسعة ومريحة مصممة للتجمعات العائلية والاسترخاء.',
    categories: ['living-room'],
    tags: [],
  },
  {
    slug: 'kitchen',
    order: 5,
    featured: false,
    status: Status.published,
    titleEn: 'Kitchen, Pantry & Buffet',
    descriptionEn: 'Modern kitchens designed for both functionality and aesthetic appeal.',
    titleAr: 'المطبخ والمخزن والبوفيه',
    descriptionAr: 'مطابخ حديثة مصممة للوظيفة والجاذبية الجمالية.',
    categories: ['kitchen'],
    tags: [],
  },
];

async function main() {
  console.log('🌱 Seeding database...');

  for (const data of portfolioData) {
    const portfolio = await prisma.portfolio.create({
      data,
    });
    console.log(`✅ Created portfolio: ${portfolio.titleEn}`);
  }

  console.log('✅ Seeding complete!');
}

main()
  .catch((e) => {
    console.error('❌ Seeding failed:', e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
