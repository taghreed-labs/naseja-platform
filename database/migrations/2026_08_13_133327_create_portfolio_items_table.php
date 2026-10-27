<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_items', function (Blueprint $table) {
            $table->id();

            // المستخدم صاحب العمل
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // عنوان العمل بالعربي
            $table->string('title_ar', 255);

            // عنوان العمل بالإنجليزي
            $table->string('title_en', 255);

            // وصف العمل بالعربي
            $table->text('description_ar')->nullable();

            // وصف العمل بالإنجليزي
            $table->text('description_en')->nullable();

            // تاريخ إنشاء العمل
            $table->date('work_date')->nullable();

            // حالة العمل
            $table->string('status', 30);

            $table->timestamps();

            // الحذف الناعم
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_items');
    }
};