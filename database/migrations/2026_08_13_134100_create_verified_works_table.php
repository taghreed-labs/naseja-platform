<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verified_works', function (Blueprint $table) {
            $table->id();

            // مقدم الخدمة / صاحب العمل
            $table->foreignId('provider_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // العميل
            $table->foreignId('client_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // العمل الموجود في معرض الأعمال
            $table->foreignId('portfolio_item_id')
                  ->constrained('portfolio_items')
                  ->cascadeOnDelete();

            // الخدمة المرتبطة بالعمل
            $table->foreignId('service_id')
                  ->constrained('services')
                  ->cascadeOnDelete();

            // حالة التحقق
            $table->string('status', 30);

            // رمز التحقق
            $table->string('verification_token', 255)->nullable();

            // وقت التحقق
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verified_works');
    }
};