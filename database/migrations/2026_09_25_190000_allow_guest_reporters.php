<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->unsignedBigInteger('reporter_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Do not silently delete reports submitted by guests during rollback.
        if (DB::table('reports')->whereNull('reporter_id')->exists()) {
            throw new RuntimeException('Guest reports exist. Archive them before reverting reporter_id to NOT NULL.');
        }

        Schema::table('reports', function (Blueprint $table) {
            $table->unsignedBigInteger('reporter_id')->nullable(false)->change();
        });
    }
};
