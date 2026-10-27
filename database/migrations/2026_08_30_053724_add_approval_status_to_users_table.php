<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('approval_status', 30)
                ->default('pending')
                ->after('status');
        });

        // المستخدمون الموجودون حاليًا نعتمدهم حتى لا يختفوا من المنصة
        DB::table('users')->update([
            'approval_status' => 'approved',
        ]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('approval_status');
        });
    }
};