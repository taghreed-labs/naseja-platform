<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // بيانات المستخدم الأساسية
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('phone', 30);

            // كلمة المرور
            $table->string('password', 255);

            // حالة الحساب
            $table->string('status', 30);

            // التحقق من البريد والهاتف
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();

            // آخر تسجيل دخول
            $table->timestamp('last_login_at')->nullable();

            $table->timestamps();

            // الحذف الناعم
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};