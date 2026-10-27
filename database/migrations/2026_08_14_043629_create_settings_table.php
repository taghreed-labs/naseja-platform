<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // اسم الإعداد
            $table->string('key', 100)->unique();

            // قيمة الإعداد
            $table->text('value')->nullable();

            // نوع القيمة
            $table->string('type', 30)->default('string');

            // وصف الإعداد
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};