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

# Copy source code (excluding dist, node_modules)
COPY nest-cli.json ./
COPY tsconfig.json ./
COPY src ./src

# Build application - show errors if build fails
RUN npm run build && echo "Build complete, listing dist:" && ls -la dist/

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

# Copy built application from builder
COPY --from=builder /app/dist ./dist

# Copy node_modules with generated Prisma Client from builder
COPY --from=builder /app/node_modules/.prisma ./node_modules/.prisma
COPY --from=builder /app/node_modules/@prisma ./node_modules/@prisma

# Verify dist/main.js exists
RUN echo "Checking for main.js:" && ls -la /app/dist/ && test -f /app/dist/main.js || (echo "ERROR: dist/main.js not found!" && exit 1)

# Expose port
EXPOSE 8000

# Start application
CMD ["sh", "-c", "echo 'DATABASE_URL scheme:' $(echo $DATABASE_URL | cut -d: -f1) && echo 'Running migrations...' && npx prisma migrate deploy && echo 'Starting app...' && node dist/main.js"]
