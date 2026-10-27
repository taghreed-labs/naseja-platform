<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // المستخدم الذي قام بالنشاط
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // نوع النشاط
            $table->string('action', 100);

            // وصف النشاط
            $table->text('description')->nullable();

            // نوع العنصر المتأثر
            $table->string('subject_type', 100)->nullable();

            // رقم العنصر المتأثر
            $table->unsignedBigInteger('subject_id')->nullable();

            // بيانات إضافية
            $table->json('properties')->nullable();

            $table->timestamps();

            // فهرس للعنصر المتأثر
            $table->index(['subject_type', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};