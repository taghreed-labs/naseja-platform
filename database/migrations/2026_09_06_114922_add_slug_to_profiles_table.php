<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('slug', 255)
                ->nullable()
                ->after('user_id');
        });

        /*
        |--------------------------------------------------------------------------
        | إنشاء Slug للملفات الموجودة مسبقًا
        |--------------------------------------------------------------------------
        */

        $profiles = DB::table('profiles')
            ->orderBy('id')
            ->get();

        foreach ($profiles as $profile) {

            $user = DB::table('users')
                ->where('id', $profile->user_id)
                ->first();

            $name = $user?->name ?: 'profile';

            // يدعم الأسماء العربية والإنجليزية
            $baseSlug = preg_replace(
                '/[^\p{L}\p{N}]+/u',
                '-',
                trim($name)
            );

            $baseSlug = trim($baseSlug, '-');
            $baseSlug = mb_strtolower($baseSlug);

            if ($baseSlug === '') {
                $baseSlug = 'profile';
            }

            $slug = $baseSlug;
            $number = 2;

            // منع تكرار الرابط
            while (
                DB::table('profiles')
                    ->where('slug', $slug)
                    ->where('id', '!=', $profile->id)
                    ->exists()
            ) {
                $slug = $baseSlug . '-' . $number;
                $number++;
            }

            DB::table('profiles')
                ->where('id', $profile->id)
                ->update([
                    'slug' => $slug,
                ]);
        }

        Schema::table('profiles', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};