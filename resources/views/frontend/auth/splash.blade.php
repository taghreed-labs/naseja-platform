
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&amp;display=swap" rel="stylesheet">

    <title>NASEJA</title>

    <meta name="description" content="انضم إلى نسيجة لاكتشاف المهارات والخدمات والتواصل مع أصحاب المهارات، أو اعرض مهاراتك وخدماتك للعملاء.">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {

            min-height: 100vh;

            overflow: hidden;

            font-family:
                "Cairo",
                "Segoe UI",
                Tahoma,
                Arial,
                sans-serif;

            background:
                radial-gradient(
                    circle at 15% 20%,
                    rgba(139,124,246,.35),
                    transparent 28%
                ),

                radial-gradient(
                    circle at 85% 75%,
                    rgba(0,201,167,.18),
                    transparent 25%
                ),

                linear-gradient(
                    135deg,
                    #4532bd 0%,
                    #6657e8 48%,
                    #7569ee 100%
                );

            color: white;
        }


        /* =========================================
           SPLASH
        ========================================= */

        .splash {

            position: relative;

            width: 100%;
            min-height: 100vh;

            display: flex;

            align-items: center;
            justify-content: center;

            overflow: hidden;
        }


        /* =========================================
           BACKGROUND SPHERES
        ========================================= */

        .sphere {

            position: absolute;

            border-radius: 50%;

            pointer-events: none;

            background:
                radial-gradient(
                    circle at 30% 25%,
                    rgba(255,255,255,.30),
                    rgba(255,255,255,.10) 35%,
                    rgba(255,255,255,.02) 70%
                );

            box-shadow:
                inset -35px -35px 80px rgba(0,0,0,.12),
                20px 30px 80px rgba(0,0,0,.15);

            animation:
                sphereFloat 8s ease-in-out infinite;
        }


        .sphere-one {

            width: 430px;
            height: 430px;

            top: -270px;
            right: -120px;
        }


        .sphere-two {

            width: 260px;
            height: 260px;

            bottom: -170px;
            left: -100px;

            opacity: .45;

            animation-delay: -3s;
        }


        .sphere-three {

            width: 90px;
            height: 90px;

            top: 18%;
            left: 12%;

            opacity: .25;

            animation-delay: -5s;
        }


        @keyframes sphereFloat {

            0%,
            100% {
                transform:
                    translateY(0)
                    rotate(0deg);
            }

            50% {
                transform:
                    translateY(-22px)
                    rotate(6deg);
            }
        }


        /* =========================================
           CENTER CONTENT
        ========================================= */

        .content {

            position: relative;

            z-index: 10;

            width: min(420px, 90%);

            padding: 50px 35px 42px;

            text-align: center;

            border-radius: 32px;

            background:
                rgba(255,255,255,.08);

            border:
                1px solid rgba(255,255,255,.18);

            backdrop-filter: blur(18px);

            -webkit-backdrop-filter: blur(18px);

            box-shadow:
                0 35px 90px rgba(0,0,0,.18),
                inset 0 1px 1px rgba(255,255,255,.20);

            opacity: 1;
        }


        /* =========================================
           LOGO
        ========================================= */

        .logo {

            width: 88px;
            height: 88px;

            margin: 0 auto 24px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 26px;

            font-size: 42px;

            font-weight: 900;

            background:
                linear-gradient(
                    145deg,
                    rgba(255,255,255,.30),
                    rgba(255,255,255,.08)
                );

            border:
                1px solid rgba(255,255,255,.32);

            box-shadow:
                0 20px 45px rgba(0,0,0,.20),
                inset 0 1px 2px rgba(255,255,255,.45);

            animation:
                logoFloat 3s ease-in-out infinite;
        }


        @keyframes logoFloat {

            0%,
            100% {
                transform:
                    translateY(0)
                    rotateY(-5deg);
            }

            50% {
                transform:
                    translateY(-7px)
                    rotateY(5deg);
            }
        }


        /* =========================================
           BRAND NAME
        ========================================= */

        .content h1 {

            font-size: 43px;

            line-height: 1;

            letter-spacing: 4px;

            margin-bottom: 14px;

            font-weight: 800;
        }


        .content p {

            font-size: 15px;

            color:
                rgba(255,255,255,.78);

            margin-bottom: 30px;
        }


        /* =========================================
           SMALL DESCRIPTION
        ========================================= */

        .tagline {

            display: inline-block;

            padding: 8px 16px;

            border-radius: 50px;

            background:
                rgba(255,255,255,.09);

            border:
                1px solid rgba(255,255,255,.14);

            color:
                rgba(255,255,255,.88);

            font-size: 12px;

            margin-bottom: 28px;
        }


        /* =========================================
           LOADING
        ========================================= */

        .loading {

            width: 170px;
            height: 4px;

            margin: 0 auto;

            overflow: hidden;

            border-radius: 50px;

            background:
                rgba(255,255,255,.15);
        }


        .loading::after {

            content: "";

            display: block;

            width: 45%;
            height: 100%;

            border-radius: inherit;

            background:
                rgba(255,255,255,.95);

            box-shadow:
                0 0 12px rgba(255,255,255,.7);

            animation:
                loading 1.5s ease-in-out infinite;
        }


        @keyframes loading {

            0% {
                transform: translateX(230%);
            }

            100% {
                transform: translateX(-230%);
            }
        }


        /* =========================================
           ENTER ANIMATION
        ========================================= */

        @keyframes contentAppear {

            from {

                opacity: 0;

                transform:
                    translateY(25px)
                    scale(.95);
            }

            to {

                opacity: 1;

                transform:
                    translateY(0)
                    scale(1);
            }
        }


        /* =========================================
           MOBILE
        ========================================= */

        @media (max-width: 600px) {

            .content {

                width: calc(100% - 30px);

                padding:
                    42px 25px 36px;

                border-radius: 27px;
            }


            .logo {

                width: 76px;
                height: 76px;

                border-radius: 23px;

                font-size: 36px;
            }


            .content h1 {

                font-size: 36px;

                letter-spacing: 3px;
            }


            .content p {

                font-size: 14px;
            }


            .sphere-one {

                width: 300px;
                height: 300px;

                top: -190px;
                right: -100px;
            }


            .sphere-two {

                width: 190px;
                height: 190px;

                bottom: -120px;
                left: -80px;
            }


            .sphere-three {

                display: none;
            }
        }

    
        /* NASEJA account type chooser */
        .account-choice-title {
            margin: 0 0 8px;
            font-size: 25px;
            font-weight: 800;
        }

        .account-choice-subtitle {
            margin: 0 auto 22px !important;
            max-width: 340px;
            font-size: 12px !important;
            line-height: 1.8;
        }

        .account-choices {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 11px;
            margin-top: 5px;
        }

        .account-choice {
            display: block;
            padding: 17px 12px;
            border: 1px solid rgba(255,255,255,.20);
            border-radius: 17px;
            color: #fff;
            background: rgba(255,255,255,.09);
            text-decoration: none;
            transition: .2s ease;
        }

        .account-choice:hover {
            transform: translateY(-3px);
            background: rgba(255,255,255,.17);
            border-color: rgba(255,255,255,.38);
        }

        .account-choice-icon {
            width: 43px;
            height: 43px;
            margin: 0 auto 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: rgba(255,255,255,.14);
            font-size: 21px;
            font-weight: 800;
        }

        .account-choice strong {
            display: block;
            margin-bottom: 4px;
            font-size: 13px;
        }

        .account-choice small {
            display: block;
            color: rgba(255,255,255,.72);
            font-size: 8.5px;
            line-height: 1.6;
        }

        .choice-login {
            margin-top: 17px !important;
            margin-bottom: 0 !important;
            font-size: 9px !important;
        }

        .choice-login a {
            color: #fff;
            font-weight: 800;
        }

        @media (max-width: 600px) {
            .account-choices {
                grid-template-columns: 1fr;
            }
        }

    </style>

</head>


<body>


    <div class="splash">


        <!-- الخلفيات ثلاثية الأبعاد -->

        <div class="sphere sphere-one"></div>

        <div class="sphere sphere-two"></div>

        <div class="sphere sphere-three"></div>


        <!-- المحتوى الرئيسي -->

        <div class="content">


            <!-- الشعار -->

            <div class="logo">
                N
            </div>


            <!-- اسم المنصة -->

            <h1>
                NASEJA
            </h1>


            <!-- الوصف -->

            <p>
                منصة المهارات والخدمات
            </p>


            <!-- عبارة صغيرة -->

            <div class="tagline">
                اكتشف مهارتك وشاركها مع العالم
            </div>


            <!-- التحميل -->

                        <h2 class="account-choice-title">
                كيف تريد استخدام نسيجة؟
            </h2>

            <p class="account-choice-subtitle">
                اختر نوع الحساب المناسب لك
            </p>

            <div class="account-choices">

                <a
                    href="{{ route('register', ['type' => 'provider']) }}"
                    class="account-choice"
                >
                    <div class="account-choice-icon">✦</div>
                    <strong>صاحب مهارة</strong>
                    <small>أعرض مهاراتي وخدماتي وأعمالي للعملاء</small>
                </a>

                <a
                    href="{{ route('register', ['type' => 'customer']) }}"
                    class="account-choice"
                >
                    <div class="account-choice-icon">⌕</div>
                    <strong>عميل</strong>
                    <small>أبحث عن خدمة وأتواصل مع أصحاب المهارات</small>
                </a>

            </div>

            <p class="choice-login">
                لديك حساب بالفعل؟
                <a href="{{ route('login') }}">تسجيل الدخول</a>
            </p>


        </div>

    </div>


    <!-- الانتقال إلى Register -->
</body>

</html>

