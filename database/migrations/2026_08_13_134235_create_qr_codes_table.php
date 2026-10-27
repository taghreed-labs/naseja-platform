<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();

            // المستخدم صاحب رمز QR
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // رمز QR الفريد
            $table->string('code', 255)->unique();

            // نوع رمز QR
            $table->string('type', 50);

            // نوع العنصر المستهدف
            $table->string('target_type', 100)->nullable();

            // رقم العنصر المستهدف
            $table->unsignedBigInteger('target_id')->nullable();

            // هل الرمز فعال؟
            $table->boolean('is_active')->default(true);

            // تاريخ انتهاء الرمز
            $table->timestamp('expires_at')->nullable();

            $table->timestamps();

            // فهرس للعلاقة مع العنصر المستهدف
            $table->index(['target_type', 'target_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_codes');
    }
};