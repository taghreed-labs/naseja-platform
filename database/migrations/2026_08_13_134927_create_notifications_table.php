<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // المستخدم الذي وصلت إليه الإشعارات
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // نوع الإشعار
            $table->string('type', 50);

            // عنوان الإشعار بالعربي
            $table->string('title_ar', 255);

            // عنوان الإشعار بالإنجليزي
            $table->string('title_en', 255);

            // محتوى الإشعار بالعربي
            $table->text('message_ar');

            // محتوى الإشعار بالإنجليزي
            $table->text('message_en');

            // بيانات إضافية للإشعار
            $table->json('data')->nullable();

            // وقت قراءة الإشعار
            $table->timestamp('read_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};