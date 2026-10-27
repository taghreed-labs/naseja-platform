<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use App\Support\WebpImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        $profile = Profile::firstOrCreate(['user_id' => $user->id]);

        return view('layouts.frontend.user.profile', compact('user', 'profile'));
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $profile = Profile::firstOrCreate(['user_id' => $user->id]);
        $oldAvatar = $profile->avatar;
        $newAvatar = null;

        // جهّز الملف قبل تعديل بيانات الحساب كي لا نحفظ بيانات جزئية عند فشل التحويل.
        if ($request->hasFile('avatar')) {
            $newAvatar = WebpImage::save($request->file('avatar'), 'profiles/avatars', 640);
        }

        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($request, $user, $profile, $newAvatar) {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);

                $profile->phone = $request->phone;
                $isProvider = $user->roles()->where('slug', 'provider')->exists();
                if ($isProvider) {
                    $profile->governorate = $request->governorate;
                    $profile->district = $request->district;
                    $profile->street = $request->street;
                    // نحافظ على الموقع المركب للصفحات القديمة والبحث والملف العام.
                    $profile->location = mb_substr(implode('، ', array_filter([
                        $request->governorate, $request->district, $request->street,
                    ], fn ($value) => filled($value))), 0, 255);
                } else {
                    $profile->location = $request->location;
                }
                $profile->bio_ar = $request->bio_ar;
                $profile->contact_phone = $request->contact_phone;
                $profile->whatsapp = $request->whatsapp;
                $profile->telegram_username = $request->telegram_username;
                if ($newAvatar !== null) {
                    $profile->avatar = $newAvatar;
                }
                $profile->save();
            });
        } catch (\Throwable $exception) {
            if ($newAvatar !== null) {
                Storage::disk('public')->delete($newAvatar);
            }
            throw $exception;
        }

        if ($newAvatar !== null && $oldAvatar && $oldAvatar !== $newAvatar) {
            Storage::disk('public')->delete($oldAvatar);
        }

        return Redirect::route('profile.edit')->with('status', 'تم تحديث الملف الشخصي بنجاح');
    }

    public function show(Request $request, int $userId): View
    {
        $user = \App\Models\User::with([
            'profile', 'userSkills.skill', 'services.category', 'portfolioItems.images',
        ])->findOrFail($userId);

        return view('layouts.frontend.user.public-profile', ['user' => $user]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
