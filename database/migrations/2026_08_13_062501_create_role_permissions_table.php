<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();

            // الدور
            $table->foreignId('role_id')
                  ->constrained('roles')
                  ->cascadeOnDelete();

            // الصلاحية
            $table->foreignId('permission_id')
                  ->constrained('permissions')
                  ->cascadeOnDelete();

            // تاريخ إسناد الصلاحية للدور
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};