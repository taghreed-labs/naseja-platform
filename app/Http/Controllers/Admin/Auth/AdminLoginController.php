<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * عرض صفحة تسجيل دخول الأدمن.
     */
    public function create()
    {
        if (Auth::check()) {

            $isAdmin = Auth::user()
                ->roles()
                ->where('slug', 'admin')
                ->exists();

            if ($isAdmin) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('dashboard');
        }

        return view('admin.auth.login');
    }


    /**
     * تنفيذ تسجيل دخول الأدمن.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);


        if (!Auth::attempt(
            $credentials,
            $request->boolean('remember')
        )) {

            return back()
                ->withErrors([
                    'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
                ])
                ->onlyInput('email');
        }


        $request->session()->regenerate();


        // التأكد أن الحساب يملك دور admin
        $isAdmin = Auth::user()
            ->roles()
            ->where('slug', 'admin')
            ->exists();


        if (!$isAdmin) {

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors([
                    'email' => 'هذا الحساب غير مصرح له بالدخول إلى لوحة الإدارة.',
                ])
                ->onlyInput('email');
        }


        return redirect()
            ->intended(route('admin.dashboard'));
    }


    /**
     * تسجيل خروج الأدمن.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}