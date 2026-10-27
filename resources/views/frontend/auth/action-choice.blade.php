@extends('layouts.frontend.public')

@section('title', 'متابعة العملية | NASEJA')

@section('content')

<div style="
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
">

    <div style="
        width: 100%;
        max-width: 520px;
        background: #ffffff;
        border-radius: 24px;
        padding: 40px 30px;
        text-align: center;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    ">

        {{-- الأيقونة --}}

        <div style="
            width: 70px;
            height: 70px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: #fff1f2;
            display: flex;
            align-items: center;
            justify-content: center;
        ">

            <i
                data-lucide="heart"
                style="
                    width: 34px;
                    height: 34px;
                    color: #e11d48;
                "
            ></i>

        </div>


        {{-- العنوان --}}

        <h1 style="
            margin: 0 0 12px;
            font-size: 28px;
            color: #222;
        ">
            أكمل تفاعلك مع صاحب المهارة ❤️
        </h1>


        {{-- الوصف --}}

        <p style="
            margin: 0 auto 30px;
            max-width: 420px;
            line-height: 1.9;
            color: #666;
            font-size: 16px;
        ">
            حتى تتمكن من الإعجاب والتواصل مع أصحاب المهارات،
            اختر الطريقة المناسبة لك.
        </p>


        {{-- تسجيل الدخول --}}

        <a
            href="{{ route('login') }}"
            style="
                display: block;
                width: 100%;
                padding: 14px 20px;
                margin-bottom: 14px;
                border-radius: 12px;
                background: #222;
                color: #fff;
                text-decoration: none;
                font-size: 16px;
                font-weight: 600;
                box-sizing: border-box;
            "
        >
            لدي حساب — تسجيل الدخول
        </a>


        {{-- إنشاء حساب --}}

        <a
            href="{{ route('register') }}"
            style="
                display: block;
                width: 100%;
                padding: 14px 20px;
                border-radius: 12px;
                border: 1px solid #ddd;
                background: #fff;
                color: #222;
                text-decoration: none;
                font-size: 16px;
                font-weight: 600;
                box-sizing: border-box;
            "
        >
            ليس لدي حساب — إنشاء حساب
        </a>


        {{-- العودة --}}

        <a
            href="{{ route('explore') }}"
            style="
                display: inline-block;
                margin-top: 22px;
                color: #777;
                text-decoration: none;
                font-size: 14px;
            "
        >
            ← العودة إلى الاستكشاف
        </a>

    </div>

</div>

@endsection