<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('title_en', 255)->nullable()->change();
            $table->text('description_ar')->nullable()->change();
            $table->text('description_en')->nullable()->change();
            $table->decimal('price', 12, 2)->nullable()->change();
            $table->string('price_type', 50)->nullable()->change();
            $table->string('duration', 100)->nullable()->change();
        });

        Schema::table('portfolio_items', function (Blueprint $table) {
            $table->string('title_en', 255)->nullable()->change();
        });

        Schema::table('profiles', function (Blueprint $table) {
            $table->string('governorate', 100)->nullable();
            $table->string('district', 100)->nullable();
            $table->string('street', 255)->nullable();
        });
    }

    public function down(): void
    {
        // الرجوع إلى أعمدة NOT NULL بعد إدخال خدمات اختيارية يحتاج ترحيل بيانات مخصصًا.
        throw new RuntimeException('استرجع قاعدة البيانات من نسخة احتياطية قبل التراجع عن هذا التحديث.');
    }
};
