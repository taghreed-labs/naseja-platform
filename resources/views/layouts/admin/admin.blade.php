<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'لوحة الإدارة') | NASEJA
    </title>


    {{-- Tajawal Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    >


    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }


        :root {

            --primary: #5b7cff;
            --primary-dark: #3f5ed7;
            --primary-soft: #eef2ff;

            --purple: #8b6cf6;
            --purple-soft: #f3efff;

            --green: #27a879;
            --green-soft: #eaf8f3;

            --orange: #f1a53a;
            --orange-soft: #fff5e7;

            --red: #e95b63;
            --red-soft: #fff0f1;

            --background: #f5f7fb;
            --surface: #ffffff;

            --text: #1d2638;
            --muted: #8994a6;

            --border: #e8edf5;

            --sidebar-width: 272px;
        }


        html {
            scroll-behavior: smooth;
        }


        body {

            min-height: 100vh;

            background:
                radial-gradient(
                    circle at 85% 0%,
                    rgba(91, 124, 255, .05),
                    transparent 30%
                ),
                #f5f7fb;

            color: var(--text);

            font-family: 'Tajawal', Arial, sans-serif;
        }


        button,
        input,
        select,
        textarea {

            font-family: 'Tajawal', Arial, sans-serif;
        }


        a {
            color: inherit;
            text-decoration: none;
        }


        /* =====================================================
           SIDEBAR
        ===================================================== */

        .admin-sidebar {

            position: fixed;

            top: 16px;
            right: 16px;
            bottom: 16px;

            width: var(--sidebar-width);

            display: flex;
            flex-direction: column;

            padding: 18px 14px;

            background:
                rgba(255, 255, 255, .96);

            border:
                1px solid rgba(225, 231, 241, .95);

            border-radius: 25px;

            box-shadow:
                0 20px 55px rgba(38, 52, 82, .07);

            overflow-y: auto;

            z-index: 1000;
        }


        .admin-brand {

            display: flex;
            align-items: center;

            gap: 12px;

            padding: 7px 10px 22px;

            margin-bottom: 12px;

            border-bottom:
                1px solid var(--border);
        }


        .admin-brand-logo {

            width: 49px;
            height: 49px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 16px;

            background:
                linear-gradient(
                    135deg,
                    #587cff,
                    #8b6cf6
                );

            color: #ffffff;

            font-size: 21px;
            font-weight: 900;

            box-shadow:
                0 10px 25px rgba(91, 124, 255, .25);
        }


        .admin-brand-info strong {

            display: block;

            font-size: 19px;
            font-weight: 900;

            letter-spacing: .4px;
        }


        .admin-brand-info span {

            display: block;

            margin-top: 3px;

            color: var(--muted);

            font-size: 10px;
            font-weight: 600;
        }


        .admin-menu-label {

            padding: 0 12px;

            margin: 17px 0 7px;

            color: #acb5c3;

            font-size: 10px;
            font-weight: 800;
        }


        .admin-nav {

            display: flex;
            flex-direction: column;

            gap: 5px;
        }


        .admin-nav-item {

            min-height: 48px;

            display: flex;
            align-items: center;

            gap: 11px;

            padding: 0 12px;

            border-radius: 14px;

            color: #687589;

            font-size: 13px;
            font-weight: 700;

            transition: .2s ease;
        }


        .admin-nav-item:hover {

            background: #f5f7fc;

            color: var(--primary-dark);

            transform: translateX(-2px);
        }


        .admin-nav-item.active {

            color: var(--primary-dark);

            background:
                linear-gradient(
                    135deg,
                    #edf2ff,
                    #f4f0ff
                );
        }


        .admin-nav-icon {

            width: 34px;
            height: 34px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 11px;

            background: #f5f7fb;

            color: #8995a8;

            transition: .2s;
        }


        .admin-nav-icon svg {

            width: 18px;
            height: 18px;

            stroke-width: 1.9;
        }


        .admin-nav-item:hover .admin-nav-icon {

            background: #edf2ff;

            color: var(--primary);
        }


        .admin-nav-item.active .admin-nav-icon {

            background: #ffffff;

            color: var(--primary);

            box-shadow:
                0 6px 16px rgba(91, 124, 255, .13);
        }


        .admin-nav-text {
            flex: 1;
        }


        .admin-badge {

            min-width: 24px;
            height: 22px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 0 7px;

            border-radius: 20px;

            background: #eef2f7;

            color: #8994a5;

            font-size: 9px;
            font-weight: 800;
        }


        .admin-logout {

            margin-top: auto;

            padding-top: 19px;

            border-top:
                1px solid var(--border);
        }


        .admin-logout-button {

            width: 100%;
            height: 47px;

            display: flex;
            align-items: center;

            gap: 11px;

            padding: 0 13px;

            border: 0;
            border-radius: 14px;

            background: var(--red-soft);

            color: #d64d56;

            font-size: 13px;
            font-weight: 800;

            cursor: pointer;

            transition: .2s;
        }


        .admin-logout-button:hover {

            background: #ffe6e8;
        }


        /* =====================================================
           MAIN
        ===================================================== */

        .admin-main {

            min-height: 100vh;

            margin-right:
                calc(var(--sidebar-width) + 32px);

            padding:
                16px 16px 40px 0;
        }


        /* =====================================================
           TOPBAR
        ===================================================== */

        .admin-topbar {

            min-height: 76px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            padding: 13px 20px;

            background:
                rgba(255, 255, 255, .93);

            border:
                1px solid var(--border);

            border-radius: 22px;

            box-shadow:
                0 12px 35px rgba(36, 49, 75, .04);
        }


        .admin-topbar-right {

            display: flex;
            align-items: center;

            gap: 12px;
        }


        .admin-page-info h2 {

            font-size: 17px;
            font-weight: 900;
        }


        .admin-page-info p {

            margin-top: 4px;

            color: var(--muted);

            font-size: 10px;
            font-weight: 600;
        }


        .admin-topbar-left {

            display: flex;
            align-items: center;

            gap: 10px;
        }


        .admin-search {

            width: 230px;
            height: 43px;

            display: flex;
            align-items: center;

            gap: 8px;

            padding: 0 13px;

            background: #f7f9fc;

            border:
                1px solid #edf1f6;

            border-radius: 13px;
        }


        .admin-search svg {

            width: 17px;
            height: 17px;

            color: #99a4b4;
        }


        .admin-search input {

            width: 100%;

            border: 0;
            outline: 0;

            background: transparent;

            color: var(--text);

            font-size: 11px;
        }


        .admin-top-action {

            width: 43px;
            height: 43px;

            display: flex;
            align-items: center;
            justify-content: center;

            border:
                1px solid var(--border);

            border-radius: 13px;

            background: #ffffff;

            color: #7f8a9d;
        }


        .admin-top-action svg {

            width: 18px;
            height: 18px;
        }


        .admin-user {

            display: flex;
            align-items: center;

            gap: 10px;

            margin-right: 4px;
        }


        .admin-avatar {

            width: 43px;
            height: 43px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 14px;

            background:
                linear-gradient(
                    135deg,
                    #eaf0ff,
                    #f3edff
                );

            color: #4e67ce;

            font-size: 15px;
            font-weight: 900;
        }


        .admin-user-info strong {

            display: block;

            max-width: 155px;

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;

            color: #374156;

            font-size: 11px;
            font-weight: 800;
        }


        .admin-user-info span {

            display: block;

            margin-top: 3px;

            color: var(--muted);

            font-size: 9px;
        }


        /* =====================================================
           CONTENT
        ===================================================== */

        .admin-content {

            padding:
                26px 5px 10px;
        }


        .admin-page-heading {

            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 23px;
        }


        .admin-page-heading h1 {

            font-size: 25px;
            font-weight: 900;
        }


        .admin-page-heading p {

            margin-top: 6px;

            color: var(--muted);

            font-size: 11px;
            line-height: 1.8;
        }


        .admin-status-tag {

            display: inline-flex;
            align-items: center;

            gap: 7px;

            padding: 8px 12px;

            background: #ffffff;

            border:
                1px solid var(--border);

            border-radius: 12px;

            color: #728095;

            font-size: 10px;
            font-weight: 700;
        }


        .admin-status-dot {

            width: 7px;
            height: 7px;

            display: inline-block;

            border-radius: 50%;

            background: #2eb67d;

            box-shadow:
                0 0 0 4px rgba(46, 182, 125, .10);
        }


        .admin-card {

            background: #ffffff;

            border:
                1px solid var(--border);

            border-radius: 21px;

            box-shadow:
                0 12px 35px rgba(31, 44, 72, .04);
        }


        /* =====================================================
           MOBILE
        ===================================================== */

        .admin-mobile-menu {

            display: none;
        }


        @media (max-width: 1000px) {

            .admin-sidebar {

                transform:
                    translateX(120%);

                transition: .25s;
            }


            .admin-sidebar.open {

                transform:
                    translateX(0);
            }


            .admin-main {

                margin-right: 0;

                padding: 12px;
            }


            .admin-mobile-menu {

                width: 42px;
                height: 42px;

                display: flex;
                align-items: center;
                justify-content: center;

                border:
                    1px solid var(--border);

                border-radius: 13px;

                background: #ffffff;

                color: #6f7a8d;

                cursor: pointer;
            }


            .admin-mobile-menu svg {

                width: 19px;
                height: 19px;
            }


            .admin-search {
                display: none;
            }
        }


        @media (max-width: 600px) {

            .admin-user-info {
                display: none;
            }


            .admin-topbar {

                padding:
                    12px 13px;
            }


            .admin-content {

                padding:
                    20px 2px;
            }


            .admin-page-heading {

                flex-direction: column;
                align-items: flex-start;
            }
        }

    </style>


    @stack('styles')

</head>


<body>


{{-- ============================================================
     SIDEBAR
============================================================ --}}

<aside
    class="admin-sidebar"
    id="adminSidebar"
>

    <div class="admin-brand">

        <div class="admin-brand-logo">
            N
        </div>


        <div class="admin-brand-info">

            <strong>
                NASEJA
            </strong>

            <span>
                لوحة إدارة المنصة
            </span>

        </div>

    </div>


    <div class="admin-menu-label">
        الرئيسية
    </div>


    <nav class="admin-nav">


        {{-- لوحة التحكم --}}

        <a
            href="{{ route('admin.dashboard') }}"
            class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
        >

            <span class="admin-nav-icon">
                <i data-lucide="layout-dashboard"></i>
            </span>

            <span class="admin-nav-text">
                لوحة التحكم
            </span>

        </a>


        {{-- طلبات الانضمام --}}

        <a
            href="{{ route('admin.join-requests.index') }}"
            class="admin-nav-item {{ request()->routeIs('admin.join-requests.*') ? 'active' : '' }}"
        >

            <span class="admin-nav-icon">
                <i data-lucide="user-round-check"></i>
            </span>

            <span class="admin-nav-text">
                طلبات الانضمام
            </span>

        </a>


        {{-- إدارة المستخدمين --}}

        <a
            href="{{ route('admin.users.index') }}"
            class="admin-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
        >

            <span class="admin-nav-icon">
                <i data-lucide="users-round"></i>
            </span>

            <span class="admin-nav-text">
                إدارة المستخدمين
            </span>

        </a>

    </nav>


    <div class="admin-menu-label">
        إدارة المحتوى
    </div>


    <nav class="admin-nav">


        {{-- التصنيفات --}}

        <a
            href="{{ route('admin.categories.index') }}"
            class="admin-nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
        >

            <span class="admin-nav-icon">
                <i data-lucide="layout-grid"></i>
            </span>

            <span class="admin-nav-text">
                التصنيفات
            </span>

        </a>


        {{-- المهارات --}}

        <a
            href="{{ route('admin.skills.index') }}"
            class="admin-nav-item {{ request()->routeIs('admin.skills.*') ? 'active' : '' }}"
        >

            <span class="admin-nav-icon">
                <i data-lucide="sparkles"></i>
            </span>

            <span class="admin-nav-text">
                المهارات
            </span>

        </a>


        {{-- الخدمات --}}

        <a
            href="{{ route('admin.services.index') }}"
            class="admin-nav-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}"
        >

            <span class="admin-nav-icon">
                <i data-lucide="briefcase-business"></i>
            </span>

            <span class="admin-nav-text">
                الخدمات
            </span>

        </a>


        {{-- الأعمال --}}

        <a
            href="{{ route('admin.portfolio.index') }}"
            class="admin-nav-item {{ request()->routeIs('admin.portfolio.*') ? 'active' : '' }}"
        >

            <span class="admin-nav-icon">
                <i data-lucide="images"></i>
            </span>

            <span class="admin-nav-text">
                الأعمال
            </span>

        </a>

    </nav>


    <div class="admin-menu-label">
        الإدارة
    </div>


    <nav class="admin-nav">


        {{-- البلاغات --}}

        <a
            href="{{ route('admin.reports.index') }}"
            class="admin-nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
        >

            <span class="admin-nav-icon">
                <i data-lucide="triangle-alert"></i>
            </span>

            <span class="admin-nav-text">
                البلاغات
            </span>

        </a>


        {{-- الإعدادات --}}

        <a
            href="{{ route('admin.settings.index') }}"
            class="admin-nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
        >

            <span class="admin-nav-icon">
                <i data-lucide="settings-2"></i>
            </span>

            <span class="admin-nav-text">
                الإعدادات
            </span>

        </a>

    </nav>


    {{-- تسجيل الخروج --}}

    <form
        action="{{ route('admin.logout') }}"
        method="POST"
        class="admin-logout"
    >

        @csrf


        <button
            type="submit"
            class="admin-logout-button"
        >

            <span class="admin-nav-icon">
                <i data-lucide="log-out"></i>
            </span>

            <span>
                تسجيل الخروج
            </span>

        </button>

    </form>

</aside>


{{-- ============================================================
     MAIN
============================================================ --}}

<main class="admin-main">


    <header class="admin-topbar">


        <div class="admin-topbar-right">


            <button
                type="button"
                class="admin-mobile-menu"
                id="adminMobileMenu"
            >

                <i data-lucide="menu"></i>

            </button>


            <div class="admin-page-info">

                <h2>
                    @yield('page-title', 'لوحة التحكم')
                </h2>

                <p>
                    إدارة منصة NASEJA
                </p>

            </div>

        </div>


        <div class="admin-topbar-left">


            <form
                class="admin-search"
                method="GET"
                action="{{ route('admin.search.index') }}"
                role="search"
            >

                <i data-lucide="search"></i>

                <input
                    type="search"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="بحث سريع..."
                    aria-label="بحث في لوحة الإدارة"
                    autocomplete="off"
                >

            </form>


            <div class="admin-top-action">

                <i data-lucide="bell"></i>

            </div>


            <div class="admin-user">


                <div class="admin-avatar">

                    {{ mb_substr(auth()->user()->name, 0, 1) }}

                </div>


                <div class="admin-user-info">

                    <strong>
                        {{ auth()->user()->name }}
                    </strong>

                    <span>
                        مدير النظام
                    </span>

                </div>

            </div>

        </div>

    </header>


    <section class="admin-content">

        @yield('content')

    </section>

</main>


{{-- Lucide Icons --}}

<script src="https://unpkg.com/lucide@latest"></script>


<script>

    if (window.lucide) {
        lucide.createIcons();
    }


    const adminMobileMenu =
        document.getElementById('adminMobileMenu');


    const adminSidebar =
        document.getElementById('adminSidebar');


    if (
        adminMobileMenu &&
        adminSidebar
    ) {

        adminMobileMenu.addEventListener(
            'click',
            function () {

                adminSidebar.classList.toggle('open');

            }
        );

    }

</script>



<script>
/*
|--------------------------------------------------------------------------
| NASEJA Admin Filters
|--------------------------------------------------------------------------
| يجعل زري "تطبيق" و"إعادة ضبط" يعملان فعليًا في جميع صفحات الإدارة
| حتى لو كانت الصفحة تستخدم أسماء CSS مختلفة للفلاتر.
*/
document.addEventListener('click', function (event) {

    const clicked = event.target.closest(
        'button, a'
    );

    if (!clicked) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | تطبيق الفلاتر
    |--------------------------------------------------------------------------
    */

    const isApplyButton =
        clicked.matches(
            '.service-filter-btn, ' +
            '.portfolio-filter-btn, ' +
            '.reports-filter-btn, ' +
            '.category-filter-btn, ' +
            '.skill-filter-btn, ' +
            '.user-filter-btn, ' +
            '[data-admin-filter-apply]'
        );


    if (isApplyButton) {

        const form = clicked.closest('form');

        if (!form) {
            return;
        }

        event.preventDefault();

        /*
         * نستخدم submit() مباشرة حتى لا يعاد تشغيل حدث click.
         */
        form.submit();

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | إعادة ضبط الفلاتر
    |--------------------------------------------------------------------------
    */

    const isResetButton =
        clicked.matches(
            '.service-reset-btn, ' +
            '.portfolio-reset-btn, ' +
            '.reports-reset-btn, ' +
            '.category-reset-btn, ' +
            '.skill-reset-btn, ' +
            '.user-reset-btn, ' +
            '[data-admin-filter-reset]'
        );


    if (isResetButton) {

        event.preventDefault();

        /*
         * إذا كان الزر رابطًا نرجع مباشرة إلى رابط الصفحة
         * بدون أي Query String.
         */
        if (
            clicked.tagName.toLowerCase() === 'a' &&
            clicked.href
        ) {
            window.location.assign(clicked.href);
            return;
        }


        /*
         * دعم أي زر Reset داخل Form.
         */
        const form = clicked.closest('form');

        if (form) {

            form.reset();

            const action =
                form.getAttribute('action') ||
                window.location.pathname;

            window.location.assign(action);
        }
    }

});
</script>

@stack('scripts')


</body>

</html>
