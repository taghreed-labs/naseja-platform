<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            // إضافة المحافظة والمديرية والشارع كحقول اختيارية (nullable)
            $table->string('governorate')->nullable();
            $table->string('district')->nullable();
            $table->string('street')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['governorate', 'district', 'street']);
        });
    }
};