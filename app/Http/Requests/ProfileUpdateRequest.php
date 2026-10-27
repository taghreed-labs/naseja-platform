<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $isProvider = $this->user()?->roles()->where('slug', 'provider')->exists() ?? false;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'location' => ['nullable', 'string', 'max:255'],
            'governorate' => [$isProvider ? 'required' : 'nullable', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'street' => ['nullable', 'string', 'max:255'],
            'bio_ar' => ['nullable', 'string', 'max:1000'],
            'contact_phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+\s\-()]+$/'],
            'whatsapp' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+\s\-()]+$/'],
            'telegram_username' => ['nullable', 'string', 'max:100', 'regex:/^@?[A-Za-z0-9_]+$/'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'governorate.required' => 'اختر المحافظة لصاحب المهارة.',
            'contact_phone.regex' => 'يرجى إدخال رقم اتصال صحيح.',
            'whatsapp.regex' => 'يرجى إدخال رقم واتساب صحيح.',
            'telegram_username.regex' => 'يرجى إدخال اسم مستخدم تليجرام صحيح مثل @username.',
            'avatar.max' => 'حجم الصورة الشخصية يجب ألا يتجاوز 5 ميجابايت.',
            'avatar.mimes' => 'الصورة الشخصية يجب أن تكون JPG أو PNG أو WebP.',
        ];
    }
}
