<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {

            // الأعمدة التي نحتاجها في صفحة الملف الشخصي
            if (!Schema::hasColumn('profiles', 'phone')) {
                $table->string('phone')->nullable();
            }

            if (!Schema::hasColumn('profiles', 'bio_ar')) {
                $table->text('bio_ar')->nullable();
            }

            if (!Schema::hasColumn('profiles', 'bio_en')) {
                $table->text('bio_en')->nullable();
            }

            if (!Schema::hasColumn('profiles', 'avatar')) {
                $table->string('avatar')->nullable();
            }

            if (!Schema::hasColumn('profiles', 'cover_image')) {
                $table->string('cover_image')->nullable();
            }

            if (!Schema::hasColumn('profiles', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable();
            }

            if (!Schema::hasColumn('profiles', 'gender')) {
                $table->string('gender')->nullable();
            }

            if (!Schema::hasColumn('profiles', 'website')) {
                $table->string('website')->nullable();
            }

            if (!Schema::hasColumn('profiles', 'is_verified')) {
                $table->boolean('is_verified')->default(false);
            }
        });
    }

    public function down(): void
    {
        // لا نحذف الأعمدة الموجودة مسبقًا
    }
};