@extends('layouts.admin.admin')

@section('title', 'إدارة البلاغات')
@section('page-title', 'إدارة البلاغات')

@section('content')

<div class="admin-page-heading">

    <div>

        <h1>
            إدارة البلاغات
        </h1>

        <p>
            مراجعة بلاغات المستخدمين واتخاذ الإجراء المناسب.
        </p>

    </div>

</div>



{{-- =========================================================
     الرسائل
========================================================= --}}

@if(session('success'))

    <div class="reports-alert success">

        <i data-lucide="circle-check"></i>

        <span>
            {{ session('success') }}
        </span>

    </div>

@endif


@if($errors->any())

    <div class="reports-alert error">

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



{{-- =========================================================
     الإحصائيات
========================================================= --}}

<div class="reports-stats">


    <article class="reports-stat-card">

        <div class="reports-stat-icon blue">
            <i data-lucide="triangle-alert"></i>
        </div>

        <div>

            <span>
                إجمالي البلاغات
            </span>

            <strong>
                {{ $totalReports }}
            </strong>

        </div>

    </article>



    <article class="reports-stat-card">

        <div class="reports-stat-icon orange">
            <i data-lucide="clock-3"></i>
        </div>

        <div>

            <span>
                قيد المراجعة
            </span>

            <strong>
                {{ $pendingReports }}
            </strong>

        </div>

    </article>



    <article class="reports-stat-card">

        <div class="reports-stat-icon green">
            <i data-lucide="circle-check"></i>
        </div>

        <div>

            <span>
                تم حلها
            </span>

            <strong>
                {{ $resolvedReports }}
            </strong>

        </div>

    </article>



    <article class="reports-stat-card">

        <div class="reports-stat-icon red">
            <i data-lucide="circle-x"></i>
        </div>

        <div>

            <span>
                مستبعدة
            </span>

            <strong>
                {{ $dismissedReports }}
            </strong>

        </div>

    </article>


</div>



<section class="admin-card reports-main-card">


    {{-- =====================================================
         البحث والفلترة
    ===================================================== --}}

    <div class="reports-toolbar">

        <form
            method="GET"
            action="{{ route('admin.reports.index') }}"
            class="reports-filter-form"
        >


            <div class="reports-search">

                <i data-lucide="search"></i>

                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="ابحث بالسبب أو اسم المستخدم..."
                >

            </div>



            <select name="type">

                <option value="">
                    كل أنواع البلاغات
                </option>

                @foreach($reportTypes as $reportType)

                    <option
                        value="{{ $reportType }}"
                        {{ $type === $reportType ? 'selected' : '' }}
                    >
                        {{ $reportType }}
                    </option>

                @endforeach

            </select>



            <select name="status">

                <option value="">
                    كل الحالات
                </option>

                <option
                    value="pending"
                    {{ $status === 'pending' ? 'selected' : '' }}
                >
                    قيد المراجعة
                </option>

                <option
                    value="resolved"
                    {{ $status === 'resolved' ? 'selected' : '' }}
                >
                    محلولة
                </option>

                <option
                    value="dismissed"
                    {{ $status === 'dismissed' ? 'selected' : '' }}
                >
                    مستبعدة
                </option>

            </select>



            <button
                type="submit"
                class="reports-filter-btn"
            >
                <i data-lucide="sliders-horizontal"></i>
                تطبيق
            </button>



            <a
                href="{{ route('admin.reports.index') }}"
                class="reports-reset-btn"
            >
                <i data-lucide="rotate-ccw"></i>
                إعادة ضبط
            </a>


        </form>

    </div>



    {{-- =====================================================
         قائمة البلاغات
    ===================================================== --}}

    @if($reports->count())


        <div class="reports-list">


            @foreach($reports as $report)


                <article class="report-card">


                    {{-- =================================================
                         رأس البلاغ
                    ================================================== --}}

                    <div class="report-card-head">


                        <div class="report-id-wrap">

                            <div class="report-id-icon">
                                <i data-lucide="triangle-alert"></i>
                            </div>

                            <div>

                                <div class="report-id-line">

                                    <strong>
                                        بلاغ #{{ $report->id }}
                                    </strong>


                                    @if($report->status === 'pending')

                                        <span class="report-status pending">
                                            قيد المراجعة
                                        </span>

                                    @elseif($report->status === 'resolved')

                                        <span class="report-status resolved">
                                            تم الحل
                                        </span>

                                    @elseif($report->status === 'dismissed')

                                        <span class="report-status dismissed">
                                            مستبعد
                                        </span>

                                    @else

                                        <span class="report-status neutral">
                                            {{ $report->status }}
                                        </span>

                                    @endif

                                </div>


                                <span class="report-created-at">

                                    <i data-lucide="calendar-days"></i>

                                    {{
                                        $report->created_at
                                            ? $report->created_at->format('Y/m/d - H:i')
                                            : '—'
                                    }}

                                </span>

                            </div>

                        </div>


                        <span class="report-type">
                            {{ $report->type }}
                        </span>


                    </div>



                    {{-- =================================================
                         المستخدمون
                    ================================================== --}}

                    <div class="report-users-grid">


                        <div class="report-user-box">

                            <span class="report-user-label">
                                مقدم البلاغ
                            </span>


                            <div class="report-user-content">

                                <div class="report-user-avatar reporter">
                                    {{
                                        mb_substr(
                                            $report->reporter?->name ?? 'زائر',
                                            0,
                                            1
                                        )
                                    }}
                                </div>


                                <div>

                                    <strong>
                                        {{
                                            $report->reporter?->name
                                            ?? 'زائر'
                                        }}
                                    </strong>

                                    <small>
                                        {{
                                            $report->reporter?->email
                                            ?? 'بلاغ بدون حساب'
                                        }}
                                    </small>

                                </div>

                            </div>

                        </div>



                        <div class="report-user-box">

                            <span class="report-user-label">
                                المبلّغ عنه
                            </span>


                            <div class="report-user-content">

                                <div class="report-user-avatar reported">
                                    {{
                                        mb_substr(
                                            $report->reportedUser?->name ?? '؟',
                                            0,
                                            1
                                        )
                                    }}
                                </div>


                                <div>

                                    <strong>
                                        {{
                                            $report->reportedUser?->name
                                            ?? 'غير محدد'
                                        }}
                                    </strong>

                                    <small>
                                        {{
                                            $report->reportedUser?->email
                                            ?? '—'
                                        }}
                                    </small>

                                </div>

                            </div>

                        </div>


                    </div>



                    {{-- =================================================
                         محتوى البلاغ
                    ================================================== --}}

                    <div class="report-content">


                        <div class="report-content-block">

                            <span class="report-content-label">
                                سبب البلاغ
                            </span>

                            <p>
                                {{ $report->reason }}
                            </p>

                        </div>



                        @if($report->description)

                            <div class="report-content-block">

                                <span class="report-content-label">
                                    تفاصيل إضافية
                                </span>

                                <p>
                                    {{ $report->description }}
                                </p>

                            </div>

                        @endif



                        @if($report->admin_note)

                            <div class="report-admin-note">

                                <div class="report-admin-note-head">

                                    <i data-lucide="shield-check"></i>

                                    <strong>
                                        ملاحظة الإدارة
                                    </strong>

                                </div>

                                <p>
                                    {{ $report->admin_note }}
                                </p>

                            </div>

                        @endif



                        @if($report->resolved_at)

                            <div class="report-resolved-date">

                                <i data-lucide="clock-3"></i>

                                تمت المعالجة:
                                {{ $report->resolved_at->format('Y/m/d - H:i') }}

                            </div>

                        @endif


                    </div>



                    {{-- =================================================
                         الإجراءات
                    ================================================== --}}

                    <div class="report-actions">


                        @if($report->status === 'pending')


                            <form
                                method="POST"
                                action="{{ route('admin.reports.resolve', $report) }}"
                                class="report-action-form"
                            >

                                @csrf
                                @method('PATCH')


                                <textarea
                                    name="admin_note"
                                    rows="2"
                                    maxlength="2000"
                                    placeholder="ملاحظة الإدارة عند الحل - اختيارية"
                                ></textarea>


                                <button
                                    type="submit"
                                    class="report-action-btn resolve"
                                    onclick="return confirm('هل تريد اعتبار هذا البلاغ محلولًا؟')"
                                >

                                    <i data-lucide="circle-check"></i>

                                    حل البلاغ

                                </button>

                            </form>



                            <form
                                method="POST"
                                action="{{ route('admin.reports.dismiss', $report) }}"
                                class="report-action-form"
                            >

                                @csrf
                                @method('PATCH')


                                <textarea
                                    name="admin_note"
                                    rows="2"
                                    maxlength="2000"
                                    placeholder="سبب الاستبعاد - اختياري"
                                ></textarea>


                                <button
                                    type="submit"
                                    class="report-action-btn dismiss"
                                    onclick="return confirm('هل تريد استبعاد هذا البلاغ؟')"
                                >

                                    <i data-lucide="circle-x"></i>

                                    استبعاد

                                </button>

                            </form>


                        @else


                            <form
                                method="POST"
                                action="{{ route('admin.reports.reopen', $report) }}"
                            >

                                @csrf
                                @method('PATCH')


                                <button
                                    type="submit"
                                    class="report-action-btn reopen"
                                    onclick="return confirm('هل تريد إعادة فتح هذا البلاغ؟')"
                                >

                                    <i data-lucide="rotate-ccw"></i>

                                    إعادة فتح البلاغ

                                </button>

                            </form>


                        @endif


                    </div>


                </article>


            @endforeach


        </div>



        <div class="reports-pagination">
            {{ $reports->links() }}
        </div>


    @else


        <div class="reports-empty">

            <div class="reports-empty-icon">
                <i data-lucide="shield-check"></i>
            </div>

            <h2>
                لا توجد بلاغات
            </h2>

            <p>
                لا توجد بلاغات مطابقة للبحث أو الفلاتر الحالية.
            </p>

        </div>


    @endif


</section>

@endsection



@push('styles')

<style>

    .reports-alert {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        padding: 12px 15px;
        margin-bottom: 16px;
        border-radius: 14px;
        font-size: 10.5px;
        font-weight: 700;
    }

    .reports-alert svg {
        width: 17px;
        height: 17px;
        flex-shrink: 0;
    }

    .reports-alert.success {
        background: #eaf8f2;
        border: 1px solid #d5eee4;
        color: #268566;
    }

    .reports-alert.error {
        background: #fff0f1;
        border: 1px solid #f2d8db;
        color: #ce5059;
    }


    .reports-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 18px;
    }

    .reports-stat-card {
        min-height: 88px;
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 17px;
        background: #fff;
        border: 1px solid #e8edf5;
        border-radius: 18px;
    }

    .reports-stat-icon {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 14px;
    }

    .reports-stat-icon svg {
        width: 20px;
        height: 20px;
    }

    .reports-stat-icon.blue {
        background: #edf2ff;
        color: #5874dd;
    }

    .reports-stat-icon.orange {
        background: #fff3e7;
        color: #d88a32;
    }

    .reports-stat-icon.green {
        background: #eaf8f2;
        color: #248b68;
    }

    .reports-stat-icon.red {
        background: #fff0f1;
        color: #d4545e;
    }

    .reports-stat-card span {
        display: block;
        margin-bottom: 4px;
        color: #939dac;
        font-size: 9px;
    }

    .reports-stat-card strong {
        color: #354055;
        font-size: 21px;
        font-weight: 900;
    }


    .reports-main-card {
        overflow: hidden;
    }

    .reports-toolbar {
        padding: 18px 20px;
        border-bottom: 1px solid #edf1f6;
    }

    .reports-filter-form {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 9px;
    }

    .reports-search {
        width: 300px;
        height: 42px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0 12px;
        border: 1px solid #e8edf4;
        border-radius: 12px;
        background: #f8fafe;
    }

    .reports-search svg {
        width: 16px;
        height: 16px;
        color: #99a4b4;
    }

    .reports-search input {
        width: 100%;
        border: 0;
        outline: 0;
        background: transparent;
        font-size: 10px;
    }

    .reports-filter-form select {
        min-width: 155px;
        height: 42px;
        padding: 0 10px;
        border: 1px solid #e8edf4;
        border-radius: 12px;
        background: #fff;
        color: #657185;
        outline: 0;
        font-size: 10px;
    }

    .reports-filter-btn,
    .reports-reset-btn {
        height: 42px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0 13px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 800;
    }

    .reports-filter-btn {
        border: 0;
        background: #5b7cff;
        color: #fff;
        cursor: pointer;
    }

    .reports-reset-btn {
        border: 1px solid #e7ebf2;
        background: #fff;
        color: #748095;
    }

    .reports-filter-btn svg,
    .reports-reset-btn svg {
        width: 14px;
        height: 14px;
    }


    .reports-list {
        display: grid;
        gap: 14px;
        padding: 18px;
    }

    .report-card {
        overflow: hidden;
        border: 1px solid #e8edf5;
        border-radius: 18px;
        background: #fff;
    }


    .report-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 15px 17px;
        border-bottom: 1px solid #edf1f6;
        background: #fbfcfe;
    }

    .report-id-wrap {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .report-id-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 13px;
        background: #fff1e8;
        color: #d77d43;
    }

    .report-id-icon svg {
        width: 18px;
        height: 18px;
    }

    .report-id-line {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;
    }

    .report-id-line strong {
        color: #374257;
        font-size: 11px;
        font-weight: 900;
    }

    .report-created-at {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 4px;
        color: #9aa3b2;
        font-size: 8px;
    }

    .report-created-at svg {
        width: 11px;
        height: 11px;
    }

    .report-type {
        display: inline-flex;
        padding: 6px 10px;
        border-radius: 20px;
        background: #f1edff;
        color: #7460ca;
        font-size: 8.5px;
        font-weight: 900;
    }


    .report-status {
        display: inline-flex;
        padding: 5px 8px;
        border-radius: 20px;
        font-size: 8px;
        font-weight: 900;
    }

    .report-status.pending {
        background: #fff4e5;
        color: #c67d2c;
    }

    .report-status.resolved {
        background: #eaf8f2;
        color: #248b68;
    }

    .report-status.dismissed {
        background: #fff0f1;
        color: #d4545e;
    }

    .report-status.neutral {
        background: #f1f3f6;
        color: #737e90;
    }


    .report-users-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
        padding: 15px 17px 0;
    }

    .report-user-box {
        padding: 12px;
        border: 1px solid #edf0f5;
        border-radius: 13px;
        background: #fafbfe;
    }

    .report-user-label {
        display: block;
        margin-bottom: 8px;
        color: #99a3b2;
        font-size: 8px;
        font-weight: 800;
    }

    .report-user-content {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .report-user-avatar {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 900;
    }

    .report-user-avatar.reporter {
        background: #edf2ff;
        color: #5c73d7;
    }

    .report-user-avatar.reported {
        background: #fff0f1;
        color: #cf5961;
    }

    .report-user-content strong {
        display: block;
        color: #424d60;
        font-size: 9.5px;
        font-weight: 900;
    }

    .report-user-content small {
        display: block;
        margin-top: 2px;
        color: #9ba4b2;
        font-size: 7.5px;
    }


    .report-content {
        padding: 15px 17px;
    }

    .report-content-block + .report-content-block {
        margin-top: 11px;
    }

    .report-content-label {
        display: block;
        margin-bottom: 5px;
        color: #929cab;
        font-size: 8px;
        font-weight: 800;
    }

    .report-content-block p {
        margin: 0;
        color: #596579;
        font-size: 9.5px;
        line-height: 1.9;
        white-space: pre-line;
    }


    .report-admin-note {
        margin-top: 13px;
        padding: 11px 12px;
        border: 1px solid #ddd9f7;
        border-radius: 12px;
        background: #f7f5ff;
    }

    .report-admin-note-head {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #6e5fc1;
        font-size: 8.5px;
    }

    .report-admin-note-head svg {
        width: 13px;
        height: 13px;
    }

    .report-admin-note p {
        margin: 6px 0 0;
        color: #66617d;
        font-size: 9px;
        line-height: 1.8;
        white-space: pre-line;
    }

    .report-resolved-date {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 10px;
        color: #919bab;
        font-size: 8px;
    }

    .report-resolved-date svg {
        width: 12px;
        height: 12px;
    }


    .report-actions {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
        padding: 14px 17px;
        border-top: 1px solid #edf1f6;
        background: #fbfcfe;
    }

    .report-action-form {
        display: grid;
        gap: 8px;
    }

    .report-action-form textarea {
        width: 100%;
        min-height: 62px;
        resize: vertical;
        padding: 9px 10px;
        border: 1px solid #e5eaf1;
        border-radius: 10px;
        background: #fff;
        color: #566176;
        outline: none;
        font-family: inherit;
        font-size: 8.5px;
        line-height: 1.6;
    }

    .report-action-form textarea:focus {
        border-color: #b9c6f7;
        box-shadow: 0 0 0 3px rgba(91, 124, 255, .07);
    }

    .report-action-btn {
        min-height: 37px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 0 12px;
        border: 0;
        border-radius: 10px;
        cursor: pointer;
        font-family: inherit;
        font-size: 8.8px;
        font-weight: 900;
    }

    .report-action-btn svg {
        width: 14px;
        height: 14px;
    }

    .report-action-btn.resolve {
        background: #eaf8f2;
        color: #248b68;
    }

    .report-action-btn.dismiss {
        background: #fff0f1;
        color: #d4545e;
    }

    .report-action-btn.reopen {
        background: #edf2ff;
        color: #5872d9;
    }


    .reports-pagination {
        padding: 16px 20px;
        border-top: 1px solid #edf1f6;
    }


    .reports-empty {
        min-height: 320px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 25px;
        text-align: center;
    }

    .reports-empty-icon {
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 13px;
        border-radius: 20px;
        background: linear-gradient(135deg, #edf2ff, #f3efff);
        color: #6074d7;
    }

    .reports-empty-icon svg {
        width: 25px;
        height: 25px;
    }

    .reports-empty h2 {
        margin: 0 0 5px;
        color: #3e495d;
        font-size: 14px;
    }

    .reports-empty p {
        margin: 0;
        color: #929cab;
        font-size: 9.5px;
    }


    @media(max-width: 900px) {

        .reports-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

    }


    @media(max-width: 650px) {

        .reports-stats,
        .report-users-grid,
        .report-actions {
            grid-template-columns: 1fr;
        }

        .reports-search,
        .reports-filter-form select {
            width: 100%;
        }

        .report-card-head {
            align-items: flex-start;
            flex-direction: column;
        }

    }

</style>

@endpush
