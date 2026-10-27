@extends('layouts.frontend.user')
@section('title', 'الملف الشخصي | NASEJA')

@section('content')

@php
    $isProvider = $user->roles()->where('slug', 'provider')->exists();
@endphp

<div class="profile-page">

    {{-- عنوان الصفحة --}}
    <div class="profile-title">

        <span>حسابي</span>

        <h1>الملف الشخصي</h1>

        <p>
            @if ($isProvider)
                أضف معلوماتك ومهاراتك حتى يستطيع الآخرون التعرف عليك.
            @else
                حدّث بيانات حسابك الشخصية لإدارة طلباتك والتواصل مع أصحاب المهارات.
            @endif
        </p>

    </div>


    {{-- رسالة النجاح --}}
    @if (session('status'))

        <div class="profile-success">
            {{ session('status') }}
        </div>

    @endif


    {{-- أخطاء عامة --}}
    @if ($errors->any())

        <div class="profile-error-box">

            <strong>
                يرجى تصحيح الأخطاء التالية:
            </strong>

            <ul>

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <section class="profile-card">


        {{-- ============================= --}}
        {{-- صورة الملف الشخصي --}}
        {{-- ============================= --}}

        <div class="profile-avatar-section">

            <div class="profile-avatar">

                @if ($profile->avatar)

                    <img
                        id="avatarPreview"
                        src="{{ asset('storage/' . $profile->avatar) }}"
                        alt="صورة الملف الشخصي"
                    >

                @else

                    <span id="avatarInitial">
                        {{ strtoupper(substr($user->name ?? 'N', 0, 1)) }}
                    </span>

                    <img
                        id="avatarPreview"
                        src=""
                        alt="صورة الملف الشخصي"
                        style="display: none;"
                    >

                @endif

            </div>


            <h2>
                {{ $user->name ?? 'المستخدم' }}
            </h2>


            <p>
                {{ $user->email ?? 'example@email.com' }}
            </p>


            {{-- اختيار الصورة --}}
            <button
                type="button"
                class="change-photo-btn"
                onclick="document.getElementById('avatar').click()"
            >
                تغيير الصورة
            </button>


            {{-- حقل الصورة المخفي --}}
            <input
                type="file"
                id="avatar"
                name="avatar"
                accept="image/jpeg,image/png,image/webp"
                form="profile-form"
                hidden
            >


            <small id="selectedFileName"></small>

        </div>



        {{-- ============================= --}}
        {{-- المعلومات --}}
        {{-- ============================= --}}

        <div class="profile-form">

            <div class="profile-section-heading">

                <h2>
                    المعلومات الأساسية
                </h2>

                <p>
                    يمكنك تعديل معلوماتك الشخصية من هنا.
                </p>

            </div>


            <form
                id="profile-form"
                method="POST"
                action="{{ route('profile.update') }}"
                enctype="multipart/form-data"
            >

                @csrf

                @method('PATCH')


                <div class="profile-grid">


                    {{-- الاسم --}}
                    <div class="profile-field">

                        <label for="name">
                            الاسم
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            placeholder="اكتب اسمك"
                        >

                        @error('name')

                            <small class="profile-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- البريد --}}
                    <div class="profile-field">

                        <label for="email">
                            البريد الإلكتروني
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            placeholder="example@email.com"
                        >

                        @error('email')

                            <small class="profile-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- الهاتف --}}
                    <div class="profile-field">

                        <label for="phone">
                            رقم الهاتف
                        </label>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="{{ old('phone', $profile->phone) }}"
                            placeholder="أدخل رقم الهاتف"
                        >

                        @error('phone')

                            <small class="profile-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    @if($isProvider)
                    <div class="profile-field">
                        <label for="governorate">المحافظة (إجباري)</label>
                        <input type="text" id="governorate" name="governorate"
                            value="{{ old('governorate', $profile->governorate) }}"
                            placeholder="مثال: صنعاء" maxlength="100" required>
                        @error('governorate')<small class="profile-error">{{ $message }}</small>@enderror
                    </div>
                    <div class="profile-field">
                        <label for="district">المديرية أو المنطقة (اختياري)</label>
                        <input type="text" id="district" name="district"
                            value="{{ old('district', $profile->district) }}"
                            placeholder="مثال: السبعين" maxlength="100">
                        @error('district')<small class="profile-error">{{ $message }}</small>@enderror
                    </div>
                    <div class="profile-field">
                        <label for="street">الشارع أو وصف المكان (اختياري)</label>
                        <input type="text" id="street" name="street"
                            value="{{ old('street', $profile->street) }}"
                            placeholder="مثال: شارع حدة" maxlength="255">
                        @error('street')<small class="profile-error">{{ $message }}</small>@enderror
                    </div>
                    @else
                    {{-- موقع العميل الحالي --}}
                    <div class="profile-field">

                        <label for="location">
                            المدينة / الموقع
                        </label>

                        <input
                            type="text"
                            id="location"
                            name="location"
                            value="{{ old('location', $profile->location) }}"
                            placeholder="أدخل مدينتك"
                        >

                        @error('location')

                            <small class="profile-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>
                    @endif

                </div>


                @if ($isProvider)
                {{-- ============================= --}}
                {{-- طرق التواصل الاختيارية لصاحب المهارة --}}
                {{-- ============================= --}}

                <div class="profile-section-heading" style="margin-top: 32px;">

                    <h2>
                        طرق التواصل
                    </h2>

                    <p>
                        هذه البيانات اختيارية، ولن يظهر أي خيار تواصل في ملفك العام إلا إذا قمت بإضافته.
                    </p>

                </div>


                <div class="profile-grid">

                    {{-- رقم الاتصال العام --}}
                    <div class="profile-field">

                        <label for="contact_phone">
                            رقم الاتصال العام
                            <span style="opacity: .6;">(اختياري)</span>
                        </label>

                        <input
                            type="text"
                            id="contact_phone"
                            name="contact_phone"
                            value="{{ old('contact_phone', $profile->contact_phone) }}"
                            placeholder="مثال: +967777123456"
                            dir="ltr"
                        >

                        @error('contact_phone')

                            <small class="profile-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- واتساب --}}
                    <div class="profile-field">

                        <label for="whatsapp">
                            رقم واتساب
                            <span style="opacity: .6;">(اختياري)</span>
                        </label>

                        <input
                            type="text"
                            id="whatsapp"
                            name="whatsapp"
                            value="{{ old('whatsapp', $profile->whatsapp) }}"
                            placeholder="مثال: +967777123456"
                            dir="ltr"
                        >

                        @error('whatsapp')

                            <small class="profile-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- تليجرام --}}
                    <div class="profile-field">

                        <label for="telegram_username">
                            اسم مستخدم تليجرام
                            <span style="opacity: .6;">(اختياري)</span>
                        </label>

                        <input
                            type="text"
                            id="telegram_username"
                            name="telegram_username"
                            value="{{ old('telegram_username', $profile->telegram_username) }}"
                            placeholder="@username"
                            dir="ltr"
                        >

                        @error('telegram_username')

                            <small class="profile-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>

                </div>


                {{-- نبذة عني --}}
                <div class="profile-field profile-full">

                    <label for="bio_ar">
                        نبذة عني
                    </label>

                    <textarea
                        id="bio_ar"
                        name="bio_ar"
                        rows="5"
                        placeholder="اكتب نبذة قصيرة عن مهاراتك وخبراتك..."
                    >{{ old('bio_ar', $profile->bio_ar) }}</textarea>

                    @error('bio_ar')

                        <small class="profile-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>
                @endif


                {{-- الأزرار --}}
                <div class="profile-actions">

                    <a
                        href="{{ route('dashboard') }}"
                        class="profile-cancel"
                    >
                        إلغاء
                    </a>


                    <button
                        type="submit"
                        class="profile-save"
                    >
                        حفظ التغييرات
                    </button>

                </div>

            </form>

        </div>

    </section>

</div>


{{-- معاينة الصورة قبل الحفظ --}}
<script>

    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.getElementById('avatarPreview');
    const avatarInitial = document.getElementById('avatarInitial');
    const selectedFileName = document.getElementById('selectedFileName');

    if (avatarInput) {

        avatarInput.addEventListener('change', function () {

            const file = this.files[0];

            if (!file) {
                return;
            }

            // إظهار اسم الملف
            selectedFileName.textContent = file.name;

            // معاينة الصورة
            const reader = new FileReader();

            reader.onload = function (event) {

                avatarPreview.src = event.target.result;
                avatarPreview.style.display = 'block';

                if (avatarInitial) {
                    avatarInitial.style.display = 'none';
                }

            };

            reader.readAsDataURL(file);

        });

    }

</script>

@endsection
