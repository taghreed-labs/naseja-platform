@extends('layouts.admin.admin')

@section('title', 'الإعدادات')
@section('page-title', 'الإعدادات')

@section('content')

<div class="admin-page-heading">

    <div>

        <h1>
            إعدادات الإدارة
        </h1>

        <p>
            إدارة بيانات حساب مدير النظام وإعدادات الأمان.
        </p>

    </div>

</div>



{{-- =========================================================
     الرسائل
========================================================= --}}

@if(session('success'))

    <div class="settings-alert success">

        <i data-lucide="circle-check"></i>

        <span>
            {{ session('success') }}
        </span>

    </div>

@endif


@if($errors->any())

    <div class="settings-alert error">

        <i data-lucide="circle-alert"></i>

        <div>

            @foreach($errors->all() as $error)

                <div>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    </div>

@endif



<div class="admin-settings-grid">


    {{-- =====================================================
         بيانات الحساب
    ===================================================== --}}

    <section class="admin-card settings-card">

        <div class="settings-card-head">

            <div class="settings-card-icon blue">
                <i data-lucide="user-round-cog"></i>
            </div>

            <div>

                <h2>
                    بيانات حساب الإدارة
                </h2>

                <p>
                    الاسم والبريد الإلكتروني المستخدمان لحساب المدير.
                </p>

            </div>

        </div>


        <form
            method="POST"
            action="{{ route('admin.settings.profile.update') }}"
            class="settings-form"
        >

            @csrf
            @method('PATCH')


            <div class="settings-field">

                <label for="adminName">
                    الاسم
                </label>

                <div class="settings-input-wrap">

                    <i data-lucide="user-round"></i>

                    <input
                        id="adminName"
                        type="text"
                        name="name"
                        value="{{ old('name', $admin->name) }}"
                        required
                        maxlength="255"
                        autocomplete="name"
                    >

                </div>

            </div>


            <div class="settings-field">

                <label for="adminEmail">
                    البريد الإلكتروني
                </label>

                <div class="settings-input-wrap">

                    <i data-lucide="mail"></i>

                    <input
                        id="adminEmail"
                        type="email"
                        name="email"
                        value="{{ old('email', $admin->email) }}"
                        required
                        maxlength="255"
                        autocomplete="email"
                    >

                </div>

            </div>


            <div class="settings-account-meta">

                <div>

                    <span>
                        حالة الحساب
                    </span>

                    <strong class="active">
                        {{ $admin->status === 'active' ? 'نشط' : $admin->status }}
                    </strong>

                </div>


                <div>

                    <span>
                        آخر دخول
                    </span>

                    <strong>

                        @if($admin->last_login_at)

                            {{
                                \Illuminate\Support\Carbon::parse(
                                    $admin->last_login_at
                                )->format('Y/m/d - H:i')
                            }}

                        @else

                            غير مسجل

                        @endif

                    </strong>

                </div>

            </div>


            <button
                type="submit"
                class="settings-submit primary"
            >

                <i data-lucide="save"></i>

                حفظ البيانات

            </button>

        </form>

    </section>



    {{-- =====================================================
         كلمة المرور
    ===================================================== --}}

    <section class="admin-card settings-card">

        <div class="settings-card-head">

            <div class="settings-card-icon lavender">
                <i data-lucide="shield-check"></i>
            </div>

            <div>

                <h2>
                    كلمة المرور
                </h2>

                <p>
                    استخدم كلمة مرور قوية ومختلفة عن كلمات مرورك الأخرى.
                </p>

            </div>

        </div>


        <form
            method="POST"
            action="{{ route('admin.settings.password.update') }}"
            class="settings-form"
        >

            @csrf
            @method('PATCH')


            <div class="settings-field">

                <label for="currentPassword">
                    كلمة المرور الحالية
                </label>

                <div class="settings-input-wrap">

                    <i data-lucide="lock-keyhole"></i>

                    <input
                        id="currentPassword"
                        type="password"
                        name="current_password"
                        required
                        autocomplete="current-password"
                    >

                </div>

            </div>


            <div class="settings-field">

                <label for="newPassword">
                    كلمة المرور الجديدة
                </label>

                <div class="settings-input-wrap">

                    <i data-lucide="key-round"></i>

                    <input
                        id="newPassword"
                        type="password"
                        name="password"
                        required
                        minlength="8"
                        autocomplete="new-password"
                    >

                </div>

            </div>


            <div class="settings-field">

                <label for="passwordConfirmation">
                    تأكيد كلمة المرور الجديدة
                </label>

                <div class="settings-input-wrap">

                    <i data-lucide="check-check"></i>

                    <input
                        id="passwordConfirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        minlength="8"
                        autocomplete="new-password"
                    >

                </div>

            </div>


            <div class="settings-security-note">

                <i data-lucide="info"></i>

                <span>
                    الحد الأدنى لكلمة المرور الجديدة هو 8 أحرف.
                </span>

            </div>


            <button
                type="submit"
                class="settings-submit secondary"
                onclick="return confirm('هل تريد تغيير كلمة مرور حساب الإدارة؟')"
            >

                <i data-lucide="shield-check"></i>

                تغيير كلمة المرور

            </button>

        </form>

    </section>


</div>



{{-- =========================================================
     معلومات إدارية
========================================================= --}}

<section class="admin-card settings-info-card">

    <div class="settings-info-icon">
        <i data-lucide="shield"></i>
    </div>

    <div>

        <h3>
            حساب مدير النظام
        </h3>

        <p>
            هذا الحساب مخصص لإدارة NASEJA فقط. لا تشارك بيانات الدخول،
            وغيّر كلمة المرور الافتراضية قبل نشر المشروع على خادم فعلي.
        </p>

    </div>

</section>

@endsection



@push('styles')

<style>

    .settings-alert {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        padding: 12px 15px;
        margin-bottom: 16px;
        border-radius: 14px;
        font-size: 10.5px;
        font-weight: 700;
    }

    .settings-alert svg {
        width: 17px;
        height: 17px;
        flex-shrink: 0;
    }

    .settings-alert.success {
        background: #eaf8f2;
        border: 1px solid #d5eee4;
        color: #268566;
    }

    .settings-alert.error {
        background: #fff0f1;
        border: 1px solid #f2d8db;
        color: #ce5059;
    }


    .admin-settings-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .settings-card {
        padding: 20px;
    }

    .settings-card-head {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 16px;
        border-bottom: 1px solid #edf1f6;
    }

    .settings-card-icon {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 14px;
    }

    .settings-card-icon svg {
        width: 20px;
        height: 20px;
    }

    .settings-card-icon.blue {
        background: #edf2ff;
        color: #5874dd;
    }

    .settings-card-icon.lavender {
        background: #f2eeff;
        color: #7560ca;
    }

    .settings-card-head h2 {
        margin: 0;
        color: #394459;
        font-size: 13px;
        font-weight: 900;
    }

    .settings-card-head p {
        margin: 4px 0 0;
        color: #949eae;
        font-size: 8.5px;
        line-height: 1.7;
    }


    .settings-form {
        display: grid;
        gap: 14px;
        margin-top: 17px;
    }

    .settings-field label {
        display: block;
        margin-bottom: 7px;
        color: #657185;
        font-size: 9px;
        font-weight: 800;
    }

    .settings-input-wrap {
        height: 43px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0 11px;
        border: 1px solid #e5eaf1;
        border-radius: 12px;
        background: #fafbfe;
        transition: .18s ease;
    }

    .settings-input-wrap:focus-within {
        border-color: #b9c6f7;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(91, 124, 255, .07);
    }

    .settings-input-wrap svg {
        width: 15px;
        height: 15px;
        flex-shrink: 0;
        color: #9aa4b4;
    }

    .settings-input-wrap input {
        width: 100%;
        border: 0;
        outline: 0;
        background: transparent;
        color: #4c586d;
        font-family: inherit;
        font-size: 9.5px;
    }


    .settings-account-meta {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 9px;
    }

    .settings-account-meta > div {
        padding: 11px;
        border: 1px solid #edf0f5;
        border-radius: 11px;
        background: #fafbfe;
    }

    .settings-account-meta span {
        display: block;
        margin-bottom: 4px;
        color: #99a3b2;
        font-size: 8px;
    }

    .settings-account-meta strong {
        color: #586477;
        font-size: 8.7px;
        font-weight: 900;
    }

    .settings-account-meta strong.active {
        color: #268566;
    }


    .settings-security-note {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 10px 11px;
        border-radius: 11px;
        background: #f6f7fb;
        color: #7d8798;
        font-size: 8px;
    }

    .settings-security-note svg {
        width: 13px;
        height: 13px;
        flex-shrink: 0;
    }


    .settings-submit {
        min-height: 41px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        border: 0;
        border-radius: 11px;
        cursor: pointer;
        font-family: inherit;
        font-size: 9.5px;
        font-weight: 900;
    }

    .settings-submit svg {
        width: 15px;
        height: 15px;
    }

    .settings-submit.primary {
        background: #5b7cff;
        color: #fff;
    }

    .settings-submit.secondary {
        background: #7462ca;
        color: #fff;
    }


    .settings-info-card {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-top: 16px;
        padding: 17px;
    }

    .settings-info-icon {
        width: 41px;
        height: 41px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 12px;
        background: #eaf8f2;
        color: #268566;
    }

    .settings-info-icon svg {
        width: 18px;
        height: 18px;
    }

    .settings-info-card h3 {
        margin: 0;
        color: #3f4a5e;
        font-size: 10.5px;
        font-weight: 900;
    }

    .settings-info-card p {
        max-width: 700px;
        margin: 5px 0 0;
        color: #8b96a7;
        font-size: 8.5px;
        line-height: 1.8;
    }


    @media(max-width: 850px) {

        .admin-settings-grid {
            grid-template-columns: 1fr;
        }

    }


    @media(max-width: 500px) {

        .settings-account-meta {
            grid-template-columns: 1fr;
        }

    }

</style>

@endpush
