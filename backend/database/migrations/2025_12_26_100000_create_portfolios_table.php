<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->integer('order')->default(0);
            $table->boolean('featured')->default(false);
            $table->enum('status', ['published', 'draft', 'private'])->default('published');
            
            // English content
            $table->string('title_en');
            $table->text('description_en');
            $table->text('full_description_en')->nullable();
            
            // Arabic content
            $table->string('title_ar');
            $table->text('description_ar');
            $table->text('full_description_ar')->nullable();
            
            // Project details (JSON)
            $table->json('details_en')->nullable();
            $table->json('details_ar')->nullable();
            
            // Categories (JSON array)
            $table->json('categories')->nullable();
            
            // Tags (JSON array)
            $table->json('tags')->nullable();
            
            // SEO
            $table->string('meta_title_en')->nullable();
            $table->string('meta_title_ar')->nullable();
            $table->text('meta_description_en')->nullable();
            $table->text('meta_description_ar')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('slug');
            $table->index('order');
            $table->index('status');
            $table->index('featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
