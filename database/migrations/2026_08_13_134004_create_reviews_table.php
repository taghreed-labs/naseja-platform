<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // المستخدم الذي كتب التقييم
            $table->foreignId('reviewer_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // الخدمة التي تم تقييمها
            $table->foreignId('service_id')
                  ->constrained('services')
                  ->cascadeOnDelete();

            // التقييم من 1 إلى 5
            $table->unsignedTinyInteger('rating');

            // تعليق المستخدم
            $table->text('comment')->nullable();

            // تاريخ التقييم
            $table->date('review_date');

            $table->timestamps();

            // الحذف الناعم
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};