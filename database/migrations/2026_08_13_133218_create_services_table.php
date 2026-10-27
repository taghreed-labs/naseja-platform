<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            // المستخدم صاحب الخدمة
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // تصنيف الخدمة
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->cascadeOnDelete();

            // عنوان الخدمة بالعربي
            $table->string('title_ar', 255);

            // عنوان الخدمة بالإنجليزي
            $table->string('title_en', 255);

            // وصف الخدمة بالعربي
            $table->text('description_ar');

            // وصف الخدمة بالإنجليزي
            $table->text('description_en');

            // سعر الخدمة
            $table->decimal('price', 12, 2);

            // نوع السعر
            $table->string('price_type', 50);

            // مدة تنفيذ الخدمة
            $table->string('duration', 100);

            // حالة الخدمة
            $table->string('status', 30);

            $table->timestamps();

            // الحذف الناعم
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};