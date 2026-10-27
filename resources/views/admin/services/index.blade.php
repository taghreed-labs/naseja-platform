@extends('layouts.admin.admin')

@section('title', 'إدارة الخدمات')
@section('page-title', 'إدارة الخدمات')

@section('content')

<div class="admin-page-heading">

    <div>
        <h1>إدارة الخدمات</h1>

        <p>
            مراجعة الخدمات المنشورة وإدارتها دون تعديل محتوى صاحب الخدمة.
        </p>
    </div>

</div>


{{-- =========================================================
     الرسائل
========================================================= --}}

@if(session('success'))

    <div class="service-alert success">
        <i data-lucide="circle-check"></i>
        {{ session('success') }}
    </div>

@endif


@if(session('error'))

    <div class="service-alert error">
        <i data-lucide="circle-alert"></i>
        {{ session('error') }}
    </div>

@endif



{{-- =========================================================
     الإحصائيات
========================================================= --}}

<div class="service-stats">

    <div class="service-stat-card">

        <div class="service-stat-icon blue">
            <i data-lucide="briefcase-business"></i>
        </div>

        <div>
            <span>إجمالي الخدمات</span>
            <strong>{{ $totalServices }}</strong>
        </div>

    </div>


    <div class="service-stat-card">

        <div class="service-stat-icon green">
            <i data-lucide="circle-check"></i>
        </div>

        <div>
            <span>الخدمات النشطة</span>
            <strong>{{ $activeServices }}</strong>
        </div>

    </div>


    <div class="service-stat-card">

        <div class="service-stat-icon orange">
            <i data-lucide="circle-pause"></i>
        </div>

        <div>
            <span>الخدمات المعطلة</span>
            <strong>{{ $inactiveServices }}</strong>
        </div>

    </div>


    <div class="service-stat-card">

        <div class="service-stat-icon red">
            <i data-lucide="trash-2"></i>
        </div>

        <div>
            <span>المحذوفة</span>
            <strong>{{ $deletedServices }}</strong>
        </div>

    </div>

</div>



<section class="admin-card service-main-card">

    {{-- =====================================================
         البحث والفلترة
    ===================================================== --}}

    <div class="service-toolbar">

        <form
            method="GET"
            action="{{ route('admin.services.index') }}"
            class="service-filter-form"
        >

            <div class="service-search">

                <i data-lucide="search"></i>

                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="ابحث عن خدمة أو صاحبها..."
                >

            </div>


            <select name="category_id">

                <option value="">
                    كل التصنيفات
                </option>

                @foreach($categories as $category)

                    <option
                        value="{{ $category->id }}"
                        {{ (string) $categoryId === (string) $category->id ? 'selected' : '' }}
                    >
                        {{ $category->name_ar }}
                    </option>

                @endforeach

            </select>


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
                class="service-filter-btn"
            >
                <i data-lucide="sliders-horizontal"></i>
                تطبيق
            </button>


            <a
                href="{{ route('admin.services.index') }}"
                class="service-reset-btn"
            >
                <i data-lucide="rotate-ccw"></i>
                إعادة ضبط
            </a>

        </form>

    </div>



    {{-- =====================================================
         الجدول
    ===================================================== --}}

    @if($services->count())

        <div class="service-table-wrapper">

            <table class="service-table">

                <thead>

                    <tr>
                        <th>الخدمة</th>
                        <th>صاحب الخدمة</th>
                        <th>التصنيف</th>
                        <th>السعر</th>
                        <th>المدة</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>

                </thead>


                <tbody>

                    @foreach($services as $service)

                        <tr>

                            <td>

                                <div class="service-title-cell">

                                    <div class="service-row-icon">
                                        <i data-lucide="briefcase-business"></i>
                                    </div>

                                    <div class="service-title-text">

                                        <strong>
                                            {{ $service->title_ar }}
                                        </strong>

                                        <span>
                                            {{ $service->title_en }}
                                        </span>

                                        <small>
                                            ID #{{ $service->id }}
                                        </small>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <div class="service-user-cell">

                                    <div class="service-user-avatar">

                                        @if($service->user?->profile?->avatar)

                                            <img
                                                src="{{ asset('storage/' . $service->user->profile->avatar) }}"
                                                alt="{{ $service->user->name }}"
                                            >

                                        @else

                                            {{ mb_substr($service->user?->name ?? '؟', 0, 1) }}

                                        @endif

                                    </div>

                                    <div>

                                        <strong>
                                            {{ $service->user?->name ?? 'مستخدم غير متاح' }}
                                        </strong>

                                        <span>
                                            {{ $service->user?->email ?? '—' }}
                                        </span>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <span class="service-category-badge">
                                    {{ $service->category?->name_ar ?? '—' }}
                                </span>

                            </td>


                            <td>

                                <div class="service-price">

                                    <strong>
                                        {{ number_format((float) $service->price, 0) }}
                                    </strong>

                                    <span>
                                        ريال
                                    </span>

                                    <small>
                                        {{ $service->price_type }}
                                    </small>

                                </div>

                            </td>


                            <td>
                                {{ $service->duration }}
                            </td>


                            <td>

                                @if($service->trashed())

                                    <span class="service-status deleted">
                                        <span></span>
                                        محذوفة
                                    </span>

                                @elseif($service->status === 'active')

                                    <span class="service-status active">
                                        <span></span>
                                        نشطة
                                    </span>

                                @else

                                    <span class="service-status inactive">
                                        <span></span>
                                        معطلة
                                    </span>

                                @endif

                            </td>


                            <td>

                                <div class="service-actions">

                                    @if($service->trashed())

                                        <form
                                            method="POST"
                                            action="{{ route('admin.services.restore', $service->id) }}"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="service-action restore"
                                                title="استعادة"
                                                onclick="return confirm('هل تريد استعادة هذه الخدمة؟')"
                                            >
                                                <i data-lucide="rotate-ccw"></i>
                                            </button>
                                        </form>

                                    @else

                                        @if($service->status === 'active')

                                            <form
                                                method="POST"
                                                action="{{ route('admin.services.deactivate', $service) }}"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="service-action disable"
                                                    title="تعطيل"
                                                    onclick="return confirm('هل تريد تعطيل هذه الخدمة؟')"
                                                >
                                                    <i data-lucide="circle-pause"></i>
                                                </button>
                                            </form>

                                        @else

                                            <form
                                                method="POST"
                                                action="{{ route('admin.services.activate', $service) }}"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="service-action activate"
                                                    title="تفعيل"
                                                >
                                                    <i data-lucide="circle-check"></i>
                                                </button>
                                            </form>

                                        @endif


                                        <form
                                            method="POST"
                                            action="{{ route('admin.services.destroy', $service) }}"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="service-action delete"
                                                title="حذف"
                                                onclick="return confirm('هل أنت متأكد من حذف هذه الخدمة؟ يمكن استعادتها لاحقًا.')"
                                            >
                                                <i data-lucide="trash-2"></i>
                                            </button>
                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        <div class="service-pagination">
            {{ $services->links() }}
        </div>

    @else

        <div class="service-empty">

            <div class="service-empty-icon">
                <i data-lucide="briefcase-business"></i>
            </div>

            <h2>
                لا توجد خدمات
            </h2>

            <p>
                لا توجد خدمات مطابقة للبحث أو الفلاتر الحالية.
            </p>

        </div>

    @endif

</section>

@endsection



@push('styles')

<style>

    .service-alert {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 12px 15px;
        margin-bottom: 16px;
        border-radius: 14px;
        font-size: 10.5px;
        font-weight: 700;
    }

    .service-alert svg {
        width: 17px;
        height: 17px;
    }

    .service-alert.success {
        background: #eaf8f2;
        border: 1px solid #d5eee4;
        color: #268566;
    }

    .service-alert.error {
        background: #fff0f1;
        border: 1px solid #f2d8db;
        color: #ce5059;
    }


    .service-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 18px;
    }

    .service-stat-card {
        min-height: 88px;
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 17px;
        background: #fff;
        border: 1px solid #e8edf5;
        border-radius: 18px;
    }

    .service-stat-icon {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 14px;
    }

    .service-stat-icon svg {
        width: 20px;
        height: 20px;
    }

    .service-stat-icon.blue {
        background: #edf2ff;
        color: #5874dd;
    }

    .service-stat-icon.green {
        background: #eaf8f2;
        color: #248b68;
    }

    .service-stat-icon.orange {
        background: #fff3e7;
        color: #d88a32;
    }

    .service-stat-icon.red {
        background: #fff0f1;
        color: #d4545e;
    }

    .service-stat-card span {
        display: block;
        margin-bottom: 4px;
        color: #939dac;
        font-size: 9px;
    }

    .service-stat-card strong {
        color: #354055;
        font-size: 21px;
        font-weight: 900;
    }


    .service-main-card {
        overflow: hidden;
    }

    .service-toolbar {
        padding: 18px 20px;
        border-bottom: 1px solid #edf1f6;
    }

    .service-filter-form {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 9px;
    }

    .service-search {
        width: 270px;
        height: 42px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0 12px;
        border: 1px solid #e8edf4;
        border-radius: 12px;
        background: #f8fafe;
    }

    .service-search svg {
        width: 16px;
        height: 16px;
        color: #99a4b4;
    }

    .service-search input {
        width: 100%;
        border: 0;
        outline: 0;
        background: transparent;
        font-size: 10px;
    }

    .service-filter-form select {
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

    .service-filter-btn,
    .service-reset-btn {
        height: 42px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0 13px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 800;
    }

    .service-filter-btn {
        border: 0;
        background: #5b7cff;
        color: #fff;
        cursor: pointer;
    }

    .service-reset-btn {
        border: 1px solid #e7ebf2;
        background: #fff;
        color: #748095;
    }

    .service-filter-btn svg,
    .service-reset-btn svg {
        width: 14px;
        height: 14px;
    }


    .service-table-wrapper {
        overflow-x: auto;
    }

    .service-table {
        width: 100%;
        border-collapse: collapse;
    }

    .service-table th {
        padding: 13px 15px;
        background: #fafbfe;
        color: #929cab;
        text-align: right;
        white-space: nowrap;
        font-size: 9px;
        font-weight: 800;
    }

    .service-table td {
        padding: 14px 15px;
        border-top: 1px solid #f0f3f7;
        color: #657185;
        vertical-align: middle;
        font-size: 9.5px;
    }


    .service-title-cell {
        min-width: 240px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .service-row-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 12px;
        background: linear-gradient(135deg, #edf2ff, #f3efff);
        color: #6274d8;
    }

    .service-row-icon svg {
        width: 17px;
        height: 17px;
    }

    .service-title-text {
        min-width: 0;
    }

    .service-title-text strong {
        display: block;
        max-width: 220px;
        overflow: hidden;
        margin-bottom: 3px;
        color: #354156;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 10.5px;
    }

    .service-title-text span {
        display: block;
        max-width: 220px;
        overflow: hidden;
        color: #8f99a8;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 8.5px;
    }

    .service-title-text small {
        display: block;
        margin-top: 3px;
        color: #adb5c1;
        font-size: 7.5px;
    }


    .service-user-cell {
        min-width: 185px;
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .service-user-avatar {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        border-radius: 10px;
        background: #f1edff;
        color: #735fd1;
        font-weight: 900;
    }

    .service-user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .service-user-cell strong {
        display: block;
        max-width: 150px;
        overflow: hidden;
        color: #404b5e;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 9.5px;
    }

    .service-user-cell span {
        display: block;
        max-width: 150px;
        overflow: hidden;
        margin-top: 2px;
        color: #99a3b2;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 7.8px;
    }


    .service-category-badge {
        display: inline-flex;
        padding: 5px 9px;
        border-radius: 20px;
        background: #f2eeff;
        color: #7560ca;
        white-space: nowrap;
        font-size: 8.5px;
        font-weight: 800;
    }


    .service-price {
        min-width: 90px;
    }

    .service-price strong {
        color: #3f4b5e;
        font-size: 10px;
    }

    .service-price > span {
        margin-right: 2px;
        color: #7b8798;
        font-size: 8px;
    }

    .service-price small {
        display: block;
        margin-top: 3px;
        color: #9ca5b3;
        font-size: 7.5px;
    }


    .service-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 8px;
        border-radius: 20px;
        white-space: nowrap;
        font-size: 8.5px;
        font-weight: 800;
    }

    .service-status > span {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .service-status.active {
        background: #eaf8f2;
        color: #248b68;
    }

    .service-status.inactive {
        background: #fff5e7;
        color: #c8812c;
    }

    .service-status.deleted {
        background: #fff0f1;
        color: #d4545e;
    }


    .service-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .service-actions form {
        margin: 0;
    }

    .service-action {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 9px;
        cursor: pointer;
    }

    .service-action svg {
        width: 14px;
        height: 14px;
    }

    .service-action.activate {
        background: #eaf8f2;
        color: #248b68;
    }

    .service-action.disable {
        background: #fff5e7;
        color: #cc8429;
    }

    .service-action.delete {
        background: #fff0f1;
        color: #d6545d;
    }

    .service-action.restore {
        background: #edf2ff;
        color: #5872d9;
    }


    .service-pagination {
        padding: 16px 20px;
        border-top: 1px solid #edf1f6;
    }


    .service-empty {
        min-height: 300px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .service-empty-icon {
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

    .service-empty-icon svg {
        width: 25px;
        height: 25px;
    }

    .service-empty h2 {
        margin-bottom: 5px;
        font-size: 14px;
    }

    .service-empty p {
        color: #929cab;
        font-size: 9.5px;
    }


    @media(max-width: 1000px) {

        .service-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

    }

    @media(max-width: 650px) {

        .service-stats {
            grid-template-columns: 1fr;
        }

        .service-search {
            width: 100%;
        }

        .service-filter-form select {
            width: 100%;
        }

    }

</style>

@endpush
