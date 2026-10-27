<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_images', function (Blueprint $table) {
            $table->id();

            // العمل الذي تنتمي إليه الصورة
            $table->foreignId('portfolio_item_id')
                  ->constrained('portfolio_items')
                  ->cascadeOnDelete();

            // مسار الصورة
            $table->string('file_path', 500);

            // النص البديل للصورة
            $table->string('alt_text', 255)->nullable();

            // ترتيب الصورة داخل العمل
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_images');
    }
};