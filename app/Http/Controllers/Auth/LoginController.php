<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('frontend.auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // احفظ اختيار الزائر قبل تجديد الجلسة عند تسجيل الدخول.
        $pendingFavoriteUserId = $request->session()->get('pending_favorite_user_id');
        $pendingFavoriteRedirect = $request->session()->get('pending_favorite_redirect', route('explore'));

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if ($pendingFavoriteUserId) {
                $request->session()->forget([
                    'pending_favorite_user_id',
                    'pending_favorite_redirect',
                ]);

                // المفضلة للعميل فقط، كما هو معمول به في FavoriteController.
                $isCustomer = auth()->user()->roles()
                    ->where('slug', 'customer')
                    ->exists();

                if (!$isCustomer) {
                    return redirect()->route('dashboard')
                        ->with('info', 'المفضلة متاحة لحساب العميل فقط.');
                }

                $favoriteUser = User::find($pendingFavoriteUserId);
                $isActiveProvider = $favoriteUser
                    && $favoriteUser->status === 'active'
                    && $favoriteUser->approval_status === 'approved'
                    && $favoriteUser->roles()->where('slug', 'provider')->exists();

                if (!$isActiveProvider || $favoriteUser->id === auth()->id()) {
                    return redirect()->route('explore')
                        ->with('info', 'صاحب المهارة غير متاح للمفضلة حاليًا.');
                }

                Favorite::firstOrCreate([
                    'user_id' => auth()->id(),
                    'favorite_user_id' => $favoriteUser->id,
                ]);

                // العودة الآمنة إلى صفحة صاحب المهارة أو صفحة الاستكشاف.
                $redirectPath = parse_url($pendingFavoriteRedirect, PHP_URL_PATH);
                $redirectHost = parse_url($pendingFavoriteRedirect, PHP_URL_HOST);
                $sameHost = !$redirectHost || $redirectHost === $request->getHost();
                $destination = $sameHost && is_string($redirectPath) && str_starts_with($redirectPath, '/')
                    ? $pendingFavoriteRedirect
                    : route('explore');

                return redirect($destination)
                    ->with('success', 'تم حفظ صاحب المهارة في مفضلتك ❤️');
            }

            return redirect()->intended(route('dashboard'));
        }

        return back()
            ->withErrors(['email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.'])
            ->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
