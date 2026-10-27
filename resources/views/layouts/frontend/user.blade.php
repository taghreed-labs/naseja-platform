<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    {{-- الصفحات الداخلية للحساب لا يجب أن تظهر في نتائج البحث --}}
    <meta name="robots" content="noindex,nofollow,noarchive">
    <meta name="description" content="لوحة حساب NASEJA لإدارة الملف الشخصي والمهارات والخدمات والطلبات والرسائل.">


    <title>
        @yield('title', 'NASEJA')
    </title>

    {{-- =====================================================
         NASEJA APPEARANCE BOOTSTRAP
         Applies saved language/theme before the page paints.
    ====================================================== --}}
    <script>
    (function () {
        try {
            var lang = localStorage.getItem('naseja_language') || 'ar';
            var theme = localStorage.getItem('naseja_theme') || 'light';
            var fontSize = localStorage.getItem('naseja_font_size') || 'normal';
            var reducedMotion = localStorage.getItem('naseja_reduced_motion') === '1';

            if (!['ar', 'en'].includes(lang)) lang = 'ar';
            if (!['light', 'dark', 'system'].includes(theme)) theme = 'light';
            if (!['small', 'normal', 'large'].includes(fontSize)) fontSize = 'normal';

            var resolvedTheme = theme;
            if (theme === 'system') {
                resolvedTheme = window.matchMedia &&
                    window.matchMedia('(prefers-color-scheme: dark)').matches
                    ? 'dark'
                    : 'light';
            }

            document.documentElement.lang = lang;
            document.documentElement.dir = lang === 'ar' ? 'rtl' : 'ltr';
            document.documentElement.dataset.theme = resolvedTheme;
            document.documentElement.dataset.themePreference = theme;
            document.documentElement.dataset.fontSize = fontSize;

            if (reducedMotion) {
                document.documentElement.dataset.reducedMotion = 'true';
            }
        } catch (e) {
            document.documentElement.lang = 'ar';
            document.documentElement.dir = 'rtl';
            document.documentElement.dataset.theme = 'light';
        }
    })();
    </script>

    {{-- =====================================================
     PWA
====================================================== --}}

<link rel="manifest" href="{{ asset('manifest.json') }}">

<meta name="theme-color" content="#5e4ed0">

<meta name="mobile-web-app-capable" content="yes">

<meta name="apple-mobile-web-app-capable" content="yes">

<meta
    name="apple-mobile-web-app-status-bar-style"
    content="default"
>

<meta
    name="apple-mobile-web-app-title"
    content="NASEJA"
>


    {{-- =====================================================
         FONT
    ====================================================== --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    >


    {{-- =====================================================
         CSS
    ====================================================== --}}

    <link
        rel="stylesheet"
        href="{{ asset('css/app.css') }}"
    >

    @stack('styles')


    {{-- =====================================================
         LUCIDE
    ====================================================== --}}

    <script async src="https://unpkg.com/lucide@latest" onload="window.lucide && window.lucide.createIcons()"></script>


<style>

/* =========================================================
   GENERAL
========================================================= */

* {
    box-sizing: border-box;
}

html,
body {
    margin: 0;
    padding: 0;
}

body {

    font-family: "Cairo", sans-serif;

    background: #f7f7fa;

    color: #25252d;

    font-size: 16px;

    font-weight: 600;
}

button,
input,
textarea,
select {
    font-family: "Cairo", sans-serif;
}


/* =========================================================
   HEADER
========================================================= */

.naseja-header {

    height: 88px;

    width: 100%;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 30px;

    padding: 0 32px;

    background: #ffffff;

    border-bottom: 1px solid #e8e8ee;

    position: sticky;

    top: 0;

    z-index: 100;
}


/* =========================================================
   LOGO
========================================================= */

.naseja-header-brand {
    flex-shrink: 0;
}

.naseja-logo {

    display: flex;

    align-items: center;

    gap: 14px;

    text-decoration: none !important;

    color: #22222b;
}

.naseja-logo-mark {

    width: 60px;

    height: 60px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #f1efff;

    border: 1px solid #e2ddff;

    border-radius: 17px;

    overflow: hidden;
}

.naseja-logo-mark img {

    width: 47px;

    height: 47px;

    object-fit: contain;
}

.naseja-logo-text strong {

    display: block;

    color: #202027;

    font-size: 26px;

    line-height: 1.1;

    font-weight: 900;

    letter-spacing: .5px;
}

.naseja-logo-text span {

    display: block;

    margin-top: 4px;

    color: #626273;

    font-size: 11px;

    font-weight: 600;
}


/* =========================================================
   SEARCH
========================================================= */

.naseja-header-center {

    width: min(520px, 45vw);

    margin-right: auto;

    margin-left: auto;
}

.naseja-search {

    height: 49px;

    width: 100%;

    display: flex;

    align-items: center;

    gap: 12px;

    padding: 0 10px 0 16px;

    background: #f7f7fa;

    border: 1px solid #e6e6ed;

    border-radius: 15px;

    transition: .2s ease;
}

.naseja-search:focus-within {

    background: #ffffff;

    border-color: #d1cbff;

    box-shadow:
        0 0 0 4px rgba(102,86,217,.07);
}

.naseja-search-icon {

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;
}

.naseja-search-icon svg {

    width: 21px;

    height: 21px;

    color: #777783;
}

.naseja-search input {

    width: 100%;

    min-width: 0;

    border: 0;

    outline: 0;

    background: transparent;

    color: #25252d;

    font-size: 14px;

    font-weight: 500;
}

.naseja-search input::placeholder {
    color: #626273;
}

.naseja-search button {

    height: 37px;

    padding: 0 18px;

    border: 0;

    border-radius: 11px;

    background: #5e4ed0;

    color: #ffffff;

    font-size: 13px;

    font-weight: 800;

    cursor: pointer;

    transition: .2s ease;

    flex-shrink: 0;
}

.naseja-search button:hover {

    background: #4d3fc0;

    transform: translateY(-1px);
}


/* =========================================================
   HEADER ACTIONS
========================================================= */

.naseja-header-actions {

    display: flex;

    align-items: center;

    gap: 14px;

    flex-shrink: 0;
}


/* =========================================================
   NOTIFICATION
========================================================= */

.naseja-notification {

    position: relative;

    width: 45px;

    height: 45px;

    display: flex;

    align-items: center;

    justify-content: center;

    border: 1px solid #e8e8ee;

    border-radius: 13px;

    background: #ffffff;

    color: #555560;

    cursor: pointer;

    transition: .2s ease;
}

.naseja-notification:hover {

    background: #f3f1ff;

    color: #5e4ed0;

    border-color: #ddd8ff;
}

.naseja-notification svg {

    width: 21px;

    height: 21px;

    stroke-width: 2;
}

.notification-dot {

    position: absolute;

    top: 7px;

    right: 7px;

    width: 8px;

    height: 8px;

    border-radius: 50%;

    background: #dc5966;

    border: 2px solid #ffffff;
}


/* قائمة متابعة الرسائل والطلبات */
.naseja-notification-wrap { position: relative; flex-shrink: 0; }
.naseja-notification[aria-expanded="true"] { color: #5e4ed0; background: #f3f1ff; }
.naseja-notification-menu {
    position: absolute; top: calc(100% + 10px); inset-inline-start: 0;
    width: min(320px, calc(100vw - 32px)); z-index: 1200;
    padding: 16px; border: 1px solid #e8e4f2; border-radius: 16px;
    background: #fff; color: #292638; box-shadow: 0 18px 48px rgba(36, 28, 72, .15);
    text-align: start;
}
.naseja-notification-menu[hidden] { display: none !important; }
.naseja-notification-menu strong { display: block; margin-bottom: 6px; font-size: 15px; }
.naseja-notification-menu p { margin: 0 0 12px; color: #666273; font-size: 13px; }
.naseja-notification-menu a {
    display: flex; justify-content: space-between; gap: 10px; padding: 11px 12px;
    border-radius: 10px; color: #4b3cbd; text-decoration: none; font-size: 13px; font-weight: 700;
}
.naseja-notification-menu a:hover, .naseja-notification-menu a:focus-visible { background: #f3f1ff; }
html[data-theme="dark"] .naseja-notification-menu {
    background: #252431; color: #fff; border-color: #474153;
}
html[data-theme="dark"] .naseja-notification-menu p { color: #c9c5d4; }
html[data-theme="dark"] .naseja-notification-menu a { color: #c4bbff; }

/* =========================================================
   HEADER DIVIDER
========================================================= */

.header-divider {

    width: 1px;

    height: 35px;

    background: #e8e8ee;
}


/* =========================================================
   USER
========================================================= */

.naseja-user {

    display: flex;

    align-items: center;

    gap: 10px;

    padding: 4px 6px;
}

.naseja-user-avatar {

    width: 45px;

    height: 45px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 13px;

    background:
        linear-gradient(
            135deg,
            #5e4ed0,
            #8c7de6
        );

    color: #ffffff;

    font-size: 17px;

    font-weight: 900;
}

.naseja-user-info strong {

    display: block;

    max-width: 135px;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

    color: #22222b;

    font-size: 14px;

    font-weight: 800;
}

.naseja-user-info span {

    display: block;

    margin-top: 2px;

    color: #626273;

    font-size: 11px;

    font-weight: 600;
}


/* =========================================================
   EXPLORE BUTTON
========================================================= */

.explore-header-button {

    width: 45px;

    height: 45px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 13px;

    background: #f1efff;

    border: 1px solid #e0dbff;

    color: #5e4ed0;

    text-decoration: none !important;

    transition: .2s ease;
}

.explore-header-button:hover {

    background: #5e4ed0;

    color: #ffffff;

    transform: translateY(-2px);
}

.explore-header-button svg {

    width: 21px;

    height: 21px;

    stroke-width: 2;
}


/* =========================================================
   MAIN LAYOUT
========================================================= */

.dashboard-layout {

    display: flex;

    min-height: calc(100vh - 88px);
}


/* =========================================================
   SIDEBAR
========================================================= */

.naseja-sidebar {

    width: 270px;

    min-width: 270px;

    height: calc(100vh - 88px);

    position: sticky;

    top: 88px;

    display: flex;

    flex-direction: column;

    align-items: stretch;

    padding: 28px 18px 20px;

    background: #ffffff;

    border-left: 1px solid #e8e8ee;

    direction: rtl;

    overflow-y: auto;
}


/* =========================================================
   SIDEBAR SECTION
========================================================= */

.sidebar-section {

    width: 100%;

    display: block;
}

.sidebar-section + .sidebar-section {

    margin-top: 28px;
}


/* =========================================================
   SIDEBAR TITLE
========================================================= */

.sidebar-title {

    width: 100%;

    padding: 0 12px;

    margin-bottom: 12px;

    color: #626273;

    font-size: 11px;

    font-weight: 800;

    line-height: 1.5;
}


/* =========================================================
   SIDEBAR NAV
========================================================= */

.sidebar-nav {

    width: 100%;

    display: flex;

    flex-direction: column;

    align-items: stretch;

    gap: 7px;
}


/* =========================================================
   NAV ITEM
========================================================= */

.naseja-nav-item {

    position: relative;

    width: 100%;

    height: 55px;

    min-height: 55px;

    flex-shrink: 0;

    display: flex;

    flex-direction: row;

    align-items: center;

    gap: 18px;

    padding: 0 14px;

    border: 0;

    border-radius: 14px;

    background: transparent;

    color: #25252d;

    text-decoration: none !important;

    font-family: "Cairo", sans-serif;

    font-size: 15px;

    font-weight: 700;

    cursor: pointer;

    text-align: right;

    transition:
        background .2s ease,
        color .2s ease,
        transform .2s ease;
}


/* =========================================================
   ICON
========================================================= */

.nav-icon {

    width: 40px;

    min-width: 40px;

    height: 40px;

    flex: 0 0 40px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 11px;

    background: #f6f6f9;

    color: #60606b;

    transition:
        background .2s ease,
        color .2s ease;
}

.nav-icon svg {

    width: 20px;

    height: 20px;

    stroke-width: 2;
}


/* =========================================================
   TEXT
========================================================= */

.nav-text {

    flex: 1;

    display: block;

    color: inherit;

    line-height: 1;

    white-space: nowrap;
}


/* =========================================================
   HOVER
========================================================= */

.naseja-nav-item:hover {

    background: #f5f3ff;

    color: #5d4ec8;
}

.naseja-nav-item:hover .nav-icon {

    background: #eae7ff;

    color: #5d4ec8;
}


/* =========================================================
   ACTIVE
========================================================= */

.naseja-nav-item.active {

    background: #eeeaff;

    color: #5547c5;

    font-weight: 800;

    box-shadow:
        0 3px 12px rgba(85,71,197,.06);
}

.naseja-nav-item.active .nav-icon {

    background: #6253d0;

    color: #ffffff;
}


/* =========================================================
   ACTIVE LINE
========================================================= */

.naseja-nav-item.active::after {

    content: "";

    position: absolute;

    right: 4px;

    top: 50%;

    width: 4px;

    height: 25px;

    border-radius: 10px;

    background: #6253d0;

    transform: translateY(-50%);
}


/* =========================================================
   MESSAGE BADGE
========================================================= */

.nav-badge {

    min-width: 24px;

    height: 24px;

    display: flex;

    align-items: center;

    justify-content: center;

    padding: 0 6px;

    border-radius: 8px;

    background: #efecff;

    color: #5e4ed0;

    font-size: 11px;

    font-weight: 800;
}


/* =========================================================
   SIDEBAR BOTTOM
========================================================= */

.sidebar-bottom {

    width: 100%;

    margin-top: auto;

    padding-top: 18px;

    border-top: 1px solid #ededf2;

    display: flex;

    flex-direction: column;

    gap: 7px;
}


/* =========================================================
   LOGOUT FORM
========================================================= */

.logout-form {

    width: 100%;

    margin: 0;

    padding: 0;

    display: block;
}


/* =========================================================
   LOGOUT
========================================================= */

.logout-item {

    color: #303039;
}

.logout-item .nav-icon {

    background: #faf0f1;

    color: #b25b64;
}

.logout-item:hover {

    background: #fff1f2;

    color: #bd505b;
}

.logout-item:hover .nav-icon {

    background: #f9dfe2;

    color: #bd505b;
}


/* =========================================================
   CONTENT
========================================================= */

.dashboard-content {

    flex: 1;

    min-width: 0;

    overflow: hidden;
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 1050px) {

    .naseja-sidebar {

        width: 245px;

        min-width: 245px;

        padding-left: 15px;

        padding-right: 15px;
    }

    .naseja-header-center {

        width: 40vw;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 720px) {

    .naseja-header {

        height: 72px;

        padding: 0 14px;

        gap: 10px;
    }

    .naseja-logo-text {

        display: none;
    }

    .naseja-header-center {

        display: none;
    }

    .header-divider,

    .naseja-user {

        display: none;
    }

    .naseja-logo-mark {

        width: 48px;

        height: 48px;
    }

    .naseja-logo-mark img {

        width: 38px;

        height: 38px;
    }

    .dashboard-layout {

        min-height: calc(100vh - 72px);
    }

    .naseja-sidebar {

        width: 76px;

        min-width: 76px;

        height: calc(100vh - 72px);

        top: 72px;

        padding: 18px 8px;
    }

    .sidebar-title {

        display: none;
    }

    .sidebar-section + .sidebar-section {

        margin-top: 15px;
    }

    .naseja-nav-item {

        width: 100%;

        height: 52px;

        min-height: 52px;

        justify-content: center;

        gap: 0;

        padding: 0;

        font-size: 0;
    }

    .nav-icon {

        width: 40px;

        min-width: 40px;

        height: 40px;
    }

    .nav-text,

    .nav-badge {

        display: none;
    }

    .naseja-nav-item.active::after {

        right: -2px;
    }

}


/* =========================================================
   SMALL MOBILE
========================================================= */

@media (max-width: 420px) {

    .naseja-sidebar {

        width: 66px;

        min-width: 66px;
    }

    .nav-icon {

        width: 38px;

        min-width: 38px;

        height: 38px;
    }

}

</style>


<style>
/* =========================================================
   NASEJA GLOBAL SETTINGS
========================================================= */

:root {
    --settings-accent: #5e4ed0;
    --settings-accent-soft: #f1efff;
    --settings-border: #e8e8ee;
    --settings-surface: #ffffff;
    --settings-surface-2: #f7f7fa;
    --settings-text: #25252d;
    --settings-muted: #626273;
    --settings-overlay: rgba(24, 23, 35, .48);
}

html[data-theme="dark"] {
    color-scheme: dark;
    --settings-accent: #9a8cff;
    --settings-accent-soft: #292544;
    --settings-border: #30343f;
    --settings-surface: #1b1e25;
    --settings-surface-2: #14161c;
    --settings-text: #f2f2f5;
    --settings-muted: #a8a9b2;
    --settings-overlay: rgba(0, 0, 0, .68);
}

html[data-font-size="small"] body {
    font-size: 14px;
}

html[data-font-size="normal"] body {
    font-size: 16px;
}

html[data-font-size="large"] body {
    font-size: 18px;
}

html[data-reduced-motion="true"] *,
html[data-reduced-motion="true"] *::before,
html[data-reduced-motion="true"] *::after {
    animation-duration: .001ms !important;
    animation-iteration-count: 1 !important;
    scroll-behavior: auto !important;
    transition-duration: .001ms !important;
}

/* LTR support */
html[dir="ltr"] .naseja-sidebar {
    direction: ltr;
    border-left: 0;
    border-right: 1px solid var(--settings-border);
}

html[dir="ltr"] .naseja-nav-item {
    text-align: left;
}

html[dir="ltr"] .naseja-nav-item.active::after {
    right: auto;
    left: 4px;
}

html[dir="ltr"] .naseja-header-center {
    direction: ltr;
}

html[dir="ltr"] .naseja-search {
    padding: 0 16px 0 10px;
}

/* Global dark mode for the shared user layout */
html[data-theme="dark"] body {
    background: #12141a !important;
    color: #ececf1 !important;
}

html[data-theme="dark"] .naseja-header,
html[data-theme="dark"] .naseja-sidebar {
    background: #181b22 !important;
    border-color: #2c303a !important;
}

html[data-theme="dark"] .naseja-logo,
html[data-theme="dark"] .naseja-logo-text strong,
html[data-theme="dark"] .naseja-user-info strong,
html[data-theme="dark"] .naseja-nav-item {
    color: #ececf1 !important;
}

html[data-theme="dark"] .naseja-logo-text span,
html[data-theme="dark"] .naseja-user-info span,
html[data-theme="dark"] .sidebar-title {
    color: #a5a7b0 !important;
}

html[data-theme="dark"] .naseja-logo-mark,
html[data-theme="dark"] .nav-icon,
html[data-theme="dark"] .explore-header-button {
    background: #242833 !important;
    border-color: #333846 !important;
}

html[data-theme="dark"] .naseja-search {
    background: #22262f !important;
    border-color: #323743 !important;
}

html[data-theme="dark"] .naseja-search input {
    color: #f4f4f7 !important;
}

html[data-theme="dark"] .naseja-search:focus-within {
    background: #252933 !important;
    border-color: #675bd4 !important;
}

html[data-theme="dark"] .naseja-notification {
    background: #20242c !important;
    color: #d7d8dd !important;
    border-color: #303540 !important;
}

html[data-theme="dark"] .header-divider,
html[data-theme="dark"] .sidebar-bottom {
    border-color: #2e323d !important;
}

html[data-theme="dark"] .naseja-nav-item:hover,
html[data-theme="dark"] .naseja-nav-item.active {
    background: #292544 !important;
    color: #b6acff !important;
}

html[data-theme="dark"] .naseja-nav-item:hover .nav-icon {
    background: #342f55 !important;
    color: #b6acff !important;
}

html[data-theme="dark"] .logout-item:hover {
    background: #392226 !important;
    color: #ff9da6 !important;
}

/* Dark mode for dashboard cards/content */
html[data-theme="dark"] .naseja-dashboard,
html[data-theme="dark"] .dashboard-content {
    background: #12141a !important;
    color: #ececf1 !important;
}

html[data-theme="dark"] .profile-overview,
html[data-theme="dark"] .actions-panel,
html[data-theme="dark"] .overview-section,
html[data-theme="dark"] .overview-stat,
html[data-theme="dark"] .dashboard-tip,
html[data-theme="dark"] .public-profile-card,
html[data-theme="dark"] .dashboard-search-header,
html[data-theme="dark"] .dashboard-search-card,
html[data-theme="dark"] .dashboard-search-empty {
    background: #1b1e25 !important;
    border-color: #30343f !important;
    color: #ececf1 !important;
    box-shadow: none !important;
}

html[data-theme="dark"] .dashboard-title h1,
html[data-theme="dark"] .dashboard-title p,
html[data-theme="dark"] .profile-info h2,
html[data-theme="dark"] .profile-info p,
html[data-theme="dark"] .panel-heading h2,
html[data-theme="dark"] .overview-section h2,
html[data-theme="dark"] .dashboard-tip h2,
html[data-theme="dark"] .public-profile-card h2,
html[data-theme="dark"] .action-text strong,
html[data-theme="dark"] .overview-stat strong,
html[data-theme="dark"] .dashboard-search-card h4,
html[data-theme="dark"] .dashboard-search-group-title h3,
html[data-theme="dark"] .dashboard-search-header h2 {
    color: #f1f1f5 !important;
}

html[data-theme="dark"] .action-text span,
html[data-theme="dark"] .overview-stat small,
html[data-theme="dark"] .dashboard-search-card p,
html[data-theme="dark"] .dashboard-search-card small,
html[data-theme="dark"] .public-profile-card p,
html[data-theme="dark"] .dashboard-search-header p {
    color: #a6a7af !important;
}

html[data-theme="dark"] .action-item {
    border-color: #2e323c !important;
}

html[data-theme="dark"] .action-item:hover {
    background: #23262f !important;
}

html[data-theme="dark"] .progress-track {
    background: #30343d !important;
}

/* Modal */
.naseja-settings-modal {
    position: fixed;
    inset: 0;
    z-index: 10000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 22px;
}

.naseja-settings-modal.is-open {
    display: flex;
}

.naseja-settings-backdrop {
    position: absolute;
    inset: 0;
    background: var(--settings-overlay);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    cursor: pointer;
}

.naseja-settings-dialog {
    position: relative;
    z-index: 1;
    width: min(570px, 100%);
    max-height: min(760px, calc(100vh - 44px));
    overflow: auto;
    background: var(--settings-surface);
    color: var(--settings-text);
    border: 1px solid var(--settings-border);
    border-radius: 24px;
    box-shadow: 0 24px 70px rgba(28, 22, 62, .18);
    animation: nasejaSettingsIn .22s ease;
}

@keyframes nasejaSettingsIn {
    from {
        opacity: 0;
        transform: translateY(12px) scale(.985);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.naseja-settings-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    padding: 24px 24px 18px;
    border-bottom: 1px solid var(--settings-border);
}

.naseja-settings-heading {
    display: flex;
    align-items: center;
    gap: 13px;
}

.naseja-settings-heading-icon {
    width: 46px;
    height: 46px;
    display: grid;
    place-items: center;
    flex: 0 0 46px;
    border-radius: 14px;
    background: var(--settings-accent-soft);
    color: var(--settings-accent);
}

.naseja-settings-heading-icon svg {
    width: 21px;
    height: 21px;
}

.naseja-settings-heading h2 {
    margin: 0;
    color: var(--settings-text);
    font-size: 19px;
    font-weight: 900;
}

.naseja-settings-heading p {
    margin: 4px 0 0;
    color: var(--settings-muted);
    font-size: 11px;
    font-weight: 600;
}

.naseja-settings-close {
    width: 40px;
    height: 40px;
    display: grid;
    place-items: center;
    flex: 0 0 40px;
    border: 1px solid var(--settings-border);
    border-radius: 12px;
    background: var(--settings-surface-2);
    color: var(--settings-text);
    cursor: pointer;
}

.naseja-settings-close:hover {
    color: var(--settings-accent);
    border-color: var(--settings-accent);
}

.naseja-settings-body {
    padding: 22px 24px 24px;
}

.naseja-settings-group + .naseja-settings-group {
    margin-top: 24px;
}

.naseja-settings-group-title {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 11px;
}

.naseja-settings-group-title strong {
    color: var(--settings-text);
    font-size: 13px;
    font-weight: 900;
}

.naseja-settings-group-title span {
    color: var(--settings-muted);
    font-size: 10px;
    font-weight: 600;
}

.naseja-settings-options {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 10px;
}

.naseja-settings-options.two {
    grid-template-columns: repeat(2, minmax(0, 1fr));
}

.naseja-setting-choice {
    position: relative;
}

.naseja-setting-choice input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.naseja-setting-choice label {
    min-height: 72px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 5px;
    padding: 13px;
    border: 1px solid var(--settings-border);
    border-radius: 15px;
    background: var(--settings-surface-2);
    color: var(--settings-text);
    cursor: pointer;
    transition: .18s ease;
}

.naseja-setting-choice label strong {
    font-size: 12px;
    font-weight: 900;
}

.naseja-setting-choice label small {
    color: var(--settings-muted);
    font-size: 9px;
    font-weight: 600;
}

.naseja-setting-choice input:checked + label {
    background: var(--settings-accent-soft);
    border-color: var(--settings-accent);
    box-shadow: 0 0 0 3px color-mix(in srgb, var(--settings-accent) 10%, transparent);
}

.naseja-setting-choice input:checked + label strong {
    color: var(--settings-accent);
}

.naseja-settings-toggle-row {
    min-height: 64px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    padding: 12px 14px;
    border: 1px solid var(--settings-border);
    border-radius: 15px;
    background: var(--settings-surface-2);
}

.naseja-settings-toggle-copy strong {
    display: block;
    color: var(--settings-text);
    font-size: 12px;
    font-weight: 900;
}

.naseja-settings-toggle-copy small {
    display: block;
    margin-top: 3px;
    color: var(--settings-muted);
    font-size: 9px;
    font-weight: 600;
}

.naseja-switch {
    position: relative;
    width: 48px;
    height: 27px;
    flex: 0 0 48px;
}

.naseja-switch input {
    position: absolute;
    opacity: 0;
}

.naseja-switch span {
    position: absolute;
    inset: 0;
    border-radius: 999px;
    background: #cfd0d7;
    cursor: pointer;
    transition: .2s ease;
}

.naseja-switch span::after {
    content: "";
    position: absolute;
    top: 4px;
    left: 4px;
    width: 19px;
    height: 19px;
    border-radius: 50%;
    background: #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,.16);
    transition: .2s ease;
}

.naseja-switch input:checked + span {
    background: var(--settings-accent);
}

.naseja-switch input:checked + span::after {
    transform: translateX(21px);
}

html[dir="rtl"] .naseja-switch span::after {
    left: auto;
    right: 4px;
}

html[dir="rtl"] .naseja-switch input:checked + span::after {
    transform: translateX(-21px);
}

.naseja-settings-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-top: 24px;
    padding-top: 18px;
    border-top: 1px solid var(--settings-border);
}

.naseja-settings-note {
    color: var(--settings-muted);
    font-size: 9px;
    font-weight: 600;
}

.naseja-settings-reset {
    min-height: 38px;
    padding: 8px 13px;
    border: 1px solid var(--settings-border);
    border-radius: 11px;
    background: var(--settings-surface-2);
    color: var(--settings-text);
    font-size: 10px;
    font-weight: 800;
    cursor: pointer;
}

.naseja-settings-reset:hover {
    border-color: #d05863;
    color: #d05863;
}

body.naseja-settings-open {
    overflow: hidden;
}

@media (max-width: 620px) {
    .naseja-settings-dialog {
        border-radius: 20px;
    }

    .naseja-settings-header,
    .naseja-settings-body {
        padding-left: 17px;
        padding-right: 17px;
    }

    .naseja-settings-options,
    .naseja-settings-options.two {
        grid-template-columns: 1fr;
    }
}
</style>
<style>
/* خلفية محايدة للقالب حتى لو كان هناك تنسيق قديم في app.css. */
html:not([data-theme="dark"]) body,
html:not([data-theme="dark"]) .user-layout,
html:not([data-theme="dark"]) .dashboard-layout,
html:not([data-theme="dark"]) .dashboard-content,
html:not([data-theme="dark"]) .naseja-dashboard { background:#f7f8fc !important; }
/* على الهاتف تتحول قائمة الحساب إلى شريط يمكن تمريره أفقيًا. */
@media(max-width:720px) {
  .dashboard-layout { display:block; min-height:0; }
  .dashboard-content { overflow:visible; width:100%; }
  .naseja-menu-button { display:inline-flex; align-items:center; justify-content:center; gap:6px; flex:none; min-width:44px; min-height:44px; padding:7px 10px; border:1px solid #e4e1f7; border-radius:12px; background:#f5f3ff; color:#4536bd; font:700 12px "Cairo",sans-serif; cursor:pointer; }
  .naseja-menu-button svg { width:20px; height:20px; }
  .naseja-sidebar { position:fixed; z-index:102; inset:0 0 0 auto; top:0; width:min(85vw,340px); min-width:0; height:100dvh; max-height:none; padding:22px 16px calc(24px + env(safe-area-inset-bottom)); display:flex; flex-direction:column; overflow-y:auto; overflow-x:hidden; background:#fff; border:0; border-left:1px solid #e5e2f3; box-shadow:-15px 0 35px rgba(24,19,70,.12); transform:translateX(105%); visibility:hidden; pointer-events:none; transition:transform .24s ease,visibility .24s; }
  .naseja-sidebar.is-open { transform:translateX(0); visibility:visible; pointer-events:auto; }
  .naseja-sidebar .sidebar-mobile-heading { display:flex; align-items:center; justify-content:space-between; margin-bottom:19px; font-weight:900; font-size:18px; color:#2a2450; }
  .naseja-sidebar .sidebar-mobile-close { display:inline-flex; align-items:center; justify-content:center; width:42px; height:42px; border:1px solid #e5e2f3; border-radius:11px; background:#fff; color:#4438ad; cursor:pointer; }
  .naseja-sidebar .sidebar-mobile-close svg { width:20px; height:20px; }
  .naseja-sidebar .sidebar-section,.naseja-sidebar .sidebar-section + .sidebar-section { display:block; width:100%; margin:0 0 16px; padding:0; }
  .naseja-sidebar .sidebar-title { display:block; margin:0 0 8px; }
  .naseja-sidebar .sidebar-nav { display:flex; flex-direction:column; align-items:stretch; gap:5px; }
  .naseja-sidebar .naseja-nav-item { display:flex; flex-direction:row; align-items:center; justify-content:flex-start; gap:12px; flex:none; width:100%; min-height:48px; height:auto; padding:7px 11px; border-radius:12px; font-size:13px; text-align:start; }
  .naseja-sidebar .nav-icon { width:32px; min-width:32px; height:32px; }
  .naseja-sidebar .nav-text { display:block; max-width:none; font-size:13px; white-space:normal; }
  .naseja-sidebar .sidebar-bottom { display:flex; flex-direction:column; align-items:stretch; gap:5px; width:100%; margin-top:auto; }
  .naseja-sidebar .logout-form { display:block; width:100%; margin:0; }
  .naseja-sidebar .logout-form button { width:100%; }
  .naseja-sidebar .nav-badge { display:inline-flex; }
  .naseja-sidebar .naseja-nav-item.active::after { display:none; }
  .naseja-sidebar .naseja-nav-item:focus-visible,.naseja-menu-button:focus-visible,.sidebar-mobile-close:focus-visible { outline:3px solid #8173ef; outline-offset:2px; }
  .naseja-menu-backdrop { position:fixed; z-index:101; inset:0; background:rgba(19,16,43,.5); border:0; padding:0; width:100%; cursor:pointer; }
  body.naseja-menu-open { overflow:hidden; }
  html[data-theme="dark"] .naseja-sidebar { background:#242033; border-color:#4a425b; }
  html[data-theme="dark"] .naseja-sidebar .sidebar-mobile-heading { color:#fff; }
}
@media(min-width:721px) { .naseja-menu-backdrop,.naseja-sidebar .sidebar-mobile-heading { display:none; } }
.naseja-menu-button { display:none; }
@media(max-width:720px) { .naseja-menu-button { display:inline-flex; } }
</style>

</head>


<body>


<div class="user-layout">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <header class="naseja-header">

        <button type="button" class="naseja-menu-button" id="nasejaMenuButton" aria-controls="nasejaAccountSidebar" aria-expanded="false" aria-label="فتح قائمة الحساب">
            <i data-lucide="menu" aria-hidden="true"></i><span>القائمة</span>
        </button>

        {{-- الشعار --}}

        <div class="naseja-header-brand">

            <a
                href="{{ route('dashboard') }}"
                class="naseja-logo"
            >

                <div class="naseja-logo-mark">

                    <img
                        src="{{ asset('images/naseja-logo.png') }}"
                        alt="NASEJA"
                        width="48" height="48"
                    >

                </div>


                <div class="naseja-logo-text">

                    <strong>
                        NASEJA
                    </strong>

                    <span>
                        مساحتك لعرض مهاراتك
                    </span>

                </div>

            </a>

        </div>



        {{-- =================================================
             البحث
        ================================================== --}}

        <div class="naseja-header-center">

            <form
                action="{{ route('dashboard') }}"
                method="GET"
                class="naseja-search"
            >

                <div class="naseja-search-icon">

                    <i data-lucide="search"></i>

                </div>


                <input
                    type="text"
                    name="search"
                    aria-label="البحث في NASEJA"
                    value="{{ request('search', '') }}"
                    placeholder="ابحث عن شخص، مهارة، خدمة أو عمل..."
                    autocomplete="off"
                >


                <button type="submit">
                    بحث
                </button>

            </form>

        </div>



        {{-- Header actions --}}

        <div class="naseja-header-actions">


            {{-- مؤشر الرسائل الجديدة وروابط المتابعة --}}
            @php
                $unreadAccountMessages = \Illuminate\Support\Facades\DB::table('messages')
                    ->join('conversation_participants', 'conversation_participants.conversation_id', '=', 'messages.conversation_id')
                    ->where('conversation_participants.user_id', auth()->id())
                    ->where('messages.sender_id', '!=', auth()->id())
                    ->whereNull('messages.read_at')
                    ->count();
            @endphp

            <div class="naseja-notification-wrap" id="nasejaNotificationWrap">
                <button type="button" class="naseja-notification"
                    id="nasejaNotificationToggle" title="رسائل الحساب والطلبات"
                    aria-label="رسائل الحساب والطلبات"
                    aria-controls="nasejaNotificationMenu" aria-expanded="false">
                    <i data-lucide="bell"></i>
                    @if($unreadAccountMessages > 0)
                        <span class="notification-dot" aria-hidden="true"></span>
                    @endif
                </button>
                <div class="naseja-notification-menu" id="nasejaNotificationMenu" hidden>
                    <strong>متابعة حسابك</strong>
                    <p>{{ $unreadAccountMessages > 0
                        ? 'لديك ' . $unreadAccountMessages . ' رسائل غير مقروءة.'
                        : 'لا توجد رسائل جديدة.' }}</p>
                    <a href="{{ route('messages.index') }}"><span>الرسائل</span><span>{{ $unreadAccountMessages > 0 ? $unreadAccountMessages : '←' }}</span></a>
                    <a href="{{ route('orders.index') }}"><span>طلباتي</span><span>←</span></a>
                </div>
            </div>


            <div class="header-divider"></div>


            {{-- المستخدم --}}

            <div class="naseja-user">

                <div class="naseja-user-info">

                    <strong>
                        {{ auth()->user()->name ?? 'المستخدم' }}
                    </strong>

                    <span>
                        حسابي
                    </span>

                </div>

            </div>


            {{-- استكشاف --}}

            <a
                href="{{ route('explore') }}"
                class="explore-header-button"
                title="استكشاف"
                aria-label="استكشاف"
            >

                <i data-lucide="compass"></i>

            </a>


        </div>

    </header>



    {{-- =====================================================
         MAIN LAYOUT
    ====================================================== --}}

    <div class="dashboard-layout">

        <button type="button" class="naseja-menu-backdrop" id="nasejaMenuBackdrop" aria-label="إغلاق قائمة الحساب" hidden></button>


        {{-- =================================================
             SIDEBAR
        ================================================== --}}

        <aside class="naseja-sidebar" id="nasejaAccountSidebar" aria-label="قائمة الحساب">

            <div class="sidebar-mobile-heading"><span>قائمة الحساب</span><button type="button" class="sidebar-mobile-close" id="nasejaMenuClose" aria-label="إغلاق القائمة"><i data-lucide="x" aria-hidden="true"></i></button></div>

            {{-- NASEJA ROLE-AWARE SIDEBAR --}}
            @php
                $isCustomer = auth()->check()
                    && auth()->user()->roles()->where('slug', 'customer')->exists();
            @endphp


            {{-- =========================
                 Navigation
            ========================== --}}

            <div class="sidebar-section">

                <div class="sidebar-title">
                    التنقل
                </div>


                <nav class="sidebar-nav">


                    {{-- الرئيسية --}}

                    <a
                        href="{{ route('dashboard') }}"
                        class="naseja-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    >

                        <span class="nav-icon">
                            <i data-lucide="layout-dashboard"></i>
                        </span>

                        <span class="nav-text">
                            الرئيسية
                        </span>

                    </a>



                    {{-- ملفي الشخصي --}}

                    <a
                        href="{{ route('profile.edit') }}"
                        class="naseja-nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
                    >

                        <span class="nav-icon">
                            <i data-lucide="user-round"></i>
                        </span>

                        <span class="nav-text">
                            ملفي الشخصي
                        </span>

                    </a>
                    @if ($isCustomer)

                        {{-- استكشاف --}}
                        <a
                            href="{{ route('explore') }}"
                            class="naseja-nav-item {{ request()->routeIs('explore') ? 'active' : '' }}"
                        >
                            <span class="nav-icon">
                                <i data-lucide="compass"></i>
                            </span>

                            <span class="nav-text">
                                استكشاف
                            </span>
                        </a>


                        {{-- طلباتي --}}
                        <a
                            href="{{ route('orders.index') }}"
                            class="naseja-nav-item {{ request()->routeIs('orders.*') ? 'active' : '' }}"
                        >
                            <span class="nav-icon">
                                <i data-lucide="clipboard-list"></i>
                            </span>

                            <span class="nav-text">
                                طلباتي
                            </span>
                        </a>

                    @endif


                    @if (!$isCustomer)




                    {{-- مهاراتي --}}

                    <a
                        href="{{ route('skills.index') }}"
                        class="naseja-nav-item {{ request()->routeIs('skills.*') ? 'active' : '' }}"
                    >

                        <span class="nav-icon">
                            <i data-lucide="sparkles"></i>
                        </span>

                        <span class="nav-text">
                            مهاراتي
                        </span>

                    </a>



                    {{-- خدماتي --}}

                    <a
                        href="{{ route('services.index') }}"
                        class="naseja-nav-item {{ request()->routeIs('services.*') ? 'active' : '' }}"
                    >

                        <span class="nav-icon">
                            <i data-lucide="shopping-bag"></i>
                        </span>

                        <span class="nav-text">
                            خدماتي
                        </span>

                    </a>


                    {{-- الطلبات الواردة --}}
                    <a
                        href="{{ route('provider.orders.index') }}"
                        class="naseja-nav-item {{ request()->routeIs('provider.orders.*') ? 'active' : '' }}"
                    >
                        <span class="nav-icon">
                            <i data-lucide="inbox"></i>
                        </span>

                        <span class="nav-text">
                            الطلبات الواردة
                        </span>
                    </a>



                    {{-- أعمالي --}}

                    <a
                        href="{{ route('portfolio.index') }}"
                        class="naseja-nav-item {{ request()->routeIs('portfolio.*') ? 'active' : '' }}"
                    >

                        <span class="nav-icon">
                            <i data-lucide="images"></i>
                        </span>

                        <span class="nav-text">
                            أعمالي
                        </span>

                    </a>
                    @endif





                    @if ($isCustomer)
                    {{-- المفضلة --}}

                    <a
                        href="{{ route('favorites.index') }}"
                        class="naseja-nav-item {{ request()->routeIs('favorites.*') ? 'active' : '' }}"
                    >

                        <span class="nav-icon">
                            <i data-lucide="heart"></i>
                        </span>

                        <span class="nav-text">
                            المفضلة
                        </span>

                    </a>
                    @endif

                </nav>

            </div>
            {{-- =========================
                 Communication
            ========================== --}}

            <div class="sidebar-section sidebar-communication">

                <div class="sidebar-title">
                    التواصل
                </div>


                <nav class="sidebar-nav">

                    <a
                        href="{{ route('messages.index') }}"
                        class="naseja-nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }}"
                    >

                        <span class="nav-icon">
                            <i data-lucide="message-circle"></i>
                        </span>

                        <span class="nav-text">
                            الرسائل
                        </span>

                    </a>

                </nav>

            </div>





            {{-- =========================
                 Bottom
            ========================== --}}

            <div class="sidebar-bottom">


                {{-- الإعدادات --}}

                <button
                    type="button"
                    class="naseja-nav-item"
                    id="nasejaSettingsButton"
                    aria-haspopup="dialog"
                    aria-controls="nasejaSettingsModal"
                >

                    <span class="nav-icon">
                        <i data-lucide="settings-2"></i>
                    </span>

                    <span class="nav-text">
                        الإعدادات
                    </span>

                </button>



                {{-- تسجيل الخروج --}}

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                    class="logout-form"
                >

                    @csrf

                    <button
                        type="submit"
                        class="naseja-nav-item logout-item"
                    >

                        <span class="nav-icon">
                            <i data-lucide="log-out"></i>
                        </span>

                        <span class="nav-text">
                            تسجيل الخروج
                        </span>

                    </button>

                </form>


            </div>


        </aside>



        {{-- =================================================
             PAGE CONTENT
        ================================================== --}}

        <main class="dashboard-content">

            @yield('content')

        </main>


    </div>


</div>


{{-- =====================================================
     SETTINGS MODAL
====================================================== --}}
<div
    class="naseja-settings-modal"
    id="nasejaSettingsModal"
    aria-hidden="true"
>
    <button
        type="button"
        class="naseja-settings-backdrop"
        id="nasejaSettingsBackdrop"
        aria-label="إغلاق الإعدادات"
    ></button>

    <section
        class="naseja-settings-dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="nasejaSettingsTitle"
    >
        <header class="naseja-settings-header">
            <div class="naseja-settings-heading">
                <div class="naseja-settings-heading-icon">
                    <i data-lucide="settings-2"></i>
                </div>

                <div>
                    <h2 id="nasejaSettingsTitle">إعدادات الواجهة</h2>
                    <p>خصص اللغة والمظهر بالطريقة التي تناسبك.</p>
                </div>
            </div>

            <button
                type="button"
                class="naseja-settings-close"
                id="nasejaSettingsClose"
                aria-label="إغلاق"
            >
                <i data-lucide="x"></i>
            </button>
        </header>

        <div class="naseja-settings-body">

            {{-- LANGUAGE --}}
            <div class="naseja-settings-group">
                <div class="naseja-settings-group-title">
                    <strong>اللغة</strong>
                    <span>تغيير لغة واتجاه الواجهة</span>
                </div>

                <div class="naseja-settings-options two">
                    <div class="naseja-setting-choice">
                        <input
                            type="radio"
                            name="naseja_language"
                            id="nasejaLangAr"
                            value="ar"
                        >
                        <label for="nasejaLangAr">
                            <strong>العربية</strong>
                            <small>واجهة من اليمين إلى اليسار</small>
                        </label>
                    </div>

                    <div class="naseja-setting-choice">
                        <input
                            type="radio"
                            name="naseja_language"
                            id="nasejaLangEn"
                            value="en"
                        >
                        <label for="nasejaLangEn">
                            <strong>English</strong>
                            <small>Left-to-right interface</small>
                        </label>
                    </div>
                </div>
            </div>

            {{-- THEME --}}
            <div class="naseja-settings-group">
                <div class="naseja-settings-group-title">
                    <strong>المظهر</strong>
                    <span>اختر الثيم المفضل</span>
                </div>

                <div class="naseja-settings-options">
                    <div class="naseja-setting-choice">
                        <input
                            type="radio"
                            name="naseja_theme"
                            id="nasejaThemeLight"
                            value="light"
                        >
                        <label for="nasejaThemeLight">
                            <strong>فاتح</strong>
                            <small>Light</small>
                        </label>
                    </div>

                    <div class="naseja-setting-choice">
                        <input
                            type="radio"
                            name="naseja_theme"
                            id="nasejaThemeDark"
                            value="dark"
                        >
                        <label for="nasejaThemeDark">
                            <strong>داكن</strong>
                            <small>Dark</small>
                        </label>
                    </div>

                    <div class="naseja-setting-choice">
                        <input
                            type="radio"
                            name="naseja_theme"
                            id="nasejaThemeSystem"
                            value="system"
                        >
                        <label for="nasejaThemeSystem">
                            <strong>حسب الجهاز</strong>
                            <small>System</small>
                        </label>
                    </div>
                </div>
            </div>

            {{-- FONT SIZE --}}
            <div class="naseja-settings-group">
                <div class="naseja-settings-group-title">
                    <strong>حجم الواجهة</strong>
                    <span>حجم النص العام</span>
                </div>

                <div class="naseja-settings-options">
                    <div class="naseja-setting-choice">
                        <input
                            type="radio"
                            name="naseja_font_size"
                            id="nasejaFontSmall"
                            value="small"
                        >
                        <label for="nasejaFontSmall">
                            <strong>صغير</strong>
                            <small>Small</small>
                        </label>
                    </div>

                    <div class="naseja-setting-choice">
                        <input
                            type="radio"
                            name="naseja_font_size"
                            id="nasejaFontNormal"
                            value="normal"
                        >
                        <label for="nasejaFontNormal">
                            <strong>عادي</strong>
                            <small>Normal</small>
                        </label>
                    </div>

                    <div class="naseja-setting-choice">
                        <input
                            type="radio"
                            name="naseja_font_size"
                            id="nasejaFontLarge"
                            value="large"
                        >
                        <label for="nasejaFontLarge">
                            <strong>كبير</strong>
                            <small>Large</small>
                        </label>
                    </div>
                </div>
            </div>

            {{-- REDUCED MOTION --}}
            <div class="naseja-settings-group">
                <div class="naseja-settings-toggle-row">
                    <div class="naseja-settings-toggle-copy">
                        <strong>تقليل الحركة</strong>
                        <small>تقليل المؤثرات والانتقالات في الواجهة.</small>
                    </div>

                    <label class="naseja-switch">
                        <input
                            type="checkbox"
                            id="nasejaReducedMotion"
                        >
                        <span></span>
                    </label>
                </div>
            </div>

            <footer class="naseja-settings-footer">
                <span class="naseja-settings-note">
                    يتم حفظ اختياراتك تلقائيًا على هذا الجهاز.
                </span>

                <button
                    type="button"
                    class="naseja-settings-reset"
                    id="nasejaSettingsReset"
                >
                    إعادة الافتراضي
                </button>
            </footer>

        </div>
    </section>
</div>


<script>
/* =========================================================
   NASEJA UI SETTINGS
========================================================= */

(function () {
    'use strict';

    var STORAGE = {
        language: 'naseja_language',
        theme: 'naseja_theme',
        fontSize: 'naseja_font_size',
        reducedMotion: 'naseja_reduced_motion'
    };

    var translations = {
        'مساحتك لعرض مهاراتك': 'Your space to showcase your skills',
        'ابحث عن شخص، مهارة، خدمة أو عمل...': 'Search for a person, skill, service or work...',
        'بحث': 'Search',
        'الإشعارات': 'Notifications',
        'المستخدم': 'User',
        'حسابي': 'My account',
        'استكشاف': 'Explore',
        'التنقل': 'Navigation',
        'الرئيسية': 'Dashboard',
        'ملفي الشخصي': 'My profile',
        'مهاراتي': 'My skills',
        'خدماتي': 'My services',
        'الطلبات الواردة': 'Incoming orders',
        'أعمالي': 'My portfolio',
        'المفضلة': 'Favorites',
        'طلباتي': 'My orders',
        'التواصل': 'Communication',
        'الرسائل': 'Messages',
        'الإعدادات': 'Settings',
        'تسجيل الخروج': 'Log out',

        'لوحة التحكم': 'Dashboard',
        'مكانك لإدارة حضورك المهني في NASEJA.': 'Manage your professional presence on NASEJA.',
        'تعديل الملف': 'Edit profile',
        'نتائج البحث': 'Search results',
        'نتائج البحث عن:': 'Search results for:',
        'مسح البحث': 'Clear search',
        'الأشخاص': 'People',
        'صاحب مهارة': 'Skilled professional',
        'مهارة': 'Skill',
        'الخدمات': 'Services',
        'يقدمها:': 'Provided by:',
        'الأعمال': 'Portfolio',
        'بواسطة:': 'By:',
        'لم نجد نتائج مطابقة للبحث': 'No matching results found',
        'جرّبي البحث باسم شخص أو مهارة أو خدمة أو عمل.': 'Try searching by person, skill, service, or portfolio item.',
        'نشط': 'Active',
        'ابدأ بإضافة معلوماتك ومهاراتك': 'Start by adding your information and skills',
        'حتى يظهر ملفك بصورة احترافية.': 'to make your profile look professional.',
        'إدارة ملفي': 'Manage my profile',
        'اكتمال الملف': 'Profile completion',
        'أضف المزيد لتظهر بصورة أفضل': 'Add more details to improve your profile',
        'ملفك مكتمل بشكل ممتاز': 'Your profile is fully completed',
        'ملفك قريب من الاكتمال': 'Your profile is almost complete',
        'استمر في إكمال بياناتك': 'Keep completing your profile',
        'أكمل بياناتك الأساسية': 'Complete your basic information',
        'إكمال الآن': 'Complete now',
        'ابدأ من هنا': 'Start here',
        'ماذا تريد أن تفعل؟': 'What would you like to do?',
        'معلوماتك وصورتك ونبذتك': 'Your information, photo, and bio',
        'أضف ما تتقنه وتتميز به': 'Add the skills you excel at',
        'اعرض نماذج من أعمالك': 'Show examples of your work',
        'قدم خدماتك للعملاء': 'Offer your services to clients',
        'نظرة سريعة': 'Quick overview',
        'ملفك على NASEJA': 'Your profile on NASEJA',
        'المهارات': 'Skills',
        'مهارة مضافة': 'Skill added',
        'مهارات مضافة': 'Skills added',
        'خدمة منشورة': 'Service published',
        'خدمات منشورة': 'Services published',
        'عمل في ملفك': 'Portfolio item',
        'أعمال في ملفك': 'Portfolio items',
        'التقييمات': 'Reviews',
        'لا توجد تقييمات بعد': 'No reviews yet',
        'نصيحة NASEJA': 'NASEJA tip',
        'ملفك هو أول انطباع عنك': 'Your profile is your first impression',
        'أضف صورة شخصية، نبذة مختصرة،': 'Add a profile photo and a short bio,',
        'مهاراتك وأعمالك حتى يستطيع الآخرون': 'your skills and work so others can',
        'معرفة ما تقدمه بسهولة.': 'easily understand what you offer.',
        'حسّن ملفك الآن': 'Improve your profile now',
        'ظهورك في المنصة': 'Your presence on the platform',
        'ملفي العام': 'My public profile',
        'شاهد كيف يظهر ملفك للزوار': 'See how your profile appears to visitors',
        'واكتشف ما يحتاج إلى تحسين.': 'and discover what can be improved.',
        'مشاهدة ملفي العام': 'View my public profile',

        'إعدادات الواجهة': 'Interface settings',
        'خصص اللغة والمظهر بالطريقة التي تناسبك.': 'Customize language and appearance to suit you.',
        'اللغة': 'Language',
        'تغيير لغة واتجاه الواجهة': 'Change the interface language and direction',
        'العربية': 'Arabic',
        'واجهة من اليمين إلى اليسار': 'Right-to-left interface',
        'المظهر': 'Appearance',
        'اختر الثيم المفضل': 'Choose your preferred theme',
        'فاتح': 'Light',
        'داكن': 'Dark',
        'حسب الجهاز': 'System',
        'حجم الواجهة': 'Interface size',
        'حجم النص العام': 'Overall text size',
        'صغير': 'Small',
        'عادي': 'Normal',
        'كبير': 'Large',
        'تقليل الحركة': 'Reduce motion',
        'تقليل المؤثرات والانتقالات في الواجهة.': 'Reduce interface animations and transitions.',
        'يتم حفظ اختياراتك تلقائيًا على هذا الجهاز.': 'Your preferences are saved automatically on this device.',
        'إعادة الافتراضي': 'Reset defaults',
        'إغلاق': 'Close',
        'إغلاق الإعدادات': 'Close settings'
    };

    var originalText = new WeakMap();
    var originalAttributes = new WeakMap();

    function getSaved(key, fallback) {
        try {
            return localStorage.getItem(key) || fallback;
        } catch (e) {
            return fallback;
        }
    }

    function save(key, value) {
        try {
            localStorage.setItem(key, value);
        } catch (e) {}
    }

    function resolveTheme(preference) {
        if (preference === 'system') {
            return window.matchMedia &&
                window.matchMedia('(prefers-color-scheme: dark)').matches
                ? 'dark'
                : 'light';
        }

        return preference === 'dark' ? 'dark' : 'light';
    }

    function applyTheme(preference) {
        var normalized = ['light', 'dark', 'system'].includes(preference)
            ? preference
            : 'light';

        document.documentElement.dataset.themePreference = normalized;
        document.documentElement.dataset.theme = resolveTheme(normalized);

        var themeColor = document.querySelector('meta[name="theme-color"]');
        if (themeColor) {
            themeColor.setAttribute(
                'content',
                document.documentElement.dataset.theme === 'dark'
                    ? '#181b22'
                    : '#5e4ed0'
            );
        }
    }

    function translateValue(value, language) {
        if (language === 'ar') return value;

        var trimmed = value.trim();

        if (translations[trimmed]) {
            return value.replace(trimmed, translations[trimmed]);
        }

        var welcome = trimmed.match(/^أهلاً،\s*(.+)$/);
        if (welcome) {
            return value.replace(trimmed, 'Welcome, ' + welcome[1]);
        }

        return value;
    }

    function translatePage(language) {
        document.documentElement.lang = language;
        document.documentElement.dir = language === 'ar' ? 'rtl' : 'ltr';

        var walker = document.createTreeWalker(
            document.body,
            NodeFilter.SHOW_TEXT,
            {
                acceptNode: function (node) {
                    var parent = node.parentElement;
                    if (!parent) return NodeFilter.FILTER_REJECT;

                    var tag = parent.tagName;
                    if (['SCRIPT', 'STYLE', 'NOSCRIPT', 'TEXTAREA'].includes(tag)) {
                        return NodeFilter.FILTER_REJECT;
                    }

                    if (!node.nodeValue.trim()) {
                        return NodeFilter.FILTER_REJECT;
                    }

                    return NodeFilter.FILTER_ACCEPT;
                }
            }
        );

        var nodes = [];
        while (walker.nextNode()) nodes.push(walker.currentNode);

        nodes.forEach(function (node) {
            if (!originalText.has(node)) {
                originalText.set(node, node.nodeValue);
            }

            var original = originalText.get(node);
            node.nodeValue = language === 'ar'
                ? original
                : translateValue(original, 'en');
        });

        document.querySelectorAll('[placeholder], [title], [aria-label]').forEach(function (element) {
            if (!originalAttributes.has(element)) {
                originalAttributes.set(element, {
                    placeholder: element.getAttribute('placeholder'),
                    title: element.getAttribute('title'),
                    ariaLabel: element.getAttribute('aria-label')
                });
            }

            var attrs = originalAttributes.get(element);

            [
                ['placeholder', attrs.placeholder],
                ['title', attrs.title],
                ['aria-label', attrs.ariaLabel]
            ].forEach(function (pair) {
                var attr = pair[0];
                var original = pair[1];

                if (original === null) return;

                element.setAttribute(
                    attr,
                    language === 'ar'
                        ? original
                        : translateValue(original, 'en')
                );
            });
        });

        if (document.title) {
            if (!document.documentElement.dataset.originalTitle) {
                document.documentElement.dataset.originalTitle = document.title;
            }

            var originalTitle = document.documentElement.dataset.originalTitle;
            document.title = language === 'ar'
                ? originalTitle
                : originalTitle
                    .replace('لوحة المستخدم', 'User Dashboard')
                    .replace('إنشاء حساب', 'Create Account')
                    .replace('تسجيل الدخول', 'Login');
        }
    }

    function applyLanguage(language, persist) {
        var normalized = language === 'en' ? 'en' : 'ar';

        if (persist !== false) {
            save(STORAGE.language, normalized);
        }

        translatePage(normalized);
    }

    function applyFontSize(size) {
        var normalized = ['small', 'normal', 'large'].includes(size)
            ? size
            : 'normal';

        document.documentElement.dataset.fontSize = normalized;
    }

    function applyReducedMotion(enabled) {
        if (enabled) {
            document.documentElement.dataset.reducedMotion = 'true';
        } else {
            delete document.documentElement.dataset.reducedMotion;
        }
    }

    function setChecked(name, value) {
        var input = document.querySelector(
            'input[name="' + name + '"][value="' + value + '"]'
        );

        if (input) input.checked = true;
    }

    function syncSettingsControls() {
        var language = getSaved(STORAGE.language, 'ar');
        var theme = getSaved(STORAGE.theme, 'light');
        var fontSize = getSaved(STORAGE.fontSize, 'normal');
        var reducedMotion = getSaved(STORAGE.reducedMotion, '0') === '1';

        setChecked('naseja_language', language);
        setChecked('naseja_theme', theme);
        setChecked('naseja_font_size', fontSize);

        var motion = document.getElementById('nasejaReducedMotion');
        if (motion) motion.checked = reducedMotion;
    }

    function openSettings() {
        var modal = document.getElementById('nasejaSettingsModal');
        if (!modal) return;

        syncSettingsControls();

        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('naseja-settings-open');

        var closeButton = document.getElementById('nasejaSettingsClose');
        if (closeButton) {
            window.setTimeout(function () {
                closeButton.focus();
            }, 30);
        }
    }

    function closeSettings() {
        var modal = document.getElementById('nasejaSettingsModal');
        if (!modal) return;

        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('naseja-settings-open');

        var button = document.getElementById('nasejaSettingsButton');
        if (button) button.focus();
    }

    function resetSettings() {
        save(STORAGE.language, 'ar');
        save(STORAGE.theme, 'light');
        save(STORAGE.fontSize, 'normal');
        save(STORAGE.reducedMotion, '0');

        applyTheme('light');
        applyFontSize('normal');
        applyReducedMotion(false);
        applyLanguage('ar', false);
        syncSettingsControls();
    }

    document.addEventListener('DOMContentLoaded', function () {
        var language = getSaved(STORAGE.language, 'ar');
        var theme = getSaved(STORAGE.theme, 'light');
        var fontSize = getSaved(STORAGE.fontSize, 'normal');
        var reducedMotion = getSaved(STORAGE.reducedMotion, '0') === '1';

        applyTheme(theme);
        applyFontSize(fontSize);
        applyReducedMotion(reducedMotion);
        applyLanguage(language, false);

        var settingsButton = document.getElementById('nasejaSettingsButton');
        var closeButton = document.getElementById('nasejaSettingsClose');
        var backdrop = document.getElementById('nasejaSettingsBackdrop');
        var resetButton = document.getElementById('nasejaSettingsReset');

        if (settingsButton) {
            settingsButton.addEventListener('click', openSettings);
        }
        var dashboardSettingsButton = document.getElementById('nasejaDashboardSettingsButton');
        if (dashboardSettingsButton) {
            dashboardSettingsButton.addEventListener('click', openSettings);
        }

        if (closeButton) {
            closeButton.addEventListener('click', closeSettings);
        }

        if (backdrop) {
            backdrop.addEventListener('click', closeSettings);
        }

        if (resetButton) {
            resetButton.addEventListener('click', resetSettings);
        }

        document.querySelectorAll('input[name="naseja_language"]').forEach(function (input) {
            input.addEventListener('change', function () {
                if (!this.checked) return;
                applyLanguage(this.value, true);
                syncSettingsControls();

                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        });

        document.querySelectorAll('input[name="naseja_theme"]').forEach(function (input) {
            input.addEventListener('change', function () {
                if (!this.checked) return;
                save(STORAGE.theme, this.value);
                applyTheme(this.value);
            });
        });

        document.querySelectorAll('input[name="naseja_font_size"]').forEach(function (input) {
            input.addEventListener('change', function () {
                if (!this.checked) return;
                save(STORAGE.fontSize, this.value);
                applyFontSize(this.value);
            });
        });

        var reducedMotionInput = document.getElementById('nasejaReducedMotion');
        if (reducedMotionInput) {
            reducedMotionInput.addEventListener('change', function () {
                save(STORAGE.reducedMotion, this.checked ? '1' : '0');
                applyReducedMotion(this.checked);
            });
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeSettings();
            }
        });

        if (window.matchMedia) {
            var systemTheme = window.matchMedia('(prefers-color-scheme: dark)');
            var handleSystemTheme = function () {
                if (getSaved(STORAGE.theme, 'light') === 'system') {
                    applyTheme('system');
                }
            };

            if (systemTheme.addEventListener) {
                systemTheme.addEventListener('change', handleSystemTheme);
            } else if (systemTheme.addListener) {
                systemTheme.addListener(handleSystemTheme);
            }
        }

        /* =====================================================
           LUCIDE ICONS
        ====================================================== */

        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        /* =====================================================
           PWA
           Disable stale service-worker cache while developing.
        ====================================================== */

        if ('serviceWorker' in navigator) {
            @if(app()->environment('local'))
                navigator.serviceWorker.getRegistrations()
                    .then(function (registrations) {
                        registrations.forEach(function (registration) {
                            registration.unregister();
                        });
                    });

                if ('caches' in window) {
                    caches.keys().then(function (keys) {
                        keys.forEach(function (key) {
                            caches.delete(key);
                        });
                    });
                }
            @else
                window.addEventListener('load', function () {
                    navigator.serviceWorker
                        .register('{{ asset('sw.js') }}')
                        .catch(function (error) {
                            console.error(
                                'NASEJA PWA: Service Worker registration failed.',
                                error
                            );
                        });
                });
            @endif
        }
    });

})();
</script>




<script>
document.addEventListener('DOMContentLoaded', function () {
    var toggle = document.getElementById('nasejaMenuButton');
    var sidebar = document.getElementById('nasejaAccountSidebar');
    var backdrop = document.getElementById('nasejaMenuBackdrop');
    var close = document.getElementById('nasejaMenuClose');
    if (!toggle || !sidebar || !backdrop || !close) return;

    function setMenu(open, restoreFocus) {
        sidebar.classList.toggle('is-open', open);
        backdrop.hidden = !open;
        document.body.classList.toggle('naseja-menu-open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        toggle.setAttribute('aria-label', open ? 'إغلاق قائمة الحساب' : 'فتح قائمة الحساب');
        if (open) close.focus();
        else if (restoreFocus) toggle.focus();
    }
    toggle.addEventListener('click', function () { setMenu(!sidebar.classList.contains('is-open'), true); });
    close.addEventListener('click', function () { setMenu(false, true); });
    backdrop.addEventListener('click', function () { setMenu(false, true); });
    sidebar.addEventListener('click', function (event) {
        if (event.target.closest('#nasejaSettingsButton')) setMenu(false, false);
    });
    document.addEventListener('keydown', function (event) {
        if (!sidebar.classList.contains('is-open')) return;
        if (event.key === 'Escape') { setMenu(false, true); return; }
        if (event.key !== 'Tab') return;
        var items = Array.from(sidebar.querySelectorAll('a[href], button:not([disabled])'));
        if (!items.length) return;
        if (event.shiftKey && document.activeElement === items[0]) { event.preventDefault(); items[items.length - 1].focus(); }
        else if (!event.shiftKey && document.activeElement === items[items.length - 1]) { event.preventDefault(); items[0].focus(); }
    });
    window.addEventListener('resize', function () {
        if (window.innerWidth > 720 && sidebar.classList.contains('is-open')) setMenu(false, false);
    });
});
 </script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var wrap = document.getElementById('nasejaNotificationWrap');
    var button = document.getElementById('nasejaNotificationToggle');
    var menu = document.getElementById('nasejaNotificationMenu');
    if (!wrap || !button || !menu) return;
    function setOpen(open) {
        menu.hidden = !open;
        button.setAttribute('aria-expanded', open ? 'true' : 'false');
    }
    button.addEventListener('click', function () { setOpen(menu.hidden); });
    document.addEventListener('click', function (event) {
        if (!wrap.contains(event.target)) setOpen(false);
    });
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !menu.hidden) {
            setOpen(false);
            button.focus();
        }
    });
});
</script>
</body>

</html>
