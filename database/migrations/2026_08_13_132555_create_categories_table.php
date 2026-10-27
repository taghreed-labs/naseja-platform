<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // التصنيف الأب - يسمح بوجود تصنيفات فرعية
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('categories')
                  ->nullOnDelete();

            // اسم التصنيف بالعربي
            $table->string('name_ar', 255);

            // اسم التصنيف بالإنجليزي
            $table->string('name_en', 255);

            // الرابط المختصر للتصنيف
            $table->string('slug', 255);

            // وصف التصنيف
            $table->text('description')->nullable();

            // المستخدم الذي أنشأ التصنيف
            $table->foreignId('created_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // صورة التصنيف
            $table->string('image', 500)->nullable();

            // حالة التصنيف
            $table->string('status', 30);

            // ترتيب التصنيف
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};