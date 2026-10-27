<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    /**
     * عرض إعدادات حساب مدير النظام.
     */
    public function index(Request $request)
    {
        $admin = $request->user();

        return view(
            'admin.settings.index',
            compact('admin')
        );
    }


    /**
     * تحديث بيانات حساب مدير النظام.
     */
    public function updateProfile(Request $request)
    {
        $admin = $request->user();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($admin->id),
            ],
        ]);


        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->save();


        return back()->with(
            'success',
            'تم تحديث بيانات حساب الإدارة بنجاح.'
        );
    }


    /**
     * تغيير كلمة مرور مدير النظام.
     */
    public function updatePassword(Request $request)
    {
        $admin = $request->user();

        $validated = $request->validate([
            'current_password' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);


        if (
            !Hash::check(
                $validated['current_password'],
                $admin->password
            )
        ) {
            return back()
                ->withErrors([
                    'current_password' =>
                        'كلمة المرور الحالية غير صحيحة.',
                ])
                ->withInput();
        }


        $admin->password = Hash::make(
            $validated['password']
        );

        $admin->save();


        return back()->with(
            'success',
            'تم تغيير كلمة المرور بنجاح.'
        );
    }
}
