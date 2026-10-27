<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_skills', function (Blueprint $table) {
            $table->id();

            // المستخدم الذي يمتلك المهارة
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // المهارة
            $table->foreignId('skill_id')
                  ->constrained('skills')
                  ->cascadeOnDelete();

            // مستوى المستخدم في المهارة
            $table->string('level', 50);

            // عدد سنوات الخبرة
            $table->unsignedSmallInteger('years_experience')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_skills');
    }
};