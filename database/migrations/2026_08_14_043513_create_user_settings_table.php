<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();

            // المستخدم صاحب الإعدادات
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // اسم الإعداد
            $table->string('key', 100);

            // قيمة الإعداد
            $table->text('value')->nullable();

            $table->timestamps();

            // منع تكرار نفس الإعداد للمستخدم
            $table->unique(['user_id', 'key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};