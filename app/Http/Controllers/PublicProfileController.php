<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PublicProfileController extends Controller
{
    /**
     * عرض الملف العام.
     */
    public function show(string $slug): View|RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | أولًا: البحث بالـ Slug الصحيح
        |--------------------------------------------------------------------------
        */

        $profile = Profile::with('user')
            ->where('slug', $slug)
            ->first();


        /*
        |--------------------------------------------------------------------------
        | دعم الروابط القديمة التي ما زالت ترسل ID
        |--------------------------------------------------------------------------
        |
        | مثال:
        | /profile/6
        |
        | نحوله مباشرة إلى:
        | /profile/مذاق-البيت-للحلويات
        |
        */

        if (!$profile && ctype_digit($slug)) {

            $user = User::with('profile')
                ->findOrFail((int) $slug);

            /*
            |--------------------------------------------------------------------------
            | إذا لم يكن لديه Profile ننشئه
            |--------------------------------------------------------------------------
            */

            $profile = $user->profile;

            if (!$profile) {
                $profile = Profile::create([
                    'user_id' => $user->id,
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | التأكد من وجود Slug
            |--------------------------------------------------------------------------
            */

            $this->ensureSlug($profile, $user);


            /*
            |--------------------------------------------------------------------------
            | تحويل الرابط القديم إلى الرابط النهائي
            |--------------------------------------------------------------------------
            */

            return redirect()->route(
                'users.show',
                [
                    'slug' => $profile->slug,
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | إذا لم نجد لا Slug ولا ID صحيح
        |--------------------------------------------------------------------------
        */

        if (!$profile) {
            abort(404);
        }


        $user = $profile->user;

        if (!$user) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | الحساب غير متاح للعامة
        |--------------------------------------------------------------------------
        */

        if (
            $user->status !== 'active' ||
            $user->approval_status !== 'approved'
        ) {

            if (
                auth()->check() &&
                auth()->id() === $user->id
            ) {

                $title = 'ملفك قيد المراجعة';

                $message =
                    'تم حفظ بياناتك بنجاح، وسيظهر ملفك للعامة بعد اعتماد الحساب من إدارة NASEJA.';
            }

            else {

                $title = 'الملف غير متاح حاليًا';

                $message =
                    'هذا الملف غير متاح للعرض في الوقت الحالي.';
            }


            return view(
                'frontend.profile-unavailable',
                compact(
                    'title',
                    'message'
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | جلب بيانات الملف العام
        |--------------------------------------------------------------------------
        */

        $user->load([
            'profile',
            'userSkills.skill',

            'services' => function ($query) {
                $query->where('status', 'active');
            },

            'portfolioItems' => function ($query) {
                $query->where('status', 'active');
            },

            'portfolioItems.images',
        ]);


        return view(
            'layouts.frontend.user.public-profile',
            compact('user')
        );
    }


    /**
     * إنشاء Slug إذا كان الملف القديم لا يحتوي عليه.
     */
    private function ensureSlug(Profile $profile, User $user): void
    {
        if (!empty($profile->slug)) {
            return;
        }


        $baseSlug = preg_replace(
            '/[^\p{L}\p{N}]+/u',
            '-',
            trim($user->name)
        );

        $baseSlug = trim(
            (string) $baseSlug,
            '-'
        );

        $baseSlug = mb_strtolower($baseSlug);


        /*
        |--------------------------------------------------------------------------
        | إذا كان الاسم فارغًا أو أرقامًا فقط
        |--------------------------------------------------------------------------
        */

        if (
            $baseSlug === '' ||
            ctype_digit($baseSlug)
        ) {

            $baseSlug =
                'member-' .
                strtolower(substr(md5($user->email), 0, 8));
        }


        $slug = $baseSlug;

        $number = 2;


        while (
            Profile::where('slug', $slug)
                ->where('id', '!=', $profile->id)
                ->exists()
        ) {

            $slug =
                $baseSlug .
                '-' .
                $number;

            $number++;
        }


        $profile->slug = $slug;

        $profile->save();
    }
}