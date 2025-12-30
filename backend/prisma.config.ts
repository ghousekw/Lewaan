// Prisma 7 config file
// DATABASE_URL is provided by environment variables (Railway, Docker, etc.)

import 'dotenv/config';

// Prisma generate doesn't actually connect to the database,
// so it's safe to use whatever DATABASE_URL is provided (even dummy values during build)
// Migrations will validate the connection at runtime when they actually run
export default {
  datasource: {
    url: process.env.DATABASE_URL || 'postgresql://dummy:dummy@dummy:5432/dummy',
  },
};
