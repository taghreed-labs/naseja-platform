<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            // المحادثة التي تنتمي إليها الرسالة
            $table->foreignId('conversation_id')
                  ->constrained('conversations')
                  ->cascadeOnDelete();

            // المستخدم الذي أرسل الرسالة
            $table->foreignId('sender_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // محتوى الرسالة
            $table->text('message');

            // وقت قراءة الرسالة
            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            // الحذف الناعم
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};