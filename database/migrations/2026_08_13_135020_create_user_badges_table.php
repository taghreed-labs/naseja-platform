<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_badges', function (Blueprint $table) {
            $table->id();

            // المستخدم الذي حصل على الشارة
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // رقم الشارة
            $table->unsignedBigInteger('badge_id');

            // تاريخ منح الشارة
            $table->timestamp('awarded_at')->useCurrent();

            // تاريخ إنشاء السجل
            $table->timestamp('created_at')->useCurrent();

            // منع تكرار نفس الشارة للمستخدم
            $table->unique(['user_id', 'badge_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_badges');
    }
};