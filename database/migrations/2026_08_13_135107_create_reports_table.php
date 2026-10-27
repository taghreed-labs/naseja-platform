<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            // المستخدم الذي قام بإنشاء البلاغ
            $table->foreignId('reporter_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // المستخدم الذي تم الإبلاغ عنه
            $table->foreignId('reported_user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // نوع البلاغ
            $table->string('type', 50);

            // سبب البلاغ
            $table->text('reason');

            // تفاصيل إضافية
            $table->text('description')->nullable();

            // حالة البلاغ
            $table->string('status', 30)->default('pending');

            // ملاحظات الإدارة
            $table->text('admin_note')->nullable();

            // تاريخ معالجة البلاغ
            $table->timestamp('resolved_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};