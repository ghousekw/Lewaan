FROM node:20-alpine AS builder

WORKDIR /app

# Install OpenSSL for Prisma
RUN apk add --no-cache openssl

# Copy package files
COPY package*.json ./
COPY prisma ./prisma/
COPY prisma.config.js ./

# Install dependencies
RUN npm ci

# Generate Prisma Client with dummy DATABASE_URL (only for code generation)
ENV DATABASE_URL="postgresql://dummy:dummy@dummy:5432/dummy"
RUN npx prisma generate

# Copy source code
COPY . .

# Build application
RUN npm run build

# Production stage
FROM node:20-alpine

WORKDIR /app

# Install OpenSSL for Prisma
RUN apk add --no-cache openssl

# Copy package files
COPY package*.json ./
COPY prisma ./prisma/
COPY prisma.config.js ./

# Install production dependencies only
RUN npm ci --only=production

# Generate Prisma Client with dummy DATABASE_URL (only for code generation)
ENV DATABASE_URL="postgresql://dummy:dummy@dummy:5432/dummy"
RUN npx prisma generate

# Copy built application
COPY --from=builder /app/dist ./dist

# Expose port
EXPOSE 8000

# Note: DATABASE_URL will be provided by Railway at runtime
# The dummy DATABASE_URL is only used during build for Prisma Client generation

# Start application (migrations run here with real DATABASE_URL from Railway)
CMD ["sh", "-c", "npx prisma migrate deploy && node dist/main"]
