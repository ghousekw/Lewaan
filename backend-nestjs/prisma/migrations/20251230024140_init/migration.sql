-- CreateEnum
CREATE TYPE "Status" AS ENUM ('published', 'draft', 'private');

-- CreateTable
CREATE TABLE "portfolios" (
    "id" SERIAL NOT NULL,
    "slug" TEXT NOT NULL,
    "order" INTEGER NOT NULL DEFAULT 0,
    "featured" BOOLEAN NOT NULL DEFAULT false,
    "status" "Status" NOT NULL DEFAULT 'published',
    "title_en" TEXT NOT NULL,
    "description_en" TEXT NOT NULL,
    "full_description_en" TEXT,
    "title_ar" TEXT NOT NULL,
    "description_ar" TEXT NOT NULL,
    "full_description_ar" TEXT,
    "details_en" JSONB,
    "details_ar" JSONB,
    "categories" JSONB,
    "tags" JSONB,
    "meta_title_en" TEXT,
    "meta_title_ar" TEXT,
    "meta_description_en" TEXT,
    "meta_description_ar" TEXT,
    "thumbnail" JSONB,
    "gallery" JSONB,
    "created_at" TIMESTAMP(3) NOT NULL DEFAULT CURRENT_TIMESTAMP,
    "updated_at" TIMESTAMP(3) NOT NULL,
    "deleted_at" TIMESTAMP(3),

    CONSTRAINT "portfolios_pkey" PRIMARY KEY ("id")
);

-- CreateIndex
CREATE UNIQUE INDEX "portfolios_slug_key" ON "portfolios"("slug");

-- CreateIndex
CREATE INDEX "portfolios_slug_idx" ON "portfolios"("slug");

-- CreateIndex
CREATE INDEX "portfolios_order_idx" ON "portfolios"("order");

-- CreateIndex
CREATE INDEX "portfolios_status_idx" ON "portfolios"("status");

-- CreateIndex
CREATE INDEX "portfolios_featured_idx" ON "portfolios"("featured");
