// Prisma 7 config file
// DATABASE_URL must be provided by environment variables (Railway, Docker, etc.)

import 'dotenv/config';

if (!process.env.DATABASE_URL) {
  console.error('❌ ERROR: DATABASE_URL environment variable is not set!');
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
