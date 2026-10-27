```blade
@extends('layouts.frontend.user')

@section('title', 'تعديل العمل | NASEJA')

@section('content')

<style>

    .portfolio-edit-page {
        max-width: 1000px;
        margin: 0 auto;
        padding: 10px 20px 40px;
    }

    .portfolio-edit-title {
        text-align: center;
        margin-bottom: 25px;
    }

    .portfolio-edit-title h1 {
        margin: 0 0 8px;
        color: #18182d;
        font-size: 34px;
        font-weight: 800;
    }

    .portfolio-edit-title p {
        margin: 0;
        color: #85859a;
        font-size: 13px;
    }

    .portfolio-edit-card {
        margin-bottom: 22px;
        padding: 30px;
        border-radius: 22px;
        background: rgba(255,255,255,.96);
        border: 1px solid #eeeef5;
        box-shadow: 0 20px 55px rgba(65,54,170,.10);
    }

    .portfolio-edit-heading {
        margin-bottom: 22px;
    }

    .portfolio-edit-heading h2 {
        margin: 0 0 5px;
        color: #18182d;
        font-size: 21px;
        font-weight: 800;
    }

    .portfolio-edit-heading p {
        margin: 0;
        color: #85859a;
        font-size: 12px;
    }

    .portfolio-edit-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .portfolio-edit-full {
        grid-column: 1 / -1;
    }

    .portfolio-edit-field label {
        display: block;
        margin-bottom: 7px;
        color: #303047;
        font-size: 12px;
        font-weight: 700;
    }

    .portfolio-edit-field input,
    .portfolio-edit-field textarea {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #e8e7f0;
        border-radius: 12px;
        outline: none;
        background: #fafaff;
        color: #303047;
        font-family: inherit;
        font-size: 13px;
        transition: .2s ease;
    }

    .portfolio-edit-field input {
        height: 48px;
        padding: 0 13px;
    }

    .portfolio-edit-field textarea {
        padding: 13px;
        resize: vertical;
    }

    .portfolio-edit-field input:focus,
    .portfolio-edit-field textarea:focus {
        background: white;
        border-color: #6657e8;
        box-shadow: 0 0 0 4px rgba(102,87,232,.08);
    }

    .portfolio-edit-field input[type="file"] {
        height: auto;
        padding: 13px;
        cursor: pointer;
    }

    .portfolio-edit-help {
        display: block;
        margin-top: 7px;
        color: #85859a;
        font-size: 11px;
    }


    /* ================================
       الصور الحالية
    ================================= */

    .portfolio-current-images {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-top: 15px;
    }

    .portfolio-current-image {
        position: relative;
        overflow: hidden;
        border-radius: 16px;
        background: #f4f3fa;
        border: 1px solid #eeeef5;
    }

    .portfolio-current-image img {
        width: 100%;
        height: 180px;
        display: block;
        object-fit: cover;
    }


    /* ================================
       أزرار الصور
    ================================= */

    .portfolio-image-actions {
        display: flex;
        gap: 8px;
        padding: 10px;
        background: white;
    }

    .portfolio-replace-image {
        flex: 1;
    }

    .portfolio-replace-image input[type="file"] {
        display: none;
    }

    .portfolio-replace-label {
        height: 38px;
        padding: 0 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border-radius: 10px;
        background: #6657e8;
        color: white;
        font-family: inherit;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        box-sizing: border-box;
    }

    .portfolio-replace-label:hover {
        background: #5142d4;
    }

    .portfolio-delete-image {
        width: 42px;
        flex-shrink: 0;
    }

    .portfolio-delete-image button {
        width: 100%;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: 10px;
        background: #fff1f1;
        color: #c62828;
        cursor: pointer;
    }

    .portfolio-delete-image button:hover {
        background: #ffe0e0;
    }


    /* ================================
       الأزرار الرئيسية
    ================================= */

    .portfolio-edit-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 25px;
    }

    .portfolio-save-button,
    .portfolio-back-button {
        height: 46px;
        padding: 0 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-radius: 12px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        box-sizing: border-box;
    }

    .portfolio-save-button {
        border: none;
        color: white;
        background: linear-gradient(135deg, #6657e8, #5142d4);
        box-shadow: 0 8px 20px rgba(91,75,219,.18);
    }

    .portfolio-save-button:hover {
        transform: translateY(-1px);
    }

    .portfolio-back-button {
        border: 1px solid #e4e1e8;
        background: white;
        color: #55556b;
    }

    .portfolio-back-button:hover {
        background: #f8f7fc;
    }


    /* ================================
       الرسائل
    ================================= */

    .portfolio-edit-success {
        margin-bottom: 20px;
        padding: 13px 17px;
        border-radius: 12px;
        background: #e9fff8;
        border: 1px solid #b8f1df;
        color: #08785f;
        font-size: 13px;
        font-weight: 700;
    }

    .portfolio-edit-errors {
        margin-bottom: 20px;
        padding: 13px 17px;
        border-radius: 12px;
        background: #fff1f1;
        border: 1px solid #ffd0d0;
        color: #c62828;
        font-size: 13px;
        font-weight: 600;
    }

    .portfolio-edit-errors div {
        margin-bottom: 4px;
    }


    /* ================================
       لا توجد صور
    ================================= */

    .portfolio-no-current-images {
        padding: 35px 20px;
        text-align: center;
        border: 1px dashed #dddbea;
        border-radius: 16px;
        background: #fafaff;
        color: #85859a;
        font-size: 12px;
    }


    /* ================================
       الجوال
    ================================= */

    @media (max-width: 800px) {

        .portfolio-edit-grid {
            grid-template-columns: 1fr;
        }

        .portfolio-edit-full {
            grid-column: auto;
        }

        .portfolio-current-images {
            grid-template-columns: 1fr 1fr;
        }
    }


    @media (max-width: 600px) {

        .portfolio-edit-card {
            padding: 20px;
        }

        .portfolio-current-images {
            grid-template-columns: 1fr;
        }

        .portfolio-current-image img {
            height: 180px;
        }

        .portfolio-edit-actions {
            flex-direction: column;
        }

        .portfolio-save-button,
        .portfolio-back-button {
            width: 100%;
        }
    }

</style>


<div class="portfolio-edit-page">


    {{-- ============================= --}}
    {{-- عنوان الصفحة --}}
    {{-- ============================= --}}

    <div class="portfolio-edit-title">

        <h1>
            تعديل العمل
        </h1>

        <p>
            عدّل معلومات العمل والصور الخاصة به.
        </p>

    </div>


    {{-- ============================= --}}
    {{-- رسالة النجاح --}}
    {{-- ============================= --}}

    @if(session('success'))

        <div class="portfolio-edit-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- ============================= --}}
    {{-- أخطاء التحقق --}}
    {{-- ============================= --}}

    @if($errors->any())

        <div class="portfolio-edit-errors">

            @foreach($errors->all() as $error)

                <div>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    @endif


    {{-- ============================= --}}
    {{-- نموذج تعديل بيانات العمل --}}
    {{-- ============================= --}}

    <section class="portfolio-edit-card">

        <div class="portfolio-edit-heading">

            <h2>
                معلومات العمل
            </h2>

            <p>
                قم بتعديل البيانات التي تريد تغييرها ثم احفظ التعديلات.
            </p>

        </div>


        <form
            method="POST"
            action="{{ route('portfolio.update', $portfolioItem) }}"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')


            <div class="portfolio-edit-grid">


                {{-- العنوان العربي --}}

                <div class="portfolio-edit-field">

                    <label for="title_ar">
                        عنوان العمل بالعربي
                    </label>

                    <input
                        type="text"
                        id="title_ar"
                        name="title_ar"
                        required
                        value="{{ old('title_ar', $portfolioItem->title_ar) }}"
                    >

                </div>


                {{-- العنوان الإنجليزي --}}

                <div class="portfolio-edit-field">

                    <label for="title_en">
                        عنوان العمل بالإنجليزي (اختياري)
                    </label>

                    <input
                        type="text"
                        id="title_en"
                        name="title_en"
                        value="{{ old('title_en', $portfolioItem->title_en) }}"
                        dir="ltr"
                    >

                </div>


                {{-- التاريخ --}}

                <div class="portfolio-edit-field">

                    <label for="work_date">
                        تاريخ العمل (اختياري)
                    </label>

                    <input
                        type="date"
                        id="work_date"
                        name="work_date"
                        value="{{ old(
                            'work_date',
                            $portfolioItem->work_date
                                ? $portfolioItem->work_date->format('Y-m-d')
                                : ''
                        ) }}"
                    >

                </div>


                {{-- الوصف العربي --}}

                <div class="portfolio-edit-field portfolio-edit-full">

                    <label for="description_ar">
                        وصف العمل بالعربي (اختياري)
                    </label>

                    <textarea
                        id="description_ar"
                        name="description_ar"
                        rows="4"
                    >{{ old('description_ar', $portfolioItem->description_ar) }}</textarea>

                </div>


                {{-- الوصف الإنجليزي --}}

                <div class="portfolio-edit-field portfolio-edit-full">

                    <label for="description_en">
                        وصف العمل بالإنجليزي (اختياري)
                    </label>

                    <textarea
                        id="description_en"
                        name="description_en"
                        rows="4"
                        dir="ltr"
                    >{{ old('description_en', $portfolioItem->description_en) }}</textarea>

                </div>


                {{-- إضافة صور جديدة --}}

                <div class="portfolio-edit-field portfolio-edit-full">

                    <label for="images">
                        إضافة صور جديدة
                    </label>

                    <input
                        type="file"
                        id="images"
                        name="images[]"
                        accept=".jpg,.jpeg,.png,.webp"
                        multiple
                    >

                    <small class="portfolio-edit-help">
                        يمكنك إضافة صور جديدة بدون حذف الصور الحالية.
                        JPG / JPEG / PNG / WEBP
                    </small>

                </div>

            </div>


            {{-- الأزرار --}}

            <div class="portfolio-edit-actions">

                <button
                    type="submit"
                    class="portfolio-save-button"
                >

                    <i data-lucide="save"></i>

                    حفظ التعديلات

                </button>


                <a
                    href="{{ route('portfolio.index') }}"
                    class="portfolio-back-button"
                >

                    <i data-lucide="arrow-right"></i>

                    العودة إلى أعمالي

                </a>

            </div>

        </form>

    </section>


    {{-- ============================= --}}
    {{-- الصور الحالية --}}
    {{-- ============================= --}}

    <section class="portfolio-edit-card">

        <div class="portfolio-edit-heading">

            <h2>
                الصور الحالية
            </h2>

            <p>
                يمكنك استبدال الصورة أو حذفها نهائيًا.
            </p>

        </div>


        @if($portfolioItem->images->count())

            <div class="portfolio-current-images">

                @foreach($portfolioItem->images as $image)

                    <div class="portfolio-current-image">


                        {{-- الصورة الحالية --}}

                        <img
                            src="{{ asset('storage/' . $image->file_path) }}"
                            alt="{{ $image->alt_text ?? $portfolioItem->title_ar }}"
                        >


                        {{-- أزرار الصورة --}}

                        <div class="portfolio-image-actions">


                            {{-- ============================= --}}
                            {{-- استبدال الصورة --}}
                            {{-- ============================= --}}

                            <form
                                method="POST"
                                action="{{ route(
                                    'portfolio.images.replace',
                                    [
                                        'portfolioItem' => $portfolioItem,
                                        'image' => $image->id
                                    ]
                                ) }}"
                                enctype="multipart/form-data"
                                class="portfolio-replace-image"
                            >

                                @csrf

                                @method('PUT')


                                <input
                                    type="file"
                                    id="replace-image-{{ $image->id }}"
                                    name="image"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    required
                                    onchange="this.form.submit()"
                                >


                                <label
                                    for="replace-image-{{ $image->id }}"
                                    class="portfolio-replace-label"
                                >

                                    <i data-lucide="image-plus"></i>

                                    استبدال

                                </label>

                            </form>


                            {{-- ============================= --}}
                            {{-- حذف الصورة --}}
                            {{-- ============================= --}}

                            <div class="portfolio-delete-image">

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'portfolio.images.destroy',
                                        [
                                            'portfolioItem' => $portfolioItem,
                                            'image' => $image->id
                                        ]
                                    ) }}"
                                >

                                    @csrf

                                    @method('DELETE')


                                    <button
                                        type="submit"
                                        title="حذف الصورة"
                                        onclick="return confirm('هل أنت متأكد من حذف هذه الصورة؟')"
                                    >

                                        <i data-lucide="trash-2"></i>

                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="portfolio-no-current-images">
                لا توجد صور لهذا العمل حاليًا.
            </div>

        @endif

    </section>


</div>


<script>
    lucide.createIcons();
</script>

@endsection

