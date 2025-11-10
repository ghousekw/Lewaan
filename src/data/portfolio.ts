export interface PortfolioItem {
  slug: string;
  title: string;
  description: string;
  thumbnail: string;
  gallery: Array<{
    type: 'image' | 'video';
    src: string;
    alt?: string;
    thumbnail?: string;
  }>;
}

export const portfolioItems: PortfolioItem[] = [
  {
    slug: 'reception',
    title: 'Reception',
    description: 'A welcoming and elegant reception area designed to make a lasting first impression.',
    thumbnail: '/Reception/reception & living (2).webp',
    gallery: [
      { type: 'image', src: '/Reception/reception & living (2).webp', alt: 'Reception Area View 1' },
      { type: 'image', src: '/Reception/reception & living (3).webp', alt: 'Reception Area View 2' },
      { type: 'image', src: '/Reception/reception & living (4).webp', alt: 'Reception Area View 3' },
      { type: 'image', src: '/Reception/reception & living (5).webp', alt: 'Reception Area View 4' },
      { type: 'image', src: '/Reception/reception & living (6).webp', alt: 'Reception Area View 5' },
      { type: 'image', src: '/Reception/reception & living (7).webp', alt: 'Reception Area View 6' },
      { type: 'image', src: '/Reception/reception & living (8).webp', alt: 'Reception Area View 7' },
      { type: 'image', src: '/Reception/reception & living (9).webp', alt: 'Reception Area View 8' },
      { type: 'image', src: '/Reception/reception & living (10).webp', alt: 'Reception Area View 9' },
      { type: 'image', src: '/Reception/reception & living (11).webp', alt: 'Reception Area View 10' },
      { type: 'image', src: '/Reception/reception & living (12).webp', alt: 'Reception Area View 11' },
      { type: 'image', src: '/Reception/reception & living (13).webp', alt: 'Reception Area View 12' },
      { type: 'image', src: '/Reception/reception & living (14).webp', alt: 'Reception Area View 13' },
      { type: 'image', src: '/Reception/reception & living (15).webp', alt: 'Reception Area View 14' },
      { type: 'image', src: '/Reception/reception & living (16).webp', alt: 'Reception Area View 15' },
      { type: 'image', src: '/Reception/reception & living (17).webp', alt: 'Reception Area View 16' },
      { type: 'image', src: '/Reception/reception & living (18).webp', alt: 'Reception Area View 17' },
      { type: 'image', src: '/Reception/reception & living (19).webp', alt: 'Reception Area View 18' },
      { type: 'image', src: '/Reception/reception & living (20).webp', alt: 'Reception Area View 19' },
      { type: 'image', src: '/Reception/reception & living (21).webp', alt: 'Reception Area View 20' },
      { type: 'image', src: '/Reception/reception & living (22).webp', alt: 'Reception Area View 21' },
      { type: 'image', src: '/Reception/reception & living (23).webp', alt: 'Reception Area View 22' },
      { type: 'image', src: '/Reception/reception & living (24).webp', alt: 'Reception Area View 23' },
      { type: 'image', src: '/Reception/reception & living (25).webp', alt: 'Reception Area View 24' },
      { type: 'image', src: '/Reception/reception & living (26).webp', alt: 'Reception Area View 25' },
      { type: 'image', src: '/Reception/reception & living (27).webp', alt: 'Reception Area View 26' },
    ]
  },
  {
    slug: 'deewaniya-mughallath',
    title: 'Deewaniya & Mughallath',
    description: 'Traditional Arabic gathering spaces with modern elegance and cultural authenticity.',
    thumbnail: 'https://via.placeholder.com/400x300.png?text=Deewaniya',
    gallery: [
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Deewaniya+1', alt: 'Deewaniya View 1' },
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Deewaniya+2', alt: 'Deewaniya View 2' },
      { type: 'video', src: 'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4', thumbnail: 'https://via.placeholder.com/1200x800.png?text=Video+Thumbnail', alt: 'Deewaniya Video Tour' },
    ]
  },
  {
    slug: 'living-hall',
    title: 'Living Hall',
    description: 'A spacious and comfortable living area designed for family gatherings and relaxation.',
    thumbnail: 'https://via.placeholder.com/400x300.png?text=Living+Hall',
    gallery: [
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Living+Hall+1', alt: 'Living Hall View 1' },
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Living+Hall+2', alt: 'Living Hall View 2' },
    ]
  },
  {
    slug: 'dining-hall',
    title: 'Dining Hall',
    description: 'An elegant dining space perfect for hosting family meals and special occasions.',
    thumbnail: 'https://via.placeholder.com/400x300.png?text=Dining+Hall',
    gallery: [
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Dining+Hall+1', alt: 'Dining Hall View 1' },
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Dining+Hall+2', alt: 'Dining Hall View 2' },
    ]
  },
  {
    slug: 'master-bedrooms',
    title: 'Master Bedrooms',
    description: 'Luxurious master bedrooms designed for ultimate comfort and relaxation.',
    thumbnail: 'https://via.placeholder.com/400x300.png?text=Master+Bedroom',
    gallery: [
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Master+Bedroom+1', alt: 'Master Bedroom View 1' },
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Master+Bedroom+2', alt: 'Master Bedroom View 2' },
    ]
  },
  {
    slug: 'child-room',
    title: 'Child Room',
    description: 'Playful and imaginative spaces designed to inspire creativity and fun.',
    thumbnail: 'https://via.placeholder.com/400x300.png?text=Child+Room',
    gallery: [
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Child+Room+1', alt: 'Child Room View 1' },
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Child+Room+2', alt: 'Child Room View 2' },
    ]
  },
  {
    slug: 'wash-bathroom',
    title: 'Wash & Bathroom',
    description: 'Spa-like bathrooms combining luxury, functionality, and modern design.',
    thumbnail: 'https://via.placeholder.com/400x300.png?text=Bathroom',
    gallery: [
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Bathroom+1', alt: 'Bathroom View 1' },
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Bathroom+2', alt: 'Bathroom View 2' },
    ]
  },
  {
    slug: 'dressing-room',
    title: 'Dressing Room',
    description: 'Elegant and organized dressing rooms with custom storage solutions.',
    thumbnail: 'https://via.placeholder.com/400x300.png?text=Dressing+Room',
    gallery: [
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Dressing+Room+1', alt: 'Dressing Room View 1' },
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Dressing+Room+2', alt: 'Dressing Room View 2' },
    ]
  },
  {
    slug: 'cinema-hall',
    title: 'Cinema Hall',
    description: 'State-of-the-art home theaters for the ultimate entertainment experience.',
    thumbnail: 'https://via.placeholder.com/400x300.png?text=Cinema+Hall',
    gallery: [
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Cinema+Hall+1', alt: 'Cinema Hall View 1' },
      { type: 'video', src: 'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4', thumbnail: 'https://via.placeholder.com/1200x800.png?text=Video+Thumbnail', alt: 'Cinema Hall Video' },
    ]
  },
  {
    slug: 'corridors',
    title: 'Corridors',
    description: 'Beautifully designed corridors that seamlessly connect spaces throughout the home.',
    thumbnail: 'https://via.placeholder.com/400x300.png?text=Corridors',
    gallery: [
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Corridors+1', alt: 'Corridors View 1' },
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Corridors+2', alt: 'Corridors View 2' },
    ]
  },
  {
    slug: 'kitchen',
    title: 'Kitchen',
    description: 'Modern kitchens designed for both functionality and aesthetic appeal.',
    thumbnail: 'https://via.placeholder.com/400x300.png?text=Kitchen',
    gallery: [
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Kitchen+1', alt: 'Kitchen View 1' },
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Kitchen+2', alt: 'Kitchen View 2' },
    ]
  },
  {
    slug: 'pantry-buffet',
    title: 'Pantry & Buffet',
    description: 'Well-organized pantry and buffet areas for efficient storage and serving.',
    thumbnail: 'https://via.placeholder.com/400x300.png?text=Pantry',
    gallery: [
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Pantry+1', alt: 'Pantry View 1' },
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Pantry+2', alt: 'Pantry View 2' },
    ]
  },
  {
    slug: 'office',
    title: 'Office',
    description: 'Professional and inspiring home office spaces designed for productivity.',
    thumbnail: 'https://via.placeholder.com/400x300.png?text=Office',
    gallery: [
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Office+1', alt: 'Office View 1' },
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=Office+2', alt: 'Office View 2' },
    ]
  },
  {
    slug: 'playroom',
    title: 'PlayRoom',
    description: 'Fun and safe playrooms designed to encourage creativity and active play.',
    thumbnail: 'https://via.placeholder.com/400x300.png?text=PlayRoom',
    gallery: [
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=PlayRoom+1', alt: 'PlayRoom View 1' },
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=PlayRoom+2', alt: 'PlayRoom View 2' },
    ]
  },
  {
    slug: 'staircase',
    title: 'StairCase',
    description: 'Stunning staircases that serve as architectural focal points.',
    thumbnail: 'https://via.placeholder.com/400x300.png?text=StairCase',
    gallery: [
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=StairCase+1', alt: 'StairCase View 1' },
      { type: 'image', src: 'https://via.placeholder.com/1200x800.png?text=StairCase+2', alt: 'StairCase View 2' },
    ]
  },
];

