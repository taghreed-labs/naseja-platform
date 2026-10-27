<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            // المستخدم صاحب الملف الشخصي
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // نبذة عن المستخدم
            $table->text('bio')->nullable();

            // الموقع
            $table->string('location', 255)->nullable();

            // العنوان
            $table->string('address', 500)->nullable();

            // الإحداثيات الجغرافية
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // سنوات الخبرة
            $table->unsignedSmallInteger('experience_years')->nullable();

            // الموقع الإلكتروني
            $table->string('website', 500)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};