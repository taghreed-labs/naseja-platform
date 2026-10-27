@extends('layouts.admin.admin')

@section('title', 'لوحة التحكم')
@section('page-title', 'لوحة التحكم')

@section('content')

<div class="admin-page-heading">

    <div>
        <h1>
            مرحبًا، {{ auth()->user()->name }}
        </h1>

        <p>
            نظرة سريعة على منصة NASEJA والوصول إلى أقسام الإدارة.
        </p>
    </div>

    <div class="admin-status-tag">
        <span class="admin-status-dot"></span>
        النظام يعمل بشكل طبيعي
    </div>

</div>


{{-- ============================================================
     الإحصائيات
============================================================ --}}

<div class="admin-dashboard-stats">

    <article class="admin-dashboard-stat">

        <div class="admin-dashboard-stat-icon blue">
            <i data-lucide="users-round"></i>
        </div>

        <div>
            <span>المستخدمون</span>
            <strong>{{ $usersCount }}</strong>
            <small>إجمالي الحسابات</small>
        </div>

    </article>


    <article class="admin-dashboard-stat">

        <div class="admin-dashboard-stat-icon purple">
            <i data-lucide="user-round-check"></i>
        </div>

        <div>
            <span>طلبات الانضمام</span>
            <strong>{{ $pendingRequestsCount }}</strong>
            <small>طلبات بانتظار المراجعة</small>
        </div>

    </article>


    <article class="admin-dashboard-stat">

        <div class="admin-dashboard-stat-icon green">
            <i data-lucide="briefcase-business"></i>
        </div>

        <div>
            <span>الخدمات</span>
            <strong>{{ $servicesCount }}</strong>
            <small>خدمات داخل المنصة</small>
        </div>

    </article>


    <article class="admin-dashboard-stat">

        <div class="admin-dashboard-stat-icon orange">
            <i data-lucide="images"></i>
        </div>

        <div>
            <span>الأعمال</span>
            <strong>{{ $portfolioCount }}</strong>
            <small>أعمال مضافة</small>
        </div>

    </article>

</div>


{{-- ============================================================
     المحتوى
============================================================ --}}

<div class="admin-dashboard-grid">


    {{-- ========================================================
         الوصول السريع
    ========================================================= --}}

    <section class="admin-card admin-quick-card">

        <div class="admin-dashboard-section-head">

            <div>
                <h2>الوصول السريع</h2>
                <p>انتقل مباشرة إلى أقسام الإدارة.</p>
            </div>

            <div class="admin-dashboard-section-icon">
                <i data-lucide="zap"></i>
            </div>

        </div>


        <div class="admin-quick-grid">


            <a
                href="{{ route('admin.join-requests.index') }}"
                class="admin-quick-item"
            >

                <div class="admin-quick-icon purple">
                    <i data-lucide="user-round-check"></i>
                </div>

                <div>
                    <strong>طلبات الانضمام</strong>
                    <span>مراجعة قبول ورفض الطلبات</span>
                </div>

                <i
                    data-lucide="chevron-left"
                    class="admin-quick-arrow"
                ></i>

            </a>


            <a
                href="{{ route('admin.users.index') }}"
                class="admin-quick-item"
            >

                <div class="admin-quick-icon blue">
                    <i data-lucide="users-round"></i>
                </div>

                <div>
                    <strong>إدارة المستخدمين</strong>
                    <span>عرض وتفعيل وتعطيل الحسابات</span>
                </div>

                <i
                    data-lucide="chevron-left"
                    class="admin-quick-arrow"
                ></i>

            </a>


            <a
                href="{{ route('admin.categories.index') }}"
                class="admin-quick-item"
            >

                <div class="admin-quick-icon lavender">
                    <i data-lucide="layout-grid"></i>
                </div>

                <div>
                    <strong>التصنيفات</strong>
                    <span>إضافة وتنظيم مجالات المنصة</span>
                </div>

                <i
                    data-lucide="chevron-left"
                    class="admin-quick-arrow"
                ></i>

            </a>


            <a
                href="{{ route('admin.skills.index') }}"
                class="admin-quick-item"
            >

                <div class="admin-quick-icon green">
                    <i data-lucide="sparkles"></i>
                </div>

                <div>
                    <strong>المهارات</strong>
                    <span>إضافة وإدارة مهارات التصنيفات</span>
                </div>

                <i
                    data-lucide="chevron-left"
                    class="admin-quick-arrow"
                ></i>

            </a>


            <a
                href="{{ route('admin.services.index') }}"
                class="admin-quick-item"
            >

                <div class="admin-quick-icon orange">
                    <i data-lucide="briefcase-business"></i>
                </div>

                <div>
                    <strong>الخدمات</strong>
                    <span>مراجعة وتفعيل وتعطيل الخدمات</span>
                </div>

                <i
                    data-lucide="chevron-left"
                    class="admin-quick-arrow"
                ></i>

            </a>


            <a
                href="{{ route('admin.portfolio.index') }}"
                class="admin-quick-item"
            >

                <div class="admin-quick-icon rose">
                    <i data-lucide="images"></i>
                </div>

                <div>
                    <strong>الأعمال</strong>
                    <span>مراجعة وتفعيل وتعطيل الأعمال</span>
                </div>

                <i
                    data-lucide="chevron-left"
                    class="admin-quick-arrow"
                ></i>

            </a>


            <a
                href="{{ route('admin.reports.index') }}"
                class="admin-quick-item"
            >

                <div class="admin-quick-icon rose">
                    <i data-lucide="triangle-alert"></i>
                </div>

                <div>
                    <strong>البلاغات</strong>
                    <span>مراجعة البلاغات واتخاذ الإجراء</span>
                </div>

                <i
                    data-lucide="chevron-left"
                    class="admin-quick-arrow"
                ></i>

            </a>


            <a
                href="{{ route('admin.settings.index') }}"
                class="admin-quick-item"
            >

                <div class="admin-quick-icon blue">
                    <i data-lucide="settings-2"></i>
                </div>

                <div>
                    <strong>الإعدادات</strong>
                    <span>إدارة حساب مدير النظام وكلمة المرور</span>
                </div>

                <i
                    data-lucide="chevron-left"
                    class="admin-quick-arrow"
                ></i>

            </a>

        </div>

    </section>



    {{-- ========================================================
         ملخص المنصة
    ========================================================= --}}

    <section class="admin-card admin-summary-card">

        <div class="admin-dashboard-section-head">

            <div>
                <h2>ملخص المنصة</h2>
                <p>نظرة سريعة على المحتوى الحالي.</p>
            </div>

            <div class="admin-dashboard-section-icon">
                <i data-lucide="chart-no-axes-combined"></i>
            </div>

        </div>


        @php
            $dashboardTotal =
                max(
                    1,
                    $usersCount +
                    $servicesCount +
                    $portfolioCount
                );

            $usersPercent =
                round(
                    ($usersCount / $dashboardTotal) * 100
                );

            $servicesPercent =
                round(
                    ($servicesCount / $dashboardTotal) * 100
                );

            $portfolioPercent =
                round(
                    ($portfolioCount / $dashboardTotal) * 100
                );
        @endphp


        <div class="admin-summary-list">

            <div class="admin-summary-row">

                <div class="admin-summary-row-top">
                    <span>المستخدمون</span>
                    <strong>{{ $usersCount }}</strong>
                </div>

                <div class="admin-summary-track">
                    <span style="width: {{ $usersPercent }}%"></span>
                </div>

            </div>


            <div class="admin-summary-row">

                <div class="admin-summary-row-top">
                    <span>الخدمات</span>
                    <strong>{{ $servicesCount }}</strong>
                </div>

                <div class="admin-summary-track">
                    <span style="width: {{ $servicesPercent }}%"></span>
                </div>

            </div>


            <div class="admin-summary-row">

                <div class="admin-summary-row-top">
                    <span>الأعمال</span>
                    <strong>{{ $portfolioCount }}</strong>
                </div>

                <div class="admin-summary-track">
                    <span style="width: {{ $portfolioPercent }}%"></span>
                </div>

            </div>

        </div>


        <div class="admin-summary-note">

            <div class="admin-summary-note-icon">
                <i data-lucide="shield-check"></i>
            </div>

            <div>
                <strong>إدارة مركزية</strong>
                <span>
                    يمكنك الآن إدارة المستخدمين والتصنيفات والمهارات من لوحة واحدة.
                </span>
            </div>

        </div>

    </section>

</div>



{{-- ============================================================
     أحدث طلبات الانضمام
============================================================ --}}

<section class="admin-card admin-latest-card">

    <div class="admin-dashboard-section-head">

        <div>
            <h2>أحدث طلبات الانضمام</h2>
            <p>أحدث الحسابات التي ما زالت بانتظار الاعتماد.</p>
        </div>

        <a
            href="{{ route('admin.join-requests.index') }}"
            class="admin-view-all"
        >
            عرض الكل
            <i data-lucide="arrow-left"></i>
        </a>

    </div>


    @if($latestJoinRequests->count())

        <div class="admin-latest-table-wrap">

            <table class="admin-latest-table">

                <thead>
                    <tr>
                        <th>المستخدم</th>
                        <th>البريد الإلكتروني</th>
                        <th>تاريخ الطلب</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($latestJoinRequests as $requestUser)

                        <tr>

                            <td>

                                <div class="admin-latest-user">

                                    <div class="admin-latest-avatar">
                                        {{ mb_substr($requestUser->name, 0, 1) }}
                                    </div>

                                    <div>
                                        <strong>
                                            {{ $requestUser->name }}
                                        </strong>

                                        <span>
                                            #{{ $requestUser->id }}
                                        </span>
                                    </div>

                                </div>

                            </td>


                            <td>
                                {{ $requestUser->email }}
                            </td>


                            <td>
                                {{ $requestUser->created_at?->format('Y/m/d') }}
                            </td>


                            <td>

                                <div class="admin-latest-actions">

                                    <form
                                        action="{{ route('admin.join-requests.approve', $requestUser) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="admin-latest-action approve"
                                            title="قبول"
                                        >
                                            <i data-lucide="check"></i>
                                        </button>
                                    </form>


                                    <form
                                        action="{{ route('admin.join-requests.reject', $requestUser) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="admin-latest-action reject"
                                            title="رفض"
                                            onclick="return confirm('هل تريد رفض طلب الانضمام؟')"
                                        >
                                            <i data-lucide="x"></i>
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="admin-dashboard-empty">

            <div>
                <i data-lucide="circle-check-big"></i>
            </div>

            <strong>
                لا توجد طلبات انضمام معلقة
            </strong>

            <span>
                جميع الطلبات الحالية تمت مراجعتها.
            </span>

        </div>

    @endif

</section>

@endsection



@push('styles')

<style>

    .admin-dashboard-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 18px;
    }

    .admin-dashboard-stat {
        min-height: 104px;
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px;
        background: #ffffff;
        border: 1px solid #e8edf5;
        border-radius: 19px;
        box-shadow: 0 12px 32px rgba(35, 48, 74, .035);
    }

    .admin-dashboard-stat-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 15px;
    }

    .admin-dashboard-stat-icon svg {
        width: 21px;
        height: 21px;
    }

    .admin-dashboard-stat-icon.blue {
        background: #edf2ff;
        color: #5975df;
    }

    .admin-dashboard-stat-icon.purple {
        background: #f2edff;
        color: #7a61dc;
    }

    .admin-dashboard-stat-icon.green {
        background: #eaf8f2;
        color: #248b68;
    }

    .admin-dashboard-stat-icon.orange {
        background: #fff3e8;
        color: #d88731;
    }

    .admin-dashboard-stat span {
        display: block;
        margin-bottom: 4px;
        color: #8e99aa;
        font-size: 9px;
        font-weight: 700;
    }

    .admin-dashboard-stat strong {
        display: block;
        color: #334055;
        font-size: 22px;
        font-weight: 900;
        line-height: 1.1;
    }

    .admin-dashboard-stat small {
        display: block;
        margin-top: 5px;
        color: #a0a9b7;
        font-size: 8px;
        font-weight: 600;
    }


    .admin-dashboard-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.65fr) minmax(280px, .75fr);
        gap: 17px;
        margin-bottom: 17px;
    }

    .admin-quick-card,
    .admin-summary-card,
    .admin-latest-card {
        padding: 20px;
    }

    .admin-dashboard-section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 18px;
    }

    .admin-dashboard-section-head h2 {
        color: #354156;
        font-size: 14px;
        font-weight: 900;
    }

    .admin-dashboard-section-head p {
        margin-top: 4px;
        color: #939dac;
        font-size: 9px;
        line-height: 1.7;
    }

    .admin-dashboard-section-icon {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 12px;
        background: #f0f3ff;
        color: #6074d7;
    }

    .admin-dashboard-section-icon svg {
        width: 17px;
        height: 17px;
    }


    .admin-quick-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .admin-quick-item {
        position: relative;
        min-height: 84px;
        display: grid;
        grid-template-columns: 41px 1fr 17px;
        align-items: center;
        gap: 11px;
        padding: 13px;
        border: 1px solid #e9edf4;
        border-radius: 15px;
        background: #fbfcfe;
        transition: .2s ease;
    }

    a.admin-quick-item:hover {
        transform: translateY(-2px);
        border-color: #d9e0fa;
        background: #ffffff;
        box-shadow: 0 10px 26px rgba(51, 67, 104, .06);
    }

    .admin-quick-item.disabled {
        opacity: .6;
        cursor: not-allowed;
    }

    .admin-quick-icon {
        width: 41px;
        height: 41px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
    }

    .admin-quick-icon svg {
        width: 18px;
        height: 18px;
    }

    .admin-quick-icon.blue {
        background: #edf2ff;
        color: #5975df;
    }

    .admin-quick-icon.purple,
    .admin-quick-icon.lavender {
        background: #f2edff;
        color: #765fd6;
    }

    .admin-quick-icon.green {
        background: #eaf8f2;
        color: #278a69;
    }

    .admin-quick-icon.orange {
        background: #fff3e8;
        color: #d88731;
    }

    .admin-quick-icon.rose {
        background: #fff0f3;
        color: #d75c70;
    }

    .admin-quick-item strong {
        display: block;
        margin-bottom: 4px;
        color: #3b465a;
        font-size: 10.5px;
        font-weight: 900;
    }

    .admin-quick-item span {
        display: block;
        color: #969faf;
        font-size: 8.5px;
        line-height: 1.55;
    }

    .admin-quick-arrow {
        width: 15px;
        height: 15px;
        color: #a0a9b6;
    }


    .admin-summary-list {
        display: flex;
        flex-direction: column;
        gap: 17px;
    }

    .admin-summary-row-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 7px;
        color: #687488;
        font-size: 9.5px;
        font-weight: 700;
    }

    .admin-summary-row-top strong {
        color: #3e4a5e;
        font-size: 10px;
    }

    .admin-summary-track {
        height: 7px;
        overflow: hidden;
        border-radius: 20px;
        background: #eef1f6;
    }

    .admin-summary-track span {
        display: block;
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, #6681f4, #8871ed);
    }

    .admin-summary-note {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 22px;
        padding: 13px;
        border: 1px solid #e9edf5;
        border-radius: 14px;
        background: #fafbfe;
    }

    .admin-summary-note-icon {
        width: 37px;
        height: 37px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 11px;
        background: #eaf8f2;
        color: #278b69;
    }

    .admin-summary-note-icon svg {
        width: 17px;
        height: 17px;
    }

    .admin-summary-note strong {
        display: block;
        margin-bottom: 3px;
        color: #414c60;
        font-size: 9.5px;
        font-weight: 900;
    }

    .admin-summary-note span {
        display: block;
        color: #929cab;
        font-size: 8px;
        line-height: 1.6;
    }


    .admin-view-all {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 10px;
        border-radius: 10px;
        background: #eef2ff;
        color: #5770d5;
        font-size: 9px;
        font-weight: 800;
    }

    .admin-view-all svg {
        width: 13px;
        height: 13px;
    }


    .admin-latest-table-wrap {
        overflow-x: auto;
    }

    .admin-latest-table {
        width: 100%;
        border-collapse: collapse;
    }

    .admin-latest-table th {
        padding: 11px 13px;
        background: #fafbfe;
        color: #929cac;
        text-align: right;
        white-space: nowrap;
        font-size: 8.5px;
        font-weight: 800;
    }

    .admin-latest-table td {
        padding: 13px;
        border-top: 1px solid #f0f3f7;
        color: #687488;
        white-space: nowrap;
        font-size: 9.5px;
    }

    .admin-latest-user {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .admin-latest-avatar {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: linear-gradient(135deg, #edf2ff, #f2edff);
        color: #5b72d7;
        font-weight: 900;
    }

    .admin-latest-user strong {
        display: block;
        margin-bottom: 2px;
        color: #3c475b;
        font-size: 9.5px;
    }

    .admin-latest-user span {
        color: #a0a9b6;
        font-size: 7.5px;
    }

    .admin-latest-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .admin-latest-actions form {
        margin: 0;
    }

    .admin-latest-action {
        width: 31px;
        height: 31px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 9px;
        cursor: pointer;
    }

    .admin-latest-action svg {
        width: 14px;
        height: 14px;
    }

    .admin-latest-action.approve {
        background: #eaf8f2;
        color: #248b68;
    }

    .admin-latest-action.reject {
        background: #fff0f1;
        color: #d6545d;
    }


    .admin-dashboard-empty {
        min-height: 210px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .admin-dashboard-empty > div {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 11px;
        border-radius: 17px;
        background: #eaf8f2;
        color: #258a68;
    }

    .admin-dashboard-empty svg {
        width: 23px;
        height: 23px;
    }

    .admin-dashboard-empty strong {
        color: #414c60;
        font-size: 11px;
    }

    .admin-dashboard-empty span {
        margin-top: 5px;
        color: #979faf;
        font-size: 9px;
    }


    @media(max-width: 1150px) {

        .admin-dashboard-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .admin-dashboard-grid {
            grid-template-columns: 1fr;
        }

    }

    @media(max-width: 650px) {

        .admin-dashboard-stats,
        .admin-quick-grid {
            grid-template-columns: 1fr;
        }

    }

</style>

@endpush
