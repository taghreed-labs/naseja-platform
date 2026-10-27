<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('contact_phone', 30)
                  ->nullable()
                  ->after('website');

            $table->string('whatsapp', 30)
                  ->nullable()
                  ->after('contact_phone');

            $table->string('telegram_username', 100)
                  ->nullable()
                  ->after('whatsapp');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'contact_phone',
                'whatsapp',
                'telegram_username',
            ]);
        });
    }
};