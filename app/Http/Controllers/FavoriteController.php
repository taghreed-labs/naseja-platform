<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    /**
     * عرض أصحاب المهارات الذين حفظهم العميل في مفضلته.
     */
    public function index(): View
    {
        $this->ensureCustomer();

        $favorites = Favorite::query()
            ->where('user_id', auth()->id())
            ->with([
                'favoriteUser.profile',
            ])
            ->latest('created_at')
            ->get();

        return view(
            'layouts.frontend.user.favorites',
            compact('favorites')
        );
    }


    /**
     * حفظ صاحب مهارة في المفضلة.
     *
     * الزائر يستطيع الضغط على زر المفضلة، لكن الحفظ النهائي
     * يتم بعد تسجيل الدخول أو إنشاء حساب عميل.
     */
    public function store(User $user): RedirectResponse
    {
        $this->ensureTargetIsProvider($user);

        /*
        |--------------------------------------------------------------------------
        | الزائر
        |--------------------------------------------------------------------------
        |
        | نحفظ اختياره مؤقتًا مع الصفحة التي كان فيها، ثم نرسله
        | لاختيار تسجيل الدخول أو إنشاء حساب.
        |
        */
        if (!auth()->check()) {
            session([
                'pending_favorite_user_id' => $user->id,
                'pending_favorite_redirect' => url()->previous(),
            ]);

            return redirect()
                ->route('auth.action-choice')
                ->with(
                    'info',
                    'سجّل الدخول أو أنشئ حسابًا لحفظ صاحب المهارة في مفضلتك.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | المفضلة خاصة بحساب العميل
        |--------------------------------------------------------------------------
        */
        if (!$this->currentUserIsCustomer()) {
            return back()->with(
                'info',
                'المفضلة متاحة لحساب العميل.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | منع حفظ الحساب لنفسه
        |--------------------------------------------------------------------------
        */
        if ($user->id === auth()->id()) {
            return back()->with(
                'error',
                'لا يمكنك إضافة حسابك إلى المفضلة.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | حفظ بدون تكرار
        |--------------------------------------------------------------------------
        */
        $favorite = Favorite::firstOrCreate([
            'user_id' => auth()->id(),
            'favorite_user_id' => $user->id,
        ], [
            'created_at' => now(),
        ]);

        if ($favorite->wasRecentlyCreated) {
            return back()->with(
                'success',
                'تم حفظ صاحب المهارة في مفضلتك ❤️'
            );
        }

        return back()->with(
            'info',
            'صاحب المهارة محفوظ في مفضلتك مسبقًا.'
        );
    }


    /**
     * إزالة صاحب مهارة من مفضلة العميل.
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->ensureCustomer();

        Favorite::query()
            ->where('user_id', auth()->id())
            ->where('favorite_user_id', $user->id)
            ->delete();

        return back()->with(
            'success',
            'تمت إزالة صاحب المهارة من المفضلة.'
        );
    }


    /**
     * هل المستخدم الحالي عميل؟
     */
    private function currentUserIsCustomer(): bool
    {
        return auth()->check()
            && auth()->user()
                ->roles()
                ->where('slug', 'customer')
                ->exists();
    }


    /**
     * حماية صفحات إدارة المفضلة لتكون خاصة بالعميل.
     */
    private function ensureCustomer(): void
    {
        abort_unless(
            $this->currentUserIsCustomer(),
            403,
            'المفضلة متاحة لحساب العميل فقط.'
        );
    }


    /**
     * لا نسمح بحفظ إلا صاحب مهارة فعّال ومعتمد.
     */
    private function ensureTargetIsProvider(User $user): void
    {
        $isProvider = $user
            ->roles()
            ->where('slug', 'provider')
            ->exists();

        abort_unless(
            $isProvider
                && $user->status === 'active'
                && $user->approval_status === 'approved',
            404
        );
    }
}
