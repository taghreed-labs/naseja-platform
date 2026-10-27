@extends('layouts.admin.admin')

@section('title', 'البحث')
@section('page-title', 'البحث')

@section('content')

<div class="admin-page-heading">

    <div>
        <h1>البحث الشامل</h1>
        <p>
            ابحث في المستخدمين والتصنيفات والمهارات والخدمات والأعمال والبلاغات.
        </p>
    </div>

</div>


<section class="admin-card admin-search-page-card">

    <form
        method="GET"
        action="{{ route('admin.search.index') }}"
        class="admin-search-page-form"
    >

        <div class="admin-search-page-input">

            <i data-lucide="search"></i>

            <input
                type="search"
                name="q"
                value="{{ $q }}"
                placeholder="اكتب اسم مستخدم، مهارة، خدمة، عمل، بلاغ..."
                autofocus
                autocomplete="off"
            >

        </div>

        <button type="submit">
            بحث
        </button>

    </form>

</section>


@if($q !== '')

    <div class="admin-search-summary">

        <span>
            نتائج البحث عن
            <strong>“{{ $q }}”</strong>
        </span>

        <span class="admin-search-count">
            {{ $resultsCount }} نتيجة
        </span>

    </div>


    @if($resultsCount > 0)

        <div class="admin-search-results-grid">


            {{-- =====================================================
                 المستخدمون
            ====================================================== --}}

            @if($users->isNotEmpty())

                <section class="admin-card search-result-section">

                    <div class="search-result-heading">

                        <div class="search-result-heading-title">
                            <span class="search-section-icon users">
                                <i data-lucide="users"></i>
                            </span>

                            <div>
                                <h2>المستخدمون</h2>
                                <small>{{ $users->count() }} نتيجة</small>
                            </div>
                        </div>

                        <a
                            href="{{ route('admin.users.index', ['search' => $q]) }}"
                        >
                            عرض الكل
                            <i data-lucide="chevron-left"></i>
                        </a>

                    </div>


                    <div class="search-items">

                        @foreach($users as $user)

                            <a
                                href="{{ route('admin.users.index', ['search' => $user->email]) }}"
                                class="search-item"
                            >

                                <span class="search-item-avatar">
                                    {{ mb_substr($user->name, 0, 1) }}
                                </span>

                                <span class="search-item-copy">

                                    <strong>
                                        {{ $user->name }}
                                    </strong>

                                    <small>
                                        {{ $user->email }}
                                    </small>

                                </span>

                                <span class="search-item-status">
                                    {{ $user->status }}
                                </span>

                            </a>

                        @endforeach

                    </div>

                </section>

            @endif



            {{-- =====================================================
                 التصنيفات
            ====================================================== --}}

            @if($categories->isNotEmpty())

                <section class="admin-card search-result-section">

                    <div class="search-result-heading">

                        <div class="search-result-heading-title">
                            <span class="search-section-icon category">
                                <i data-lucide="layers-3"></i>
                            </span>

                            <div>
                                <h2>التصنيفات</h2>
                                <small>{{ $categories->count() }} نتيجة</small>
                            </div>
                        </div>

                        <a
                            href="{{ route('admin.categories.index', ['search' => $q]) }}"
                        >
                            عرض الكل
                            <i data-lucide="chevron-left"></i>
                        </a>

                    </div>


                    <div class="search-items">

                        @foreach($categories as $category)

                            <a
                                href="{{ route('admin.categories.index', ['search' => $category->name_ar]) }}"
                                class="search-item"
                            >

                                <span class="search-item-symbol">
                                    <i data-lucide="folder"></i>
                                </span>

                                <span class="search-item-copy">

                                    <strong>
                                        {{ $category->name_ar }}
                                    </strong>

                                    <small>
                                        {{ $category->name_en ?: $category->slug }}
                                    </small>

                                </span>

                                <span class="search-item-status">
                                    {{ $category->status }}
                                </span>

                            </a>

                        @endforeach

                    </div>

                </section>

            @endif



            {{-- =====================================================
                 المهارات
            ====================================================== --}}

            @if($skills->isNotEmpty())

                <section class="admin-card search-result-section">

                    <div class="search-result-heading">

                        <div class="search-result-heading-title">
                            <span class="search-section-icon skill">
                                <i data-lucide="sparkles"></i>
                            </span>

                            <div>
                                <h2>المهارات</h2>
                                <small>{{ $skills->count() }} نتيجة</small>
                            </div>
                        </div>

                        <a
                            href="{{ route('admin.skills.index', ['search' => $q]) }}"
                        >
                            عرض الكل
                            <i data-lucide="chevron-left"></i>
                        </a>

                    </div>


                    <div class="search-items">

                        @foreach($skills as $skill)

                            <a
                                href="{{ route('admin.skills.index', ['search' => $skill->name_ar]) }}"
                                class="search-item"
                            >

                                <span class="search-item-symbol">
                                    <i data-lucide="wand-sparkles"></i>
                                </span>

                                <span class="search-item-copy">

                                    <strong>
                                        {{ $skill->name_ar }}
                                    </strong>

                                    <small>
                                        {{ $skill->category?->name_ar ?? 'بدون تصنيف' }}
                                    </small>

                                </span>

                                <span class="search-item-status">
                                    {{ $skill->status }}
                                </span>

                            </a>

                        @endforeach

                    </div>

                </section>

            @endif



            {{-- =====================================================
                 الخدمات
            ====================================================== --}}

            @if($services->isNotEmpty())

                <section class="admin-card search-result-section">

                    <div class="search-result-heading">

                        <div class="search-result-heading-title">
                            <span class="search-section-icon service">
                                <i data-lucide="briefcase-business"></i>
                            </span>

                            <div>
                                <h2>الخدمات</h2>
                                <small>{{ $services->count() }} نتيجة</small>
                            </div>
                        </div>

                        <a
                            href="{{ route('admin.services.index', ['search' => $q]) }}"
                        >
                            عرض الكل
                            <i data-lucide="chevron-left"></i>
                        </a>

                    </div>


                    <div class="search-items">

                        @foreach($services as $service)

                            <a
                                href="{{ route('admin.services.index', ['search' => $service->title_ar]) }}"
                                class="search-item"
                            >

                                <span class="search-item-symbol">
                                    <i data-lucide="briefcase"></i>
                                </span>

                                <span class="search-item-copy">

                                    <strong>
                                        {{ $service->title_ar }}
                                    </strong>

                                    <small>
                                        {{ $service->user?->name ?? 'مستخدم غير متاح' }}
                                    </small>

                                </span>

                                <span class="search-item-status">
                                    {{ $service->status }}
                                </span>

                            </a>

                        @endforeach

                    </div>

                </section>

            @endif



            {{-- =====================================================
                 الأعمال
            ====================================================== --}}

            @if($portfolioItems->isNotEmpty())

                <section class="admin-card search-result-section">

                    <div class="search-result-heading">

                        <div class="search-result-heading-title">
                            <span class="search-section-icon portfolio">
                                <i data-lucide="images"></i>
                            </span>

                            <div>
                                <h2>الأعمال</h2>
                                <small>{{ $portfolioItems->count() }} نتيجة</small>
                            </div>
                        </div>

                        <a
                            href="{{ route('admin.portfolio.index', ['search' => $q]) }}"
                        >
                            عرض الكل
                            <i data-lucide="chevron-left"></i>
                        </a>

                    </div>


                    <div class="search-items">

                        @foreach($portfolioItems as $portfolioItem)

                            <a
                                href="{{ route('admin.portfolio.index', ['search' => $portfolioItem->title_ar]) }}"
                                class="search-item"
                            >

                                <span class="search-item-symbol">
                                    <i data-lucide="image"></i>
                                </span>

                                <span class="search-item-copy">

                                    <strong>
                                        {{ $portfolioItem->title_ar }}
                                    </strong>

                                    <small>
                                        {{ $portfolioItem->user?->name ?? 'مستخدم غير متاح' }}
                                    </small>

                                </span>

                                <span class="search-item-status">
                                    {{ $portfolioItem->status }}
                                </span>

                            </a>

                        @endforeach

                    </div>

                </section>

            @endif



            {{-- =====================================================
                 البلاغات
            ====================================================== --}}

            @if($reports->isNotEmpty())

                <section class="admin-card search-result-section">

                    <div class="search-result-heading">

                        <div class="search-result-heading-title">
                            <span class="search-section-icon report">
                                <i data-lucide="triangle-alert"></i>
                            </span>

                            <div>
                                <h2>البلاغات</h2>
                                <small>{{ $reports->count() }} نتيجة</small>
                            </div>
                        </div>

                        <a
                            href="{{ route('admin.reports.index', ['search' => $q]) }}"
                        >
                            عرض الكل
                            <i data-lucide="chevron-left"></i>
                        </a>

                    </div>


                    <div class="search-items">

                        @foreach($reports as $report)

                            <a
                                href="{{ route('admin.reports.index', ['search' => $report->reason]) }}"
                                class="search-item"
                            >

                                <span class="search-item-symbol">
                                    <i data-lucide="message-square-warning"></i>
                                </span>

                                <span class="search-item-copy">

                                    <strong>
                                        بلاغ #{{ $report->id }} — {{ $report->type }}
                                    </strong>

                                    <small>
                                        {{ \Illuminate\Support\Str::limit($report->reason, 70) }}
                                    </small>

                                </span>

                                <span class="search-item-status">
                                    {{ $report->status }}
                                </span>

                            </a>

                        @endforeach

                    </div>

                </section>

            @endif


        </div>

    @else

        <section class="admin-card admin-search-empty">

            <div class="admin-search-empty-icon">
                <i data-lucide="search-x"></i>
            </div>

            <h2>
                لا توجد نتائج
            </h2>

            <p>
                جرّب كلمة أخرى أو ابحث باسم المستخدم أو الخدمة أو المهارة.
            </p>

        </section>

    @endif


@else

    <section class="admin-card admin-search-empty">

        <div class="admin-search-empty-icon">
            <i data-lucide="search"></i>
        </div>

        <h2>
            ابدأ البحث
        </h2>

        <p>
            اكتب كلمة في مربع البحث للوصول بسرعة إلى محتوى لوحة الإدارة.
        </p>

    </section>

@endif

@endsection


@push('styles')

<style>

    .admin-search-page-card {
        padding: 17px;
        margin-bottom: 16px;
    }

    .admin-search-page-form {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .admin-search-page-input {
        min-height: 45px;
        flex: 1;
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 0 13px;
        border: 1px solid #e5eaf1;
        border-radius: 13px;
        background: #f8fafe;
    }

    .admin-search-page-input:focus-within {
        border-color: #b8c5f7;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(91,124,255,.07);
    }

    .admin-search-page-input svg {
        width: 17px;
        height: 17px;
        color: #97a2b2;
    }

    .admin-search-page-input input {
        width: 100%;
        border: 0;
        outline: 0;
        background: transparent;
        color: #465268;
        font-family: inherit;
        font-size: 10.5px;
    }

    .admin-search-page-form button {
        min-height: 45px;
        padding: 0 22px;
        border: 0;
        border-radius: 13px;
        background: #5b7cff;
        color: #fff;
        cursor: pointer;
        font-family: inherit;
        font-size: 10px;
        font-weight: 900;
    }


    .admin-search-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin: 4px 2px 14px;
        color: #7e899b;
        font-size: 9.5px;
    }

    .admin-search-summary strong {
        color: #455269;
    }

    .admin-search-count {
        padding: 5px 9px;
        border-radius: 20px;
        background: #eef2ff;
        color: #6175d1;
        font-weight: 900;
    }


    .admin-search-results-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .search-result-section {
        overflow: hidden;
    }

    .search-result-heading {
        min-height: 68px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 13px 15px;
        border-bottom: 1px solid #edf1f6;
    }

    .search-result-heading-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .search-section-icon {
        width: 38px;
        height: 38px;
        display: grid;
        place-items: center;
        border-radius: 12px;
    }

    .search-section-icon svg {
        width: 17px;
        height: 17px;
    }

    .search-section-icon.users {
        background: #edf2ff;
        color: #5c74dc;
    }

    .search-section-icon.category {
        background: #f1edff;
        color: #7560ca;
    }

    .search-section-icon.skill {
        background: #fff2e7;
        color: #cf8244;
    }

    .search-section-icon.service {
        background: #eaf8f2;
        color: #288767;
    }

    .search-section-icon.portfolio {
        background: #fff0f4;
        color: #ce617a;
    }

    .search-section-icon.report {
        background: #fff1ec;
        color: #d46c50;
    }

    .search-result-heading h2 {
        margin: 0;
        color: #3f4b60;
        font-size: 11px;
        font-weight: 900;
    }

    .search-result-heading small {
        display: block;
        margin-top: 2px;
        color: #9aa4b4;
        font-size: 7.5px;
    }

    .search-result-heading > a {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        color: #6477cf;
        font-size: 8px;
        font-weight: 800;
    }

    .search-result-heading > a svg {
        width: 12px;
        height: 12px;
    }


    .search-items {
        padding: 7px;
    }

    .search-item {
        min-height: 58px;
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 8px 9px;
        border-radius: 11px;
        transition: .16s ease;
    }

    .search-item:hover {
        background: #f8f9fd;
    }

    .search-item-avatar,
    .search-item-symbol {
        width: 34px;
        height: 34px;
        display: grid;
        place-items: center;
        flex: 0 0 34px;
        border-radius: 10px;
        background: #f0f3fb;
        color: #6375c9;
        font-size: 10px;
        font-weight: 900;
    }

    .search-item-symbol svg {
        width: 15px;
        height: 15px;
    }

    .search-item-copy {
        min-width: 0;
        flex: 1;
    }

    .search-item-copy strong {
        display: block;
        overflow: hidden;
        color: #485469;
        font-size: 9px;
        font-weight: 900;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .search-item-copy small {
        display: block;
        overflow: hidden;
        margin-top: 3px;
        color: #98a2b2;
        font-size: 7.5px;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .search-item-status {
        flex-shrink: 0;
        padding: 4px 7px;
        border-radius: 20px;
        background: #f1f3f7;
        color: #778294;
        font-size: 7px;
        font-weight: 900;
    }


    .admin-search-empty {
        min-height: 290px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 24px;
        text-align: center;
    }

    .admin-search-empty-icon {
        width: 64px;
        height: 64px;
        display: grid;
        place-items: center;
        margin-bottom: 12px;
        border-radius: 20px;
        background: linear-gradient(135deg,#edf2ff,#f3efff);
        color: #6275d4;
    }

    .admin-search-empty-icon svg {
        width: 25px;
        height: 25px;
    }

    .admin-search-empty h2 {
        margin: 0 0 5px;
        color: #414d61;
        font-size: 13px;
    }

    .admin-search-empty p {
        margin: 0;
        color: #929dad;
        font-size: 9px;
    }


    @media(max-width: 850px) {

        .admin-search-results-grid {
            grid-template-columns: 1fr;
        }

    }


    @media(max-width: 550px) {

        .admin-search-page-form {
            align-items: stretch;
            flex-direction: column;
        }

        .admin-search-page-form button {
            width: 100%;
        }

    }

</style>

@endpush
