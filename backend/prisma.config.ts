// Prisma 7 config file
// DATABASE_URL must be provided by environment variables (Railway, Docker, etc.)

// Only load dotenv in development (Railway injects env vars directly)
if (process.env.NODE_ENV !== 'production') {
  require('dotenv/config');
}

if (!process.env.DATABASE_URL) {
  console.error('❌ ERROR: DATABASE_URL environment variable is not set!');
  console.error('Current NODE_ENV:', process.env.NODE_ENV);
  console.error('Available env vars:', Object.keys(process.env).filter(k => k.includes('DATA')));
  console.error('');
  console.error('For Railway deployment:');
  console.error('1. Go to your Railway project');
  console.error('2. Click on your backend service');
  console.error('3. Go to Variables tab');
  console.error('4. Add: DATABASE_URL=${{Postgres.DATABASE_URL}}');
  console.error('');
  console.error('Make sure your PostgreSQL service is running and linked to this service.');
}

export default {
  datasource: {
    url: process.env.DATABASE_URL || 'postgresql://dummy:dummy@dummy:5432/dummy',
  },
};
