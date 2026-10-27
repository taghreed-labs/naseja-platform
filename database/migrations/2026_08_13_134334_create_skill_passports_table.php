<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skill_passports', function (Blueprint $table) {
            $table->id();

            // المستخدم صاحب جواز المهارة
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // المهارة الموثقة
            $table->foreignId('skill_id')
                  ->constrained('skills')
                  ->cascadeOnDelete();

            // مستوى المهارة
            $table->string('level', 50);

            // تاريخ إصدار جواز المهارة
            $table->date('issued_at');

            // تاريخ انتهاء الجواز
            $table->date('expires_at')->nullable();

            // رمز التحقق
            $table->string('verification_code', 255)->unique();

            // حالة الجواز
            $table->string('status', 30);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skill_passports');
    }
};