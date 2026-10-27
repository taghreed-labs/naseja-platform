<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();

            // المستخدم الذي أضاف المفضلة
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // المستخدم الذي تمت إضافته إلى المفضلة
            $table->foreignId('favorite_user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // وقت إضافة المفضلة
            $table->timestamp('created_at')->useCurrent();

            // منع المستخدم من إضافة نفس الشخص للمفضلة أكثر من مرة
            $table->unique(['user_id', 'favorite_user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};