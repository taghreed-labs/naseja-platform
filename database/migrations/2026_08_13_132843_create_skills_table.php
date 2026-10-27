<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();

            // التصنيف الذي تنتمي إليه المهارة
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->cascadeOnDelete();

            // اسم المهارة بالعربي
            $table->string('name_ar', 255);

            // اسم المهارة بالإنجليزي
            $table->string('name_en', 255);

            // الرابط المختصر للمهارة
            $table->string('slug', 255);

            // وصف المهارة
            $table->text('description')->nullable();

            // حالة المهارة
            $table->string('status', 30);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};