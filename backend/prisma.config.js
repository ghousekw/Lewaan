// Prisma 7 config file for migrations
// DATABASE_URL is provided by environment variables (Railway, Docker, etc.)

// Load environment variables if .env file exists (for local development)
try {
  require('dotenv').config();
} catch (e) {
  // dotenv not available or .env not found - use environment variables directly
}

// Get DATABASE_URL from environment
// In production (Railway/Docker), this is set by the platform
// In local development, it's loaded from .env file
const databaseUrl = process.env.DATABASE_URL;

// Validate that DATABASE_URL is set and not a dummy value
if (!databaseUrl || databaseUrl.includes('dummy')) {
  throw new Error(
    'DATABASE_URL environment variable is required and must be a valid database connection string. ' +
    'Please ensure DATABASE_URL is set in your environment variables.'
  );
}

module.exports = {
  datasource: {
    url: databaseUrl,
  },
};
