@extends('layouts.admin.admin')

@section('title', 'إدارة الأعمال')
@section('page-title', 'إدارة الأعمال')

@section('content')

<div class="admin-page-heading">

    <div>
        <h1>إدارة الأعمال</h1>

        <p>
            مراجعة الأعمال المنشورة والتحكم في ظهورها داخل منصة NASEJA.
        </p>
    </div>

</div>


{{-- =========================================================
     الرسائل
========================================================= --}}

@if(session('success'))

    <div class="portfolio-alert success">
        <i data-lucide="circle-check"></i>
        {{ session('success') }}
    </div>

@endif


@if(session('error'))

    <div class="portfolio-alert error">
        <i data-lucide="circle-alert"></i>
        {{ session('error') }}
    </div>

@endif



{{-- =========================================================
     الإحصائيات
========================================================= --}}

<div class="portfolio-stats">

    <div class="portfolio-stat-card">

        <div class="portfolio-stat-icon blue">
            <i data-lucide="images"></i>
        </div>

        <div>
            <span>إجمالي الأعمال</span>
            <strong>{{ $totalPortfolioItems }}</strong>
        </div>

    </div>


    <div class="portfolio-stat-card">

        <div class="portfolio-stat-icon green">
            <i data-lucide="circle-check"></i>
        </div>

        <div>
            <span>الأعمال النشطة</span>
            <strong>{{ $activePortfolioItems }}</strong>
        </div>

    </div>


    <div class="portfolio-stat-card">

        <div class="portfolio-stat-icon orange">
            <i data-lucide="circle-pause"></i>
        </div>

        <div>
            <span>الأعمال المعطلة</span>
            <strong>{{ $inactivePortfolioItems }}</strong>
        </div>

    </div>


    <div class="portfolio-stat-card">

        <div class="portfolio-stat-icon red">
            <i data-lucide="trash-2"></i>
        </div>

        <div>
            <span>المحذوفة</span>
            <strong>{{ $deletedPortfolioItems }}</strong>
        </div>

    </div>

</div>



<section class="admin-card portfolio-main-card">

    {{-- =====================================================
         البحث والفلترة
    ===================================================== --}}

    <div class="portfolio-toolbar">

        <form
            method="GET"
            action="{{ route('admin.portfolio.index') }}"
            class="portfolio-filter-form"
        >

            <div class="portfolio-search">

                <i data-lucide="search"></i>

                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="ابحث عن عمل أو صاحبه..."
                >

            </div>


            <select name="status">

                <option value="">
                    كل الحالات
                </option>

                <option
                    value="active"
                    {{ $status === 'active' ? 'selected' : '' }}
                >
                    نشطة
                </option>

                <option
                    value="inactive"
                    {{ $status === 'inactive' ? 'selected' : '' }}
                >
                    معطلة
                </option>

                <option
                    value="deleted"
                    {{ $status === 'deleted' ? 'selected' : '' }}
                >
                    محذوفة
                </option>

            </select>


            <button
                type="submit"
                class="portfolio-filter-btn"
            >
                <i data-lucide="sliders-horizontal"></i>
                تطبيق
            </button>


            <a
                href="{{ route('admin.portfolio.index') }}"
                class="portfolio-reset-btn"
            >
                <i data-lucide="rotate-ccw"></i>
                إعادة ضبط
            </a>

        </form>

    </div>



    {{-- =====================================================
         الأعمال
    ===================================================== --}}

    @if($portfolioItems->count())

        <div class="portfolio-grid">

            @foreach($portfolioItems as $portfolioItem)

                @php
                    $firstImage =
                        $portfolioItem->images->first();
                @endphp


                <article class="portfolio-card">


                    {{-- الصورة --}}

                    <div class="portfolio-image">

                        @if($firstImage && $firstImage->file_path)

                            <img
                                src="{{ asset('storage/' . $firstImage->file_path) }}"
                                alt="{{ $portfolioItem->title_ar }}"
                            >

                        @else

                            <div class="portfolio-image-placeholder">
                                <i data-lucide="image"></i>
                            </div>

                        @endif


                        <div class="portfolio-card-status">

                            @if($portfolioItem->trashed())

                                <span class="portfolio-status deleted">
                                    محذوف
                                </span>

                            @elseif($portfolioItem->status === 'active')

                                <span class="portfolio-status active">
                                    نشط
                                </span>

                            @else

                                <span class="portfolio-status inactive">
                                    معطل
                                </span>

                            @endif

                        </div>

                    </div>



                    {{-- البيانات --}}

                    <div class="portfolio-card-body">

                        <div class="portfolio-title-wrap">

                            <div>

                                <h2>
                                    {{ $portfolioItem->title_ar }}
                                </h2>

                                <span>
                                    {{ $portfolioItem->title_en }}
                                </span>

                            </div>

                            <small>
                                #{{ $portfolioItem->id }}
                            </small>

                        </div>


                        @if(
                            $portfolioItem->description_ar ||
                            $portfolioItem->description_en
                        )

                            <p class="portfolio-description">

                                {{
                                    $portfolioItem->description_ar
                                    ?? $portfolioItem->description_en
                                }}

                            </p>

                        @else

                            <p class="portfolio-description muted">
                                لا يوجد وصف مضاف لهذا العمل.
                            </p>

                        @endif



                        {{-- صاحب العمل --}}

                        <div class="portfolio-owner">

                            <div class="portfolio-owner-avatar">
                                {{
                                    mb_substr(
                                        $portfolioItem->user?->name ?? '؟',
                                        0,
                                        1
                                    )
                                }}
                            </div>

                            <div>

                                <strong>
                                    {{
                                        $portfolioItem->user?->name
                                        ?? 'مستخدم غير متاح'
                                    }}
                                </strong>

                                <span>
                                    {{
                                        $portfolioItem->user?->email
                                        ?? '—'
                                    }}
                                </span>

                            </div>

                        </div>



                        {{-- معلومات إضافية --}}

                        <div class="portfolio-meta">

                            <div>

                                <i data-lucide="calendar-days"></i>

                                <span>
                                    {{
                                        $portfolioItem->work_date
                                            ? $portfolioItem->work_date->format('Y/m/d')
                                            : 'بدون تاريخ'
                                    }}
                                </span>

                            </div>


                            <div>

                                <i data-lucide="images"></i>

                                <span>
                                    {{ $portfolioItem->images->count() }}
                                    صورة
                                </span>

                            </div>


                            <div>

                                <i data-lucide="badge-check"></i>

                                <span>
                                    {{ $portfolioItem->verified_works_count }}
                                    تحقق
                                </span>

                            </div>

                        </div>

                    </div>



                    {{-- الإجراءات --}}

                    <div class="portfolio-card-actions">

                        @if($portfolioItem->trashed())

                            <form
                                method="POST"
                                action="{{ route('admin.portfolio.restore', $portfolioItem->id) }}"
                            >

                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="portfolio-action restore"
                                    onclick="return confirm('هل تريد استعادة هذا العمل؟')"
                                >
                                    <i data-lucide="rotate-ccw"></i>
                                    استعادة
                                </button>

                            </form>

                        @else

                            @if($portfolioItem->status === 'active')

                                <form
                                    method="POST"
                                    action="{{ route('admin.portfolio.deactivate', $portfolioItem) }}"
                                >

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="portfolio-action disable"
                                        onclick="return confirm('هل تريد تعطيل ظهور هذا العمل؟')"
                                    >
                                        <i data-lucide="circle-pause"></i>
                                        تعطيل
                                    </button>

                                </form>

                            @else

                                <form
                                    method="POST"
                                    action="{{ route('admin.portfolio.activate', $portfolioItem) }}"
                                >

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="portfolio-action activate"
                                    >
                                        <i data-lucide="circle-check"></i>
                                        تفعيل
                                    </button>

                                </form>

                            @endif


                            <form
                                method="POST"
                                action="{{ route('admin.portfolio.destroy', $portfolioItem) }}"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="portfolio-action delete"
                                    onclick="return confirm('هل أنت متأكد من حذف هذا العمل؟ يمكن استعادته لاحقًا.')"
                                >
                                    <i data-lucide="trash-2"></i>
                                    حذف
                                </button>

                            </form>

                        @endif

                    </div>

                </article>

            @endforeach

        </div>


        <div class="portfolio-pagination">
            {{ $portfolioItems->links() }}
        </div>

    @else

        <div class="portfolio-empty">

            <div class="portfolio-empty-icon">
                <i data-lucide="images"></i>
            </div>

            <h2>
                لا توجد أعمال
            </h2>

            <p>
                لا توجد أعمال مطابقة للبحث أو الفلتر الحالي.
            </p>

        </div>

    @endif

</section>

@endsection



@push('styles')

<style>

    .portfolio-alert {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 12px 15px;
        margin-bottom: 16px;
        border-radius: 14px;
        font-size: 10.5px;
        font-weight: 700;
    }

    .portfolio-alert svg {
        width: 17px;
        height: 17px;
    }

    .portfolio-alert.success {
        background: #eaf8f2;
        border: 1px solid #d5eee4;
        color: #268566;
    }

    .portfolio-alert.error {
        background: #fff0f1;
        border: 1px solid #f2d8db;
        color: #ce5059;
    }


    .portfolio-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 18px;
    }

    .portfolio-stat-card {
        min-height: 88px;
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 17px;
        background: #fff;
        border: 1px solid #e8edf5;
        border-radius: 18px;
    }

    .portfolio-stat-icon {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 14px;
    }

    .portfolio-stat-icon svg {
        width: 20px;
        height: 20px;
    }

    .portfolio-stat-icon.blue {
        background: #edf2ff;
        color: #5874dd;
    }

    .portfolio-stat-icon.green {
        background: #eaf8f2;
        color: #248b68;
    }

    .portfolio-stat-icon.orange {
        background: #fff3e7;
        color: #d88a32;
    }

    .portfolio-stat-icon.red {
        background: #fff0f1;
        color: #d4545e;
    }

    .portfolio-stat-card span {
        display: block;
        margin-bottom: 4px;
        color: #939dac;
        font-size: 9px;
    }

    .portfolio-stat-card strong {
        color: #354055;
        font-size: 21px;
        font-weight: 900;
    }


    .portfolio-main-card {
        overflow: hidden;
    }

    .portfolio-toolbar {
        padding: 18px 20px;
        border-bottom: 1px solid #edf1f6;
    }

    .portfolio-filter-form {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 9px;
    }

    .portfolio-search {
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

    .portfolio-search svg {
        width: 16px;
        height: 16px;
        color: #99a4b4;
    }

    .portfolio-search input {
        width: 100%;
        border: 0;
        outline: 0;
        background: transparent;
        font-size: 10px;
    }

    .portfolio-filter-form select {
        min-width: 145px;
        height: 42px;
        padding: 0 10px;
        border: 1px solid #e8edf4;
        border-radius: 12px;
        background: #fff;
        color: #657185;
        outline: 0;
        font-size: 10px;
    }

    .portfolio-filter-btn,
    .portfolio-reset-btn {
        height: 42px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0 13px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 800;
    }

    .portfolio-filter-btn {
        border: 0;
        background: #5b7cff;
        color: #fff;
        cursor: pointer;
    }

    .portfolio-reset-btn {
        border: 1px solid #e7ebf2;
        background: #fff;
        color: #748095;
    }

    .portfolio-filter-btn svg,
    .portfolio-reset-btn svg {
        width: 14px;
        height: 14px;
    }


    .portfolio-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        padding: 18px;
    }

    .portfolio-card {
        overflow: hidden;
        display: flex;
        flex-direction: column;
        border: 1px solid #e8edf5;
        border-radius: 18px;
        background: #fff;
        transition: .2s ease;
    }

    .portfolio-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 13px 30px rgba(47, 60, 91, .07);
    }

    .portfolio-image {
        position: relative;
        height: 175px;
        overflow: hidden;
        background: #f3f5f9;
    }

    .portfolio-image > img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .portfolio-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f3f5fa, #efedff);
        color: #a3a9bd;
    }

    .portfolio-image-placeholder svg {
        width: 30px;
        height: 30px;
    }

    .portfolio-card-status {
        position: absolute;
        top: 11px;
        right: 11px;
    }

    .portfolio-status {
        display: inline-flex;
        padding: 5px 9px;
        border-radius: 20px;
        backdrop-filter: blur(8px);
        font-size: 8px;
        font-weight: 900;
    }

    .portfolio-status.active {
        background: rgba(233, 249, 242, .94);
        color: #248b68;
    }

    .portfolio-status.inactive {
        background: rgba(255, 245, 231, .95);
        color: #c8812c;
    }

    .portfolio-status.deleted {
        background: rgba(255, 239, 241, .95);
        color: #d4545e;
    }


    .portfolio-card-body {
        flex: 1;
        padding: 15px;
    }

    .portfolio-title-wrap {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 9px;
    }

    .portfolio-title-wrap h2 {
        margin: 0;
        color: #364156;
        font-size: 11.5px;
        font-weight: 900;
        line-height: 1.6;
    }

    .portfolio-title-wrap span {
        display: block;
        margin-top: 2px;
        color: #919baa;
        font-size: 8px;
    }

    .portfolio-title-wrap small {
        flex-shrink: 0;
        color: #adb5c1;
        font-size: 7.5px;
    }

    .portfolio-description {
        display: -webkit-box;
        overflow: hidden;
        min-height: 43px;
        margin: 10px 0 13px;
        color: #737f92;
        font-size: 8.7px;
        line-height: 1.8;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .portfolio-description.muted {
        color: #a0a8b5;
    }


    .portfolio-owner {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px;
        border: 1px solid #edf0f5;
        border-radius: 12px;
        background: #fafbfe;
    }

    .portfolio-owner-avatar {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 10px;
        background: linear-gradient(135deg, #edf2ff, #f3efff);
        color: #6174d8;
        font-weight: 900;
    }

    .portfolio-owner strong {
        display: block;
        color: #434e62;
        font-size: 9px;
        font-weight: 900;
    }

    .portfolio-owner span {
        display: block;
        max-width: 180px;
        overflow: hidden;
        margin-top: 2px;
        color: #99a3b1;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 7.5px;
    }


    .portfolio-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;
        margin-top: 12px;
    }

    .portfolio-meta > div {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 7px;
        border-radius: 8px;
        background: #f5f7fa;
        color: #7d889a;
        font-size: 7.5px;
    }

    .portfolio-meta svg {
        width: 11px;
        height: 11px;
    }


    .portfolio-card-actions {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 12px 15px;
        border-top: 1px solid #edf1f6;
        background: #fbfcfe;
    }

    .portfolio-card-actions form {
        flex: 1;
        margin: 0;
    }

    .portfolio-action {
        width: 100%;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        border: 0;
        border-radius: 10px;
        cursor: pointer;
        font-size: 8.5px;
        font-weight: 900;
    }

    .portfolio-action svg {
        width: 13px;
        height: 13px;
    }

    .portfolio-action.activate {
        background: #eaf8f2;
        color: #248b68;
    }

    .portfolio-action.disable {
        background: #fff5e7;
        color: #c8812c;
    }

    .portfolio-action.delete {
        background: #fff0f1;
        color: #d4545e;
    }

    .portfolio-action.restore {
        background: #edf2ff;
        color: #5872d9;
    }


    .portfolio-pagination {
        padding: 16px 20px;
        border-top: 1px solid #edf1f6;
    }


    .portfolio-empty {
        min-height: 300px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .portfolio-empty-icon {
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

    .portfolio-empty-icon svg {
        width: 25px;
        height: 25px;
    }

    .portfolio-empty h2 {
        margin-bottom: 5px;
        color: #3e495d;
        font-size: 14px;
    }

    .portfolio-empty p {
        color: #929cab;
        font-size: 9.5px;
    }


    @media(max-width: 1100px) {

        .portfolio-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

    }

    @media(max-width: 900px) {

        .portfolio-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

    }

    @media(max-width: 650px) {

        .portfolio-stats,
        .portfolio-grid {
            grid-template-columns: 1fr;
        }

        .portfolio-search {
            width: 100%;
        }

        .portfolio-filter-form select {
            width: 100%;
        }

    }

</style>

@endpush
