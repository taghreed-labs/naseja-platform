<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_meta', function (Blueprint $table) {
            $table->id();

            // نوع الصفحة أو العنصر المرتبط
            $table->string('metable_type', 100)->nullable();

            // رقم العنصر المرتبط
            $table->unsignedBigInteger('metable_id')->nullable();

            // عنوان الصفحة بالعربي
            $table->string('title_ar', 255)->nullable();

            // عنوان الصفحة بالإنجليزي
            $table->string('title_en', 255)->nullable();

            // وصف الصفحة بالعربي
            $table->text('description_ar')->nullable();

            // وصف الصفحة بالإنجليزي
            $table->text('description_en')->nullable();

            // الكلمات المفتاحية
            $table->text('keywords')->nullable();

            // الرابط الأساسي للصفحة
            $table->string('canonical_url', 500)->nullable();

            // صورة المشاركة الاجتماعية
            $table->string('og_image', 500)->nullable();

            $table->timestamps();

            // فهرس للعنصر المرتبط
            $table->index(['metable_type', 'metable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_meta');
    }
};