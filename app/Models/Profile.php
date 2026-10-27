<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'slug',
        'bio_ar',
        'bio_en',
        'phone',
        'location',
        'governorate',
        'district',
        'street',
        'avatar',
        'cover_image',
        'date_of_birth',
        'gender',
        'website',
        'is_verified',

        // بيانات التواصل العامة الاختيارية
        'contact_phone',
        'whatsapp',
        'telegram_username',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_verified' => 'boolean',
    ];

    /**
     * إنشاء Slug تلقائي لأي ملف جديد.
     */
    protected static function booted(): void
    {
        static::creating(function (Profile $profile) {

            // إذا كان لديه slug مسبقًا لا نغيره
            if (!empty($profile->slug)) {
                return;
            }

            $user = User::find($profile->user_id);

            $name = $user?->name ?: 'profile';

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

            while (
                Profile::where('slug', $slug)->exists()
            ) {
                $slug = $baseSlug . '-' . $number;
                $number++;
            }

            $profile->slug = $slug;
        });
    }

    /**
     * الملف الشخصي تابع لمستخدم واحد.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
