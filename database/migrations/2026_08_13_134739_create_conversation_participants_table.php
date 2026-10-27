<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversation_participants', function (Blueprint $table) {
            $table->id();

            // المحادثة
            $table->foreignId('conversation_id')
                  ->constrained('conversations')
                  ->cascadeOnDelete();

            // المستخدم المشارك
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // وقت انضمام المستخدم للمحادثة
            $table->timestamp('joined_at')->useCurrent();

            // وقت إنشاء سجل المشاركة
            $table->timestamp('created_at')->useCurrent();

            // منع تكرار نفس المستخدم في نفس المحادثة
            $table->unique(['conversation_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversation_participants');
    }
};