<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();

            // المستخدم صاحب الملف
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // نوع الملف
            $table->string('type', 50);

            // مسار الملف
            $table->string('file_path', 500);

            // اسم الملف
            $table->string('file_name', 255)->nullable();

            // نوع MIME
            $table->string('mime_type', 100)->nullable();

            // حجم الملف بالبايت
            $table->unsignedBigInteger('size')->nullable();

            // العنصر المرتبط بالملف
            $table->string('mediable_type', 100)->nullable();
            $table->unsignedBigInteger('mediable_id')->nullable();

            $table->timestamps();

            // فهرس للعلاقة المرنة
            $table->index(['mediable_type', 'mediable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};