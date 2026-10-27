@extends('layouts.admin.admin')

@section('title', 'إدارة التصنيفات')
@section('page-title', 'إدارة التصنيفات')


@section('content')


{{-- ============================================================
     HEADER
============================================================ --}}

<div class="admin-page-heading">

    <div>

        <h1>
            إدارة التصنيفات
        </h1>

        <p>
            إدارة المجالات الرئيسية التي تظهر للمستخدمين داخل منصة NASEJA.
        </p>

    </div>


    <button
        type="button"
        class="category-add-button"
        onclick="openAddCategoryModal()"
    >

        <i data-lucide="plus"></i>

        إضافة تصنيف

    </button>

</div>



{{-- ============================================================
     MESSAGES
============================================================ --}}

@if(session('success'))

    <div class="category-alert success">

        <i data-lucide="circle-check"></i>

        <span>
            {{ session('success') }}
        </span>

    </div>

@endif


@if(session('error'))

    <div class="category-alert error">

        <i data-lucide="circle-alert"></i>

        <span>
            {{ session('error') }}
        </span>

    </div>

@endif


@if($errors->any())

    <div class="category-alert error">

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



{{-- ============================================================
     STATS
============================================================ --}}

<div class="category-stats">


    <article class="category-stat">

        <div class="category-stat-icon all">

            <i data-lucide="layout-grid"></i>

        </div>


        <div>

            <span>
                إجمالي التصنيفات
            </span>

            <strong>
                {{ $totalCategories }}
            </strong>

        </div>

    </article>



    <article class="category-stat">

        <div class="category-stat-icon active">

            <i data-lucide="circle-check"></i>

        </div>


        <div>

            <span>
                التصنيفات النشطة
            </span>

            <strong>
                {{ $activeCategories }}
            </strong>

        </div>

    </article>



    <article class="category-stat">

        <div class="category-stat-icon inactive">

            <i data-lucide="circle-pause"></i>

        </div>


        <div>

            <span>
                التصنيفات المعطلة
            </span>

            <strong>
                {{ $inactiveCategories }}
            </strong>

        </div>

    </article>


</div>



{{-- ============================================================
     MAIN CARD
============================================================ --}}

<section class="admin-card category-card">


    {{-- ========================================================
         FILTER
    ========================================================= --}}

    <div class="category-toolbar">


        <form
            method="GET"
            action="{{ route('admin.categories.index') }}"
            class="category-filter-form"
        >


            <div class="category-search">

                <i data-lucide="search"></i>

                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="ابحث عن تصنيف..."
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
                    نشط
                </option>


                <option
                    value="inactive"
                    {{ $status === 'inactive' ? 'selected' : '' }}
                >
                    معطل
                </option>

            </select>


            <button
                type="submit"
                class="category-filter-button"
            >

                <i data-lucide="sliders-horizontal"></i>

                تطبيق

            </button>


            <a
                href="{{ route('admin.categories.index') }}"
                class="category-reset-button"
            >

                <i data-lucide="rotate-ccw"></i>

                إعادة ضبط

            </a>

        </form>

    </div>



    {{-- ========================================================
         TABLE
    ========================================================= --}}

    @if($categories->count())


        <div class="category-table-wrapper">


            <table class="category-table">


                <thead>

                    <tr>

                        <th>
                            التصنيف
                        </th>

                        <th>
                            الاسم الإنجليزي
                        </th>

                        <th>
                            Slug
                        </th>

                        <th>
                            الترتيب
                        </th>

                        <th>
                            الحالة
                        </th>

                        <th>
                            الإجراءات
                        </th>

                    </tr>

                </thead>


                <tbody>


                    @foreach($categories as $category)

                        <tr>


                            {{-- التصنيف --}}

                            <td>

                                <div class="category-name-cell">

                                    <div class="category-icon">

                                        <i data-lucide="folder"></i>

                                    </div>


                                    <div>

                                        <strong>
                                            {{ $category->name_ar }}
                                        </strong>

                                        <span>
                                            ID #{{ $category->id }}
                                        </span>

                                    </div>

                                </div>

                            </td>



                            {{-- English --}}

                            <td>

                                <span class="category-muted">

                                    {{ $category->name_en ?: '—' }}

                                </span>

                            </td>



                            {{-- Slug --}}

                            <td>

                                <span class="category-slug">

                                    {{ $category->slug }}

                                </span>

                            </td>



                            {{-- Sort Order --}}

                            <td>

                                <span class="category-order">

                                    {{ $category->sort_order ?? 0 }}

                                </span>

                            </td>



                            {{-- Status --}}

                            <td>


                                @if($category->status === 'active')

                                    <span class="category-status active">

                                        <span></span>

                                        نشط

                                    </span>

                                @else

                                    <span class="category-status inactive">

                                        <span></span>

                                        معطل

                                    </span>

                                @endif


                            </td>



                            {{-- Actions --}}

                            <td>


                                <div class="category-actions">


                                    {{-- EDIT --}}

                                    <button
                                        type="button"
                                        class="category-action edit"
                                        title="تعديل"
                                        data-id="{{ $category->id }}"
                                        data-name-ar="{{ $category->name_ar }}"
                                        data-name-en="{{ $category->name_en }}"
                                        data-slug="{{ $category->slug }}"
                                        data-sort-order="{{ $category->sort_order ?? 0 }}"
                                        data-status="{{ $category->status }}"
                                        data-update-url="{{ route('admin.categories.update', $category) }}"
                                        onclick="openEditCategoryModal(this)"
                                    >

                                        <i data-lucide="pencil"></i>

                                    </button>



                                    {{-- STATUS --}}

                                    @if($category->status === 'active')


                                        <form
                                            method="POST"
                                            action="{{ route('admin.categories.deactivate', $category) }}"
                                        >

                                            @csrf
                                            @method('PATCH')


                                            <button
                                                type="submit"
                                                class="category-action disable"
                                                title="تعطيل"
                                                onclick="return confirm('هل تريد تعطيل هذا التصنيف؟')"
                                            >

                                                <i data-lucide="circle-pause"></i>

                                            </button>

                                        </form>


                                    @else


                                        <form
                                            method="POST"
                                            action="{{ route('admin.categories.activate', $category) }}"
                                        >

                                            @csrf
                                            @method('PATCH')


                                            <button
                                                type="submit"
                                                class="category-action activate"
                                                title="تفعيل"
                                            >

                                                <i data-lucide="circle-check"></i>

                                            </button>

                                        </form>


                                    @endif



                                    {{-- DELETE --}}

                                    <form
                                        method="POST"
                                        action="{{ route('admin.categories.destroy', $category) }}"
                                    >

                                        @csrf
                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="category-action delete"
                                            title="حذف"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا التصنيف؟')"
                                        >

                                            <i data-lucide="trash-2"></i>

                                        </button>

                                    </form>


                                </div>


                            </td>


                        </tr>


                    @endforeach


                </tbody>


            </table>


        </div>



        {{-- ====================================================
             PAGINATION
        ===================================================== --}}

        <div class="category-pagination">

            {{ $categories->links() }}

        </div>


    @else


        {{-- ====================================================
             EMPTY STATE
        ===================================================== --}}

        <div class="category-empty">


            <div class="category-empty-icon">

                <i data-lucide="layout-grid"></i>

            </div>


            <h2>
                لا توجد تصنيفات
            </h2>


            <p>
                لا توجد نتائج مطابقة حاليًا.
            </p>


            <button
                type="button"
                onclick="openAddCategoryModal()"
            >

                <i data-lucide="plus"></i>

                إضافة أول تصنيف

            </button>


        </div>


    @endif


</section>



{{-- ============================================================
     ADD CATEGORY MODAL
============================================================ --}}

<div
    class="category-modal"
    id="addCategoryModal"
>


    <div class="category-modal-backdrop"
         onclick="closeAddCategoryModal()">
    </div>


    <div class="category-modal-box">


        <div class="category-modal-header">

            <div>

                <h2>
                    إضافة تصنيف جديد
                </h2>

                <p>
                    أضيفي مجالًا جديدًا لمنصة NASEJA.
                </p>

            </div>


            <button
                type="button"
                class="category-modal-close"
                onclick="closeAddCategoryModal()"
            >

                <i data-lucide="x"></i>

            </button>

        </div>



        <form
            method="POST"
            action="{{ route('admin.categories.store') }}"
        >

            @csrf


            <div class="category-form-body">


                <div class="category-field full">

                    <label>
                        اسم التصنيف بالعربية
                        <span>*</span>
                    </label>


                    <input
                        type="text"
                        name="name_ar"
                        value="{{ old('name_ar') }}"
                        placeholder="مثال: الخياطة والتفصيل"
                        required
                    >

                </div>



                <div class="category-field full">

                    <label>
                        اسم التصنيف بالإنجليزية
                    </label>


                    <input
                        type="text"
                        name="name_en"
                        value="{{ old('name_en') }}"
                        placeholder="Example: Sewing & Tailoring"
                    >

                </div>



                <div class="category-field full">

                    <label>
                        Slug
                    </label>


                    <input
                        type="text"
                        name="slug"
                        value="{{ old('slug') }}"
                        placeholder="sewing-tailoring"
                        dir="ltr"
                    >


                    <small>
                        يمكن تركه فارغًا وسيتم إنشاؤه تلقائيًا.
                    </small>

                </div>



                <div class="category-form-grid">


                    <div class="category-field">

                        <label>
                            الترتيب
                        </label>


                        <input
                            type="number"
                            name="sort_order"
                            value="{{ old('sort_order', 0) }}"
                            min="0"
                        >

                    </div>



                    <div class="category-field">

                        <label>
                            الحالة
                            <span>*</span>
                        </label>


                        <select
                            name="status"
                            required
                        >

                            <option value="active">
                                نشط
                            </option>

                            <option value="inactive">
                                معطل
                            </option>

                        </select>

                    </div>


                </div>


            </div>



            <div class="category-modal-footer">


                <button
                    type="button"
                    class="category-cancel"
                    onclick="closeAddCategoryModal()"
                >
                    إلغاء
                </button>


                <button
                    type="submit"
                    class="category-save"
                >

                    <i data-lucide="plus"></i>

                    إضافة التصنيف

                </button>


            </div>


        </form>


    </div>


</div>



{{-- ============================================================
     EDIT CATEGORY MODAL
============================================================ --}}

<div
    class="category-modal"
    id="editCategoryModal"
>


    <div
        class="category-modal-backdrop"
        onclick="closeEditCategoryModal()"
    >
    </div>


    <div class="category-modal-box">


        <div class="category-modal-header">

            <div>

                <h2>
                    تعديل التصنيف
                </h2>

                <p>
                    تحديث بيانات التصنيف الحالي.
                </p>

            </div>


            <button
                type="button"
                class="category-modal-close"
                onclick="closeEditCategoryModal()"
            >

                <i data-lucide="x"></i>

            </button>

        </div>



        <form
            method="POST"
            id="editCategoryForm"
            action=""
        >

            @csrf
            @method('PUT')


            <div class="category-form-body">


                <div class="category-field full">

                    <label>
                        اسم التصنيف بالعربية
                        <span>*</span>
                    </label>


                    <input
                        type="text"
                        name="name_ar"
                        id="editCategoryNameAr"
                        required
                    >

                </div>



                <div class="category-field full">

                    <label>
                        اسم التصنيف بالإنجليزية
                    </label>


                    <input
                        type="text"
                        name="name_en"
                        id="editCategoryNameEn"
                    >

                </div>



                <div class="category-field full">

                    <label>
                        Slug
                        <span>*</span>
                    </label>


                    <input
                        type="text"
                        name="slug"
                        id="editCategorySlug"
                        required
                        dir="ltr"
                    >

                </div>



                <div class="category-form-grid">


                    <div class="category-field">

                        <label>
                            الترتيب
                        </label>


                        <input
                            type="number"
                            name="sort_order"
                            id="editCategorySortOrder"
                            min="0"
                        >

                    </div>



                    <div class="category-field">

                        <label>
                            الحالة
                        </label>


                        <select
                            name="status"
                            id="editCategoryStatus"
                        >

                            <option value="active">
                                نشط
                            </option>

                            <option value="inactive">
                                معطل
                            </option>

                        </select>

                    </div>


                </div>


            </div>



            <div class="category-modal-footer">


                <button
                    type="button"
                    class="category-cancel"
                    onclick="closeEditCategoryModal()"
                >
                    إلغاء
                </button>


                <button
                    type="submit"
                    class="category-save"
                >

                    <i data-lucide="save"></i>

                    حفظ التعديلات

                </button>


            </div>


        </form>


    </div>


</div>


@endsection



{{-- ============================================================
     STYLES
============================================================ --}}

@push('styles')

<style>

    .category-add-button {

        min-height: 43px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 7px;

        padding: 0 15px;

        border: 0;
        border-radius: 13px;

        background:
            linear-gradient(
                135deg,
                #5b7cff,
                #7c68ed
            );

        color: #ffffff;

        font-size: 11px;
        font-weight: 800;

        cursor: pointer;

        box-shadow:
            0 10px 24px rgba(91, 124, 255, .20);
    }


    .category-add-button svg {

        width: 16px;
        height: 16px;
    }



    /* =========================================================
       ALERT
    ========================================================= */

    .category-alert {

        min-height: 50px;

        display: flex;
        align-items: center;

        gap: 9px;

        padding: 11px 15px;

        margin-bottom: 17px;

        border-radius: 14px;

        font-size: 11px;
        font-weight: 700;
    }


    .category-alert svg {

        width: 17px;
        height: 17px;

        flex-shrink: 0;
    }


    .category-alert.success {

        background: #edf9f4;

        border: 1px solid #d4efe3;

        color: #23825f;
    }


    .category-alert.error {

        background: #fff1f2;

        border: 1px solid #f5d9dc;

        color: #c84c56;
    }



    /* =========================================================
       STATS
    ========================================================= */

    .category-stats {

        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 14px;

        margin-bottom: 17px;
    }


    .category-stat {

        min-height: 88px;

        display: flex;
        align-items: center;

        gap: 13px;

        padding: 17px;

        background: #ffffff;

        border: 1px solid #e8edf5;
        border-radius: 18px;

        box-shadow:
            0 10px 28px rgba(35, 48, 74, .035);
    }


    .category-stat-icon {

        width: 46px;
        height: 46px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        border-radius: 14px;
    }


    .category-stat-icon svg {

        width: 20px;
        height: 20px;
    }


    .category-stat-icon.all {

        background: #edf2ff;

        color: #5975df;
    }


    .category-stat-icon.active {

        background: #eaf8f2;

        color: #248b68;
    }


    .category-stat-icon.inactive {

        background: #fff3ea;

        color: #dc8937;
    }


    .category-stat span {

        display: block;

        margin-bottom: 4px;

        color: #929cab;

        font-size: 9px;
        font-weight: 700;
    }


    .category-stat strong {

        display: block;

        color: #364156;

        font-size: 21px;
        font-weight: 900;
    }



    /* =========================================================
       CARD
    ========================================================= */

    .category-card {

        overflow: hidden;
    }



    /* =========================================================
       TOOLBAR
    ========================================================= */

    .category-toolbar {

        padding: 18px 20px;

        border-bottom: 1px solid #edf1f6;
    }


    .category-filter-form {

        display: flex;
        align-items: center;

        gap: 9px;

        flex-wrap: wrap;
    }


    .category-search {

        width: 280px;
        height: 42px;

        display: flex;
        align-items: center;

        gap: 8px;

        padding: 0 12px;

        background: #f8fafe;

        border: 1px solid #e9edf4;
        border-radius: 12px;
    }


    .category-search svg {

        width: 16px;
        height: 16px;

        color: #99a4b4;
    }


    .category-search input {

        width: 100%;

        border: 0;
        outline: 0;

        background: transparent;

        color: #3b465a;

        font-size: 10.5px;
    }


    .category-filter-form select {

        min-width: 140px;
        height: 42px;

        padding: 0 11px;

        border: 1px solid #e9edf4;
        border-radius: 12px;

        background: #ffffff;

        color: #657185;

        outline: 0;

        font-size: 10px;
    }


    .category-filter-button,
    .category-reset-button {

        height: 42px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 6px;

        padding: 0 13px;

        border-radius: 12px;

        font-size: 10px;
        font-weight: 800;
    }


    .category-filter-button {

        border: 0;

        background: #5b7cff;

        color: #ffffff;

        cursor: pointer;
    }


    .category-reset-button {

        border: 1px solid #e8edf5;

        background: #ffffff;

        color: #748095;
    }


    .category-filter-button svg,
    .category-reset-button svg {

        width: 15px;
        height: 15px;
    }



    /* =========================================================
       TABLE
    ========================================================= */

    .category-table-wrapper {

        overflow-x: auto;
    }


    .category-table {

        width: 100%;

        border-collapse: collapse;
    }


    .category-table th {

        padding: 13px 17px;

        background: #fafbfe;

        color: #909aaa;

        text-align: right;

        white-space: nowrap;

        font-size: 9px;
        font-weight: 800;
    }


    .category-table td {

        padding: 14px 17px;

        border-top: 1px solid #f0f3f7;

        color: #657185;

        white-space: nowrap;

        font-size: 10px;
    }


    .category-table tbody tr {

        transition: .2s;
    }


    .category-table tbody tr:hover {

        background: #fcfdff;
    }



    /* =========================================================
       NAME
    ========================================================= */

    .category-name-cell {

        display: flex;
        align-items: center;

        gap: 10px;
    }


    .category-icon {

        width: 39px;
        height: 39px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        border-radius: 12px;

        background:
            linear-gradient(
                135deg,
                #edf2ff,
                #f3efff
            );

        color: #5a72d7;
    }


    .category-icon svg {

        width: 17px;
        height: 17px;
    }


    .category-name-cell strong {

        display: block;

        margin-bottom: 3px;

        color: #354156;

        font-size: 10.5px;
        font-weight: 800;
    }


    .category-name-cell span {

        color: #a2abb8;

        font-size: 8px;
    }


    .category-muted {

        color: #7e899a;
    }


    .category-slug {

        display: inline-flex;

        padding: 5px 8px;

        border-radius: 7px;

        background: #f5f7fa;

        color: #6d788b;

        direction: ltr;

        font-family: Arial, sans-serif;

        font-size: 8.5px;
    }


    .category-order {

        width: 29px;
        height: 29px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 9px;

        background: #f5f7fa;

        color: #657185;

        font-weight: 800;
    }



    /* =========================================================
       STATUS
    ========================================================= */

    .category-status {

        display: inline-flex;
        align-items: center;

        gap: 5px;

        padding: 5px 8px;

        border-radius: 20px;

        font-size: 8.5px;
        font-weight: 800;
    }


    .category-status span {

        width: 6px;
        height: 6px;

        border-radius: 50%;

        background: currentColor;
    }


    .category-status.active {

        background: #eaf8f2;

        color: #248b68;
    }


    .category-status.inactive {

        background: #fff1f1;

        color: #d5555e;
    }



    /* =========================================================
       ACTIONS
    ========================================================= */

    .category-actions {

        display: flex;
        align-items: center;

        gap: 6px;
    }


    .category-actions form {

        margin: 0;
    }


    .category-action {

        width: 32px;
        height: 32px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border: 0;
        border-radius: 9px;

        cursor: pointer;

        transition: .2s;
    }


    .category-action svg {

        width: 14px;
        height: 14px;
    }


    .category-action.edit {

        background: #edf2ff;

        color: #5872d9;
    }


    .category-action.activate {

        background: #eaf8f2;

        color: #248b68;
    }


    .category-action.disable {

        background: #fff5e7;

        color: #cc8429;
    }


    .category-action.delete {

        background: #fff0f1;

        color: #d6545d;
    }


    .category-action:hover {

        transform: translateY(-2px);
    }



    /* =========================================================
       PAGINATION
    ========================================================= */

    .category-pagination {

        padding: 16px 20px;

        border-top: 1px solid #edf1f6;
    }



    /* =========================================================
       EMPTY
    ========================================================= */

    .category-empty {

        min-height: 330px;

        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;

        padding: 30px;

        text-align: center;
    }


    .category-empty-icon {

        width: 66px;
        height: 66px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 14px;

        border-radius: 20px;

        background:
            linear-gradient(
                135deg,
                #edf2ff,
                #f3efff
            );

        color: #5d75d8;
    }


    .category-empty-icon svg {

        width: 27px;
        height: 27px;
    }


    .category-empty h2 {

        margin-bottom: 6px;

        color: #374257;

        font-size: 14px;
    }


    .category-empty p {

        margin-bottom: 15px;

        color: #949ead;

        font-size: 10px;
    }


    .category-empty button {

        min-height: 39px;

        display: inline-flex;
        align-items: center;

        gap: 6px;

        padding: 0 12px;

        border: 0;
        border-radius: 11px;

        background: #edf2ff;

        color: #5570d4;

        font-size: 9px;
        font-weight: 800;

        cursor: pointer;
    }


    .category-empty button svg {

        width: 14px;
        height: 14px;
    }



    /* =========================================================
       MODAL
    ========================================================= */

    .category-modal {

        position: fixed;

        inset: 0;

        display: none;
        align-items: center;
        justify-content: center;

        padding: 20px;

        z-index: 5000;
    }


    .category-modal.open {

        display: flex;
    }


    .category-modal-backdrop {

        position: absolute;

        inset: 0;

        background:
            rgba(28, 36, 52, .42);

        backdrop-filter:
            blur(3px);
    }


    .category-modal-box {

        position: relative;

        width: min(520px, 100%);

        max-height: 90vh;

        overflow-y: auto;

        background: #ffffff;

        border: 1px solid #e8edf5;
        border-radius: 22px;

        box-shadow:
            0 30px 80px rgba(23, 34, 57, .18);

        z-index: 2;
    }


    .category-modal-header {

        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 15px;

        padding: 20px 21px;

        border-bottom: 1px solid #edf1f6;
    }


    .category-modal-header h2 {

        margin-bottom: 4px;

        color: #313c51;

        font-size: 15px;
        font-weight: 900;
    }


    .category-modal-header p {

        color: #929cab;

        font-size: 9.5px;
    }


    .category-modal-close {

        width: 35px;
        height: 35px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        border: 1px solid #e9edf4;
        border-radius: 10px;

        background: #ffffff;

        color: #8490a2;

        cursor: pointer;
    }


    .category-modal-close svg {

        width: 16px;
        height: 16px;
    }



    /* =========================================================
       FORM
    ========================================================= */

    .category-form-body {

        padding: 21px;
    }


    .category-form-grid {

        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 12px;
    }


    .category-field {

        margin-bottom: 14px;
    }


    .category-field.full {

        width: 100%;
    }


    .category-field label {

        display: block;

        margin-bottom: 7px;

        color: #535f72;

        font-size: 10px;
        font-weight: 800;
    }


    .category-field label span {

        color: #e0545d;
    }


    .category-field input,
    .category-field select {

        width: 100%;
        height: 43px;

        padding: 0 12px;

        border: 1px solid #e4e9f1;
        border-radius: 11px;

        background: #fafbfe;

        color: #3e495c;

        outline: 0;

        font-size: 10.5px;

        transition: .2s;
    }


    .category-field input:focus,
    .category-field select:focus {

        border-color: #9bacf2;

        background: #ffffff;

        box-shadow:
            0 0 0 3px rgba(91, 124, 255, .08);
    }


    .category-field small {

        display: block;

        margin-top: 5px;

        color: #9aa4b3;

        font-size: 8.5px;
    }



    /* =========================================================
       MODAL FOOTER
    ========================================================= */

    .category-modal-footer {

        display: flex;
        align-items: center;
        justify-content: flex-end;

        gap: 8px;

        padding: 15px 21px;

        border-top: 1px solid #edf1f6;

        background: #fafbfe;
    }


    .category-cancel,
    .category-save {

        min-height: 40px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 6px;

        padding: 0 14px;

        border-radius: 11px;

        font-size: 10px;
        font-weight: 800;

        cursor: pointer;
    }


    .category-cancel {

        border: 1px solid #e3e8f0;

        background: #ffffff;

        color: #758094;
    }


    .category-save {

        border: 0;

        background:
            linear-gradient(
                135deg,
                #5b7cff,
                #7969ea
            );

        color: #ffffff;
    }


    .category-save svg {

        width: 14px;
        height: 14px;
    }



    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 850px) {

        .category-stats {

            grid-template-columns: 1fr;
        }


        .category-search {

            width: 100%;
        }


        .category-filter-form select {

            flex: 1;
        }

    }


    @media (max-width: 550px) {

        .category-form-grid {

            grid-template-columns: 1fr;
        }


        .category-add-button {

            width: 100%;
        }

    }

</style>

@endpush



{{-- ============================================================
     SCRIPTS
============================================================ --}}

@push('scripts')

<script>

    /*
    |--------------------------------------------------------------------------
    | إضافة تصنيف
    |--------------------------------------------------------------------------
    */

    function openAddCategoryModal()
    {
        const modal =
            document.getElementById(
                'addCategoryModal'
            );

        if (modal) {

            modal.classList.add('open');

            document.body.style.overflow =
                'hidden';
        }
    }


    function closeAddCategoryModal()
    {
        const modal =
            document.getElementById(
                'addCategoryModal'
            );

        if (modal) {

            modal.classList.remove('open');

            document.body.style.overflow =
                '';
        }
    }



    /*
    |--------------------------------------------------------------------------
    | تعديل التصنيف
    |--------------------------------------------------------------------------
    */

    function openEditCategoryModal(button)
    {
        const modal =
            document.getElementById(
                'editCategoryModal'
            );


        const form =
            document.getElementById(
                'editCategoryForm'
            );


        const nameAr =
            document.getElementById(
                'editCategoryNameAr'
            );


        const nameEn =
            document.getElementById(
                'editCategoryNameEn'
            );


        const slug =
            document.getElementById(
                'editCategorySlug'
            );


        const sortOrder =
            document.getElementById(
                'editCategorySortOrder'
            );


        const status =
            document.getElementById(
                'editCategoryStatus'
            );


        form.action =
            button.dataset.updateUrl;


        nameAr.value =
            button.dataset.nameAr || '';


        nameEn.value =
            button.dataset.nameEn || '';


        slug.value =
            button.dataset.slug || '';


        sortOrder.value =
            button.dataset.sortOrder || 0;


        status.value =
            button.dataset.status || 'active';


        modal.classList.add('open');

        document.body.style.overflow =
            'hidden';
    }


    function closeEditCategoryModal()
    {
        const modal =
            document.getElementById(
                'editCategoryModal'
            );


        if (modal) {

            modal.classList.remove('open');

            document.body.style.overflow =
                '';
        }
    }



    /*
    |--------------------------------------------------------------------------
    | ESC
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Escape') {

                closeAddCategoryModal();

                closeEditCategoryModal();
            }

        }
    );

</script>

@endpush