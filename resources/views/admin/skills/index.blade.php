@extends('layouts.admin.admin')

@section('title', 'إدارة المهارات')
@section('page-title', 'إدارة المهارات')

@section('content')

<div class="admin-page-heading">

    <div>
        <h1>إدارة المهارات</h1>

        <p>
            إضافة وتنظيم المهارات المرتبطة بتصنيفات منصة NASEJA.
        </p>
    </div>

    <button
        type="button"
        class="skill-add-btn"
        onclick="openAddSkillModal()"
    >
        <i data-lucide="plus"></i>
        إضافة مهارة
    </button>

</div>


{{-- =========================================================
     رسائل النجاح والخطأ
========================================================= --}}

@if(session('success'))

    <div class="skill-alert success">
        <i data-lucide="circle-check"></i>
        {{ session('success') }}
    </div>

@endif


@if(session('error'))

    <div class="skill-alert error">
        <i data-lucide="circle-alert"></i>
        {{ session('error') }}
    </div>

@endif


@if($errors->any())

    <div class="skill-alert error">

        <i data-lucide="circle-alert"></i>

        <div>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>

    </div>

@endif



{{-- =========================================================
     الإحصائيات
========================================================= --}}

<div class="skill-stats">

    <div class="skill-stat-card">

        <div class="skill-stat-icon blue">
            <i data-lucide="sparkles"></i>
        </div>

        <div>
            <span>إجمالي المهارات</span>
            <strong>{{ $totalSkills }}</strong>
        </div>

    </div>


    <div class="skill-stat-card">

        <div class="skill-stat-icon green">
            <i data-lucide="circle-check"></i>
        </div>

        <div>
            <span>المهارات النشطة</span>
            <strong>{{ $activeSkills }}</strong>
        </div>

    </div>


    <div class="skill-stat-card">

        <div class="skill-stat-icon orange">
            <i data-lucide="circle-pause"></i>
        </div>

        <div>
            <span>المهارات المعطلة</span>
            <strong>{{ $inactiveSkills }}</strong>
        </div>

    </div>

</div>



{{-- =========================================================
     المحتوى الرئيسي
========================================================= --}}

<section class="admin-card skill-main-card">


    {{-- البحث والفلترة --}}

    <div class="skill-toolbar">

        <form
            action="{{ route('admin.skills.index') }}"
            method="GET"
            class="skill-filter-form"
        >

            <div class="skill-search">

                <i data-lucide="search"></i>

                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="ابحث عن مهارة..."
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

            </select>


            <button
                type="submit"
                class="skill-filter-btn"
            >
                <i data-lucide="sliders-horizontal"></i>
                تطبيق
            </button>


            <a
                href="{{ route('admin.skills.index') }}"
                class="skill-reset-btn"
            >
                <i data-lucide="rotate-ccw"></i>
                إعادة ضبط
            </a>

        </form>

    </div>



    {{-- =====================================================
         الجدول
    ===================================================== --}}

    @if($skills->count())

        <div class="skill-table-wrapper">

            <table class="skill-table">

                <thead>

                    <tr>
                        <th>المهارة</th>
                        <th>التصنيف</th>
                        <th>الاسم الإنجليزي</th>
                        <th>Slug</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>

                </thead>


                <tbody>

                    @foreach($skills as $skill)

                        <tr>

                            <td>

                                <div class="skill-name-cell">

                                    <div class="skill-row-icon">
                                        <i data-lucide="sparkles"></i>
                                    </div>

                                    <div>

                                        <strong>
                                            {{ $skill->name_ar }}
                                        </strong>

                                        <span>
                                            ID #{{ $skill->id }}
                                        </span>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <span class="skill-category-badge">

                                    {{ $skill->category?->name_ar ?? '—' }}

                                </span>

                            </td>


                            <td>

                                {{ $skill->name_en }}

                            </td>


                            <td>

                                <span class="skill-slug">
                                    {{ $skill->slug }}
                                </span>

                            </td>


                            <td>

                                @if($skill->status === 'active')

                                    <span class="skill-status active">

                                        <span></span>

                                        نشطة

                                    </span>

                                @else

                                    <span class="skill-status inactive">

                                        <span></span>

                                        معطلة

                                    </span>

                                @endif

                            </td>


                            <td>

                                <div class="skill-actions">


                                    {{-- تعديل --}}

                                    <button
                                        type="button"
                                        class="skill-action edit"
                                        title="تعديل"
                                        data-name-ar="{{ $skill->name_ar }}"
                                        data-name-en="{{ $skill->name_en }}"
                                        data-slug="{{ $skill->slug }}"
                                        data-description="{{ $skill->description }}"
                                        data-category-id="{{ $skill->category_id }}"
                                        data-status="{{ $skill->status }}"
                                        data-update-url="{{ route('admin.skills.update', $skill) }}"
                                        onclick="openEditSkillModal(this)"
                                    >
                                        <i data-lucide="pencil"></i>
                                    </button>



                                    {{-- تفعيل / تعطيل --}}

                                    @if($skill->status === 'active')

                                        <form
                                            method="POST"
                                            action="{{ route('admin.skills.deactivate', $skill) }}"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="skill-action disable"
                                                title="تعطيل"
                                                onclick="return confirm('هل تريد تعطيل هذه المهارة؟')"
                                            >
                                                <i data-lucide="circle-pause"></i>
                                            </button>

                                        </form>

                                    @else

                                        <form
                                            method="POST"
                                            action="{{ route('admin.skills.activate', $skill) }}"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="skill-action activate"
                                                title="تفعيل"
                                            >
                                                <i data-lucide="circle-check"></i>
                                            </button>

                                        </form>

                                    @endif



                                    {{-- حذف --}}

                                    <form
                                        method="POST"
                                        action="{{ route('admin.skills.destroy', $skill) }}"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="skill-action delete"
                                            title="حذف"
                                            onclick="return confirm('هل أنت متأكد من حذف هذه المهارة؟')"
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


        <div class="skill-pagination">

            {{ $skills->links() }}

        </div>

    @else

        <div class="skill-empty">

            <div class="skill-empty-icon">
                <i data-lucide="sparkles"></i>
            </div>

            <h2>
                لا توجد مهارات
            </h2>

            <p>
                لا توجد مهارات مطابقة للبحث أو الفلاتر الحالية.
            </p>

            <button
                type="button"
                onclick="openAddSkillModal()"
            >
                <i data-lucide="plus"></i>
                إضافة مهارة
            </button>

        </div>

    @endif

</section>



{{-- =========================================================
     MODAL إضافة مهارة
========================================================= --}}

<div
    class="skill-modal"
    id="addSkillModal"
>

    <div
        class="skill-modal-backdrop"
        onclick="closeAddSkillModal()"
    ></div>


    <div class="skill-modal-box">

        <div class="skill-modal-header">

            <div>
                <h2>إضافة مهارة جديدة</h2>

                <p>
                    أضيفي مهارة وربطيها بالتصنيف المناسب.
                </p>
            </div>

            <button
                type="button"
                onclick="closeAddSkillModal()"
                class="skill-modal-close"
            >
                <i data-lucide="x"></i>
            </button>

        </div>


        <form
            method="POST"
            action="{{ route('admin.skills.store') }}"
        >

            @csrf


            <div class="skill-form-body">


                <div class="skill-field">

                    <label>
                        التصنيف
                        <span>*</span>
                    </label>

                    <select
                        name="category_id"
                        required
                    >

                        <option value="">
                            اختاري التصنيف
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}
                            >
                                {{ $category->name_ar }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="skill-form-grid">

                    <div class="skill-field">

                        <label>
                            اسم المهارة بالعربية
                            <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="name_ar"
                            value="{{ old('name_ar') }}"
                            placeholder="مثال: تطريز يدوي"
                            required
                        >

                    </div>


                    <div class="skill-field">

                        <label>
                            اسم المهارة بالإنجليزية
                            <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="name_en"
                            value="{{ old('name_en') }}"
                            placeholder="Hand Embroidery"
                            required
                        >

                    </div>

                </div>


                <div class="skill-field">

                    <label>
                        Slug
                    </label>

                    <input
                        type="text"
                        name="slug"
                        value="{{ old('slug') }}"
                        placeholder="hand-embroidery"
                        dir="ltr"
                    >

                    <small>
                        يمكن تركه فارغًا وسيتم إنشاؤه تلقائيًا.
                    </small>

                </div>


                <div class="skill-field">

                    <label>
                        الوصف
                    </label>

                    <textarea
                        name="description"
                        rows="4"
                        placeholder="وصف مختصر عن المهارة..."
                    >{{ old('description') }}</textarea>

                </div>


                <div class="skill-field">

                    <label>
                        الحالة
                        <span>*</span>
                    </label>

                    <select
                        name="status"
                        required
                    >

                        <option value="active">
                            نشطة
                        </option>

                        <option value="inactive">
                            معطلة
                        </option>

                    </select>

                </div>

            </div>


            <div class="skill-modal-footer">

                <button
                    type="button"
                    class="skill-cancel-btn"
                    onclick="closeAddSkillModal()"
                >
                    إلغاء
                </button>

                <button
                    type="submit"
                    class="skill-save-btn"
                >
                    <i data-lucide="plus"></i>
                    إضافة المهارة
                </button>

            </div>

        </form>

    </div>

</div>



{{-- =========================================================
     MODAL تعديل المهارة
========================================================= --}}

<div
    class="skill-modal"
    id="editSkillModal"
>

    <div
        class="skill-modal-backdrop"
        onclick="closeEditSkillModal()"
    ></div>


    <div class="skill-modal-box">

        <div class="skill-modal-header">

            <div>
                <h2>تعديل المهارة</h2>

                <p>
                    تحديث بيانات المهارة الحالية.
                </p>
            </div>

            <button
                type="button"
                onclick="closeEditSkillModal()"
                class="skill-modal-close"
            >
                <i data-lucide="x"></i>
            </button>

        </div>


        <form
            method="POST"
            action=""
            id="editSkillForm"
        >

            @csrf
            @method('PUT')


            <div class="skill-form-body">


                <div class="skill-field">

                    <label>
                        التصنيف
                        <span>*</span>
                    </label>

                    <select
                        name="category_id"
                        id="editSkillCategory"
                        required
                    >

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}">
                                {{ $category->name_ar }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="skill-form-grid">

                    <div class="skill-field">

                        <label>
                            الاسم بالعربية
                            <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="name_ar"
                            id="editSkillNameAr"
                            required
                        >

                    </div>


                    <div class="skill-field">

                        <label>
                            الاسم بالإنجليزية
                            <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="name_en"
                            id="editSkillNameEn"
                            required
                        >

                    </div>

                </div>


                <div class="skill-field">

                    <label>
                        Slug
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        name="slug"
                        id="editSkillSlug"
                        dir="ltr"
                        required
                    >

                </div>


                <div class="skill-field">

                    <label>
                        الوصف
                    </label>

                    <textarea
                        name="description"
                        id="editSkillDescription"
                        rows="4"
                    ></textarea>

                </div>


                <div class="skill-field">

                    <label>
                        الحالة
                    </label>

                    <select
                        name="status"
                        id="editSkillStatus"
                    >

                        <option value="active">
                            نشطة
                        </option>

                        <option value="inactive">
                            معطلة
                        </option>

                    </select>

                </div>

            </div>


            <div class="skill-modal-footer">

                <button
                    type="button"
                    class="skill-cancel-btn"
                    onclick="closeEditSkillModal()"
                >
                    إلغاء
                </button>

                <button
                    type="submit"
                    class="skill-save-btn"
                >
                    <i data-lucide="save"></i>
                    حفظ التعديلات
                </button>

            </div>

        </form>

    </div>

</div>

@endsection



@push('styles')

<style>

    .skill-add-btn {
        height: 43px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 0 16px;
        border: 0;
        border-radius: 13px;
        background: linear-gradient(135deg, #5b7cff, #836bf0);
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 10px 24px rgba(91,124,255,.2);
    }

    .skill-add-btn svg {
        width: 16px;
        height: 16px;
    }


    .skill-alert {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 12px 15px;
        margin-bottom: 16px;
        border-radius: 14px;
        font-size: 10.5px;
        font-weight: 700;
    }

    .skill-alert svg {
        width: 17px;
    }

    .skill-alert.success {
        background: #eaf8f2;
        border: 1px solid #d5eee4;
        color: #268566;
    }

    .skill-alert.error {
        background: #fff0f1;
        border: 1px solid #f2d8db;
        color: #ce5059;
    }


    .skill-stats {
        display: grid;
        grid-template-columns: repeat(3,1fr);
        gap: 14px;
        margin-bottom: 18px;
    }

    .skill-stat-card {
        display: flex;
        align-items: center;
        gap: 13px;
        min-height: 88px;
        padding: 17px;
        background: #fff;
        border: 1px solid #e8edf5;
        border-radius: 18px;
    }

    .skill-stat-icon {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
    }

    .skill-stat-icon svg {
        width: 20px;
    }

    .skill-stat-icon.blue {
        background:#edf2ff;
        color:#5874dd;
    }

    .skill-stat-icon.green {
        background:#eaf8f2;
        color:#248b68;
    }

    .skill-stat-icon.orange {
        background:#fff3e7;
        color:#d88a32;
    }

    .skill-stat-card span {
        display:block;
        margin-bottom:4px;
        color:#939dac;
        font-size:9px;
    }

    .skill-stat-card strong {
        color:#354055;
        font-size:21px;
        font-weight:900;
    }


    .skill-main-card {
        overflow:hidden;
    }


    .skill-toolbar {
        padding:18px 20px;
        border-bottom:1px solid #edf1f6;
    }

    .skill-filter-form {
        display:flex;
        align-items:center;
        flex-wrap:wrap;
        gap:9px;
    }

    .skill-search {
        width:260px;
        height:42px;
        display:flex;
        align-items:center;
        gap:8px;
        padding:0 12px;
        border:1px solid #e8edf4;
        border-radius:12px;
        background:#f8fafe;
    }

    .skill-search svg {
        width:16px;
        color:#99a4b4;
    }

    .skill-search input {
        width:100%;
        border:0;
        outline:0;
        background:transparent;
        font-size:10px;
    }

    .skill-filter-form select {
        height:42px;
        min-width:145px;
        border:1px solid #e8edf4;
        border-radius:12px;
        padding:0 10px;
        background:#fff;
        color:#657185;
        outline:0;
        font-size:10px;
    }

    .skill-filter-btn,
    .skill-reset-btn {
        height:42px;
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:0 13px;
        border-radius:12px;
        font-size:10px;
        font-weight:800;
    }

    .skill-filter-btn {
        border:0;
        background:#5b7cff;
        color:#fff;
        cursor:pointer;
    }

    .skill-reset-btn {
        border:1px solid #e7ebf2;
        background:#fff;
        color:#748095;
    }

    .skill-filter-btn svg,
    .skill-reset-btn svg {
        width:14px;
    }


    .skill-table-wrapper {
        overflow-x:auto;
    }

    .skill-table {
        width:100%;
        border-collapse:collapse;
    }

    .skill-table th {
        padding:13px 17px;
        background:#fafbfe;
        color:#929cab;
        text-align:right;
        white-space:nowrap;
        font-size:9px;
        font-weight:800;
    }

    .skill-table td {
        padding:14px 17px;
        border-top:1px solid #f0f3f7;
        color:#657185;
        white-space:nowrap;
        font-size:10px;
    }

    .skill-name-cell {
        display:flex;
        align-items:center;
        gap:10px;
    }

    .skill-row-icon {
        width:39px;
        height:39px;
        display:flex;
        align-items:center;
        justify-content:center;
        border-radius:12px;
        background:linear-gradient(135deg,#edf2ff,#f3efff);
        color:#6274d8;
    }

    .skill-row-icon svg {
        width:17px;
    }

    .skill-name-cell strong {
        display:block;
        margin-bottom:3px;
        color:#354156;
        font-size:10.5px;
    }

    .skill-name-cell span {
        color:#a2abb8;
        font-size:8px;
    }

    .skill-category-badge {
        display:inline-flex;
        padding:5px 9px;
        border-radius:20px;
        background:#f2eeff;
        color:#7560ca;
        font-size:8.5px;
        font-weight:800;
    }

    .skill-slug {
        display:inline-flex;
        padding:5px 8px;
        border-radius:7px;
        background:#f5f7fa;
        font-family:Arial,sans-serif;
        direction:ltr;
        font-size:8.5px;
    }

    .skill-status {
        display:inline-flex;
        align-items:center;
        gap:5px;
        padding:5px 8px;
        border-radius:20px;
        font-size:8.5px;
        font-weight:800;
    }

    .skill-status span {
        width:6px;
        height:6px;
        border-radius:50%;
        background:currentColor;
    }

    .skill-status.active {
        background:#eaf8f2;
        color:#248b68;
    }

    .skill-status.inactive {
        background:#fff0f1;
        color:#d4545e;
    }

    .skill-actions {
        display:flex;
        align-items:center;
        gap:6px;
    }

    .skill-actions form {
        margin:0;
    }

    .skill-action {
        width:32px;
        height:32px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        border:0;
        border-radius:9px;
        cursor:pointer;
    }

    .skill-action svg {
        width:14px;
    }

    .skill-action.edit {
        background:#edf2ff;
        color:#5872d9;
    }

    .skill-action.activate {
        background:#eaf8f2;
        color:#248b68;
    }

    .skill-action.disable {
        background:#fff5e7;
        color:#cc8429;
    }

    .skill-action.delete {
        background:#fff0f1;
        color:#d6545d;
    }

    .skill-pagination {
        padding:16px 20px;
        border-top:1px solid #edf1f6;
    }


    .skill-empty {
        min-height:300px;
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
        text-align:center;
    }

    .skill-empty-icon {
        width:64px;
        height:64px;
        display:flex;
        align-items:center;
        justify-content:center;
        margin-bottom:13px;
        border-radius:20px;
        background:linear-gradient(135deg,#edf2ff,#f3efff);
        color:#6074d7;
    }

    .skill-empty h2 {
        margin-bottom:5px;
        font-size:14px;
    }

    .skill-empty p {
        margin-bottom:14px;
        color:#929cab;
        font-size:9.5px;
    }

    .skill-empty button {
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:10px 13px;
        border:0;
        border-radius:11px;
        background:#edf2ff;
        color:#5670d5;
        font-size:9px;
        font-weight:800;
        cursor:pointer;
    }


    /* MODAL */

    .skill-modal {
        position:fixed;
        inset:0;
        display:none;
        align-items:center;
        justify-content:center;
        padding:20px;
        z-index:5000;
    }

    .skill-modal.open {
        display:flex;
    }

    .skill-modal-backdrop {
        position:absolute;
        inset:0;
        background:rgba(27,35,51,.42);
        backdrop-filter:blur(3px);
    }

    .skill-modal-box {
        position:relative;
        z-index:2;
        width:min(570px,100%);
        max-height:90vh;
        overflow:auto;
        background:#fff;
        border:1px solid #e8edf5;
        border-radius:22px;
        box-shadow:0 30px 80px rgba(23,34,57,.18);
    }

    .skill-modal-header {
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:15px;
        padding:20px 21px;
        border-bottom:1px solid #edf1f6;
    }

    .skill-modal-header h2 {
        margin-bottom:4px;
        color:#313c51;
        font-size:15px;
        font-weight:900;
    }

    .skill-modal-header p {
        color:#929cab;
        font-size:9.5px;
    }

    .skill-modal-close {
        width:35px;
        height:35px;
        display:flex;
        align-items:center;
        justify-content:center;
        border:1px solid #e9edf4;
        border-radius:10px;
        background:#fff;
        color:#8490a2;
        cursor:pointer;
    }

    .skill-modal-close svg {
        width:16px;
    }

    .skill-form-body {
        padding:21px;
    }

    .skill-form-grid {
        display:grid;
        grid-template-columns:repeat(2,1fr);
        gap:12px;
    }

    .skill-field {
        margin-bottom:14px;
    }

    .skill-field label {
        display:block;
        margin-bottom:7px;
        color:#535f72;
        font-size:10px;
        font-weight:800;
    }

    .skill-field label span {
        color:#e0545d;
    }

    .skill-field input,
    .skill-field select,
    .skill-field textarea {
        width:100%;
        border:1px solid #e4e9f1;
        border-radius:11px;
        background:#fafbfe;
        color:#3e495c;
        outline:0;
        padding:0 12px;
        font-size:10.5px;
    }

    .skill-field input,
    .skill-field select {
        height:43px;
    }

    .skill-field textarea {
        padding:11px 12px;
        resize:vertical;
    }

    .skill-field input:focus,
    .skill-field select:focus,
    .skill-field textarea:focus {
        border-color:#9bacf2;
        background:#fff;
        box-shadow:0 0 0 3px rgba(91,124,255,.08);
    }

    .skill-field small {
        display:block;
        margin-top:5px;
        color:#99a4b3;
        font-size:8.5px;
    }

    .skill-modal-footer {
        display:flex;
        justify-content:flex-end;
        gap:8px;
        padding:15px 21px;
        border-top:1px solid #edf1f6;
        background:#fafbfe;
    }

    .skill-cancel-btn,
    .skill-save-btn {
        min-height:40px;
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:0 14px;
        border-radius:11px;
        font-size:10px;
        font-weight:800;
        cursor:pointer;
    }

    .skill-cancel-btn {
        border:1px solid #e3e8f0;
        background:#fff;
        color:#758094;
    }

    .skill-save-btn {
        border:0;
        background:linear-gradient(135deg,#5b7cff,#7969ea);
        color:#fff;
    }

    .skill-save-btn svg {
        width:14px;
    }


    @media(max-width:800px) {

        .skill-stats {
            grid-template-columns:1fr;
        }

        .skill-search {
            width:100%;
        }

    }

    @media(max-width:550px) {

        .skill-form-grid {
            grid-template-columns:1fr;
        }

        .skill-add-btn {
            width:100%;
        }

    }

</style>

@endpush



@push('scripts')

<script>

    function openAddSkillModal()
    {
        const modal =
            document.getElementById('addSkillModal');

        modal.classList.add('open');

        document.body.style.overflow = 'hidden';
    }


    function closeAddSkillModal()
    {
        const modal =
            document.getElementById('addSkillModal');

        modal.classList.remove('open');

        document.body.style.overflow = '';
    }


    function openEditSkillModal(button)
    {
        const modal =
            document.getElementById('editSkillModal');

        const form =
            document.getElementById('editSkillForm');


        form.action =
            button.dataset.updateUrl;


        document.getElementById(
            'editSkillNameAr'
        ).value =
            button.dataset.nameAr || '';


        document.getElementById(
            'editSkillNameEn'
        ).value =
            button.dataset.nameEn || '';


        document.getElementById(
            'editSkillSlug'
        ).value =
            button.dataset.slug || '';


        document.getElementById(
            'editSkillDescription'
        ).value =
            button.dataset.description || '';


        document.getElementById(
            'editSkillCategory'
        ).value =
            button.dataset.categoryId;


        document.getElementById(
            'editSkillStatus'
        ).value =
            button.dataset.status;


        modal.classList.add('open');

        document.body.style.overflow =
            'hidden';
    }


    function closeEditSkillModal()
    {
        const modal =
            document.getElementById('editSkillModal');

        modal.classList.remove('open');

        document.body.style.overflow = '';
    }


    document.addEventListener(
        'keydown',
        function(event)
        {
            if(event.key === 'Escape')
            {
                closeAddSkillModal();
                closeEditSkillModal();
            }
        }
    );

</script>

@endpush