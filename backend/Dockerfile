FROM node:20-alpine AS builder

WORKDIR /app

# Install OpenSSL for Prisma
RUN apk add --no-cache openssl

# Copy package files
COPY package*.json ./
COPY prisma ./prisma/
COPY prisma.config.ts ./

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
COPY prisma.config.ts ./

# Install production dependencies only
RUN npm ci --only=production

# Copy built application
COPY --from=builder /app/dist ./dist

# Copy node_modules with generated Prisma Client from builder
COPY --from=builder /app/node_modules/.prisma ./node_modules/.prisma
COPY --from=builder /app/node_modules/@prisma ./node_modules/@prisma

# Expose port
EXPOSE 8000

# Create a startup script that checks DATABASE_URL
RUN echo '#!/bin/sh' > /app/start.sh && \
    echo 'echo "🚀 Starting application..."' >> /app/start.sh && \
    echo 'echo "Checking DATABASE_URL..."' >> /app/start.sh && \
    echo 'if [ -z "$DATABASE_URL" ]; then' >> /app/start.sh && \
    echo '  echo "❌ ERROR: DATABASE_URL is not set!"' >> /app/start.sh && \
    echo '  echo "Please set DATABASE_URL in Railway environment variables"' >> /app/start.sh && \
    echo '  exit 1' >> /app/start.sh && \
    echo 'fi' >> /app/start.sh && \
    echo 'echo "✅ DATABASE_URL is set"' >> /app/start.sh && \
    echo 'echo "Running migrations..."' >> /app/start.sh && \
    echo 'npx prisma migrate deploy' >> /app/start.sh && \
    echo 'echo "✅ Migrations complete"' >> /app/start.sh && \
    echo 'echo "Starting NestJS application..."' >> /app/start.sh && \
    echo 'node dist/main' >> /app/start.sh && \
    chmod +x /app/start.sh

# Start application
CMD ["/app/start.sh"]
