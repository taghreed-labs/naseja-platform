@extends('layouts.frontend.user')

@section('title', 'أعمالي | NASEJA')

@section('content')

<style>
    .portfolio-page {
        max-width: 1000px;
        margin: 0 auto;
        padding: 10px 20px 40px;
    }

    .portfolio-title {
        text-align: center;
        margin-bottom: 25px;
    }

    .portfolio-title h1 {
        margin: 0 0 8px;
        color: #18182d;
        font-size: 34px;
        font-weight: 800;
    }

    .portfolio-title p {
        margin: 0;
        color: #85859a;
        font-size: 13px;
    }

    .portfolio-success {
        margin-bottom: 20px;
        padding: 13px 17px;
        border-radius: 12px;
        background: #e9fff8;
        border: 1px solid #b8f1df;
        color: #08785f;
        font-size: 13px;
        font-weight: 700;
    }

    .portfolio-errors {
        margin-bottom: 20px;
        padding: 13px 17px;
        border-radius: 12px;
        background: #fff1f1;
        border: 1px solid #ffd0d0;
        color: #c62828;
        font-size: 13px;
        font-weight: 600;
    }

    .portfolio-errors div {
        margin-bottom: 4px;
    }

    .portfolio-card {
        margin-bottom: 22px;
        padding: 30px;
        border-radius: 22px;
        background: rgba(255,255,255,.96);
        border: 1px solid #eeeef5;
        box-shadow: 0 20px 55px rgba(65,54,170,.10);
    }

    .portfolio-card-heading {
        margin-bottom: 22px;
    }

    .portfolio-card-heading h2 {
        margin: 0 0 5px;
        color: #18182d;
        font-size: 21px;
        font-weight: 800;
    }

    .portfolio-card-heading p {
        margin: 0;
        color: #85859a;
        font-size: 12px;
    }

    .portfolio-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .portfolio-field-full {
        grid-column: 1 / -1;
    }

    .portfolio-field label {
        display: block;
        margin-bottom: 7px;
        color: #303047;
        font-size: 12px;
        font-weight: 700;
    }

    .portfolio-field input,
    .portfolio-field textarea {
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

    .portfolio-field input {
        height: 48px;
        padding: 0 13px;
    }

    .portfolio-field textarea {
        padding: 13px;
        resize: vertical;
    }

    .portfolio-field input:focus,
    .portfolio-field textarea:focus {
        background: white;
        border-color: #6657e8;
        box-shadow: 0 0 0 4px rgba(102,87,232,.08);
    }

    .portfolio-field input[type="file"] {
        height: auto;
        padding: 13px;
        cursor: pointer;
    }

    .portfolio-help {
        display: block;
        margin-top: 7px;
        color: #85859a;
        font-size: 11px;
    }

    .portfolio-add-button {
        height: 48px;
        margin-top: 20px;
        padding: 0 25px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: none;
        border-radius: 12px;
        color: white;
        background: linear-gradient(135deg, #6657e8, #5142d4);
        font-family: inherit;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(91,75,219,.18);
        transition: .2s ease;
    }

    .portfolio-add-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 25px rgba(91,75,219,.25);
    }

    .portfolio-item {
        display: flex;
        gap: 25px;
        margin-bottom: 18px;
        padding: 18px;
        border: 1px solid #eeeef5;
        border-radius: 18px;
        background: #ffffff;
        transition: .2s ease;
    }

    .portfolio-item:last-child {
        margin-bottom: 0;
    }

    .portfolio-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(65,54,170,.08);
    }

    .portfolio-images {
        width: 330px;
        flex-shrink: 0;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
        align-content: start;
    }

    .portfolio-image-wrapper {
        width: 100%;
        height: 150px;
        overflow: hidden;
        border-radius: 14px;
        background: #f4f3fa;
    }

    .portfolio-image {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        transition: transform .3s ease;
    }

    .portfolio-image-wrapper:hover .portfolio-image {
        transform: scale(1.04);
    }

    .portfolio-no-image {
        width: 100%;
        min-height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: #f5f4fa;
        color: #85859a;
        font-size: 12px;
    }

    .portfolio-info {
        flex: 1;
        min-width: 0;
        padding: 5px 0;
    }

    .portfolio-info h3 {
        margin: 0 0 10px;
        color: #18182d;
        font-size: 20px;
        font-weight: 800;
    }

    .portfolio-info p {
        margin: 0 0 13px;
        color: #85859a;
        font-size: 13px;
        line-height: 1.8;
    }

    .portfolio-date {
        display: block;
        margin-bottom: 18px;
        color: #6657e8;
        font-size: 12px;
        font-weight: 700;
    }

    .portfolio-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .portfolio-edit-button,
    .portfolio-delete-button {
        height: 40px;
        min-width: 85px;
        padding: 0 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-family: inherit;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        box-sizing: border-box;
        transition: .2s ease;
    }

    .portfolio-edit-button {
        border: 1px solid #6657e8;
        background: #6657e8;
        color: white;
    }

    .portfolio-edit-button:hover {
        background: #5142d4;
        transform: translateY(-1px);
    }

    .portfolio-delete-button {
        border: 1px solid #e4e1e8;
        background: #fff;
        color: #c62828;
    }

    .portfolio-delete-button:hover {
        background: #fff1f1;
        border-color: #ffcaca;
        transform: translateY(-1px);
    }

    .portfolio-empty {
        padding: 50px 20px;
        text-align: center;
        border: 1px dashed #dddbea;
        border-radius: 18px;
        background: #fafaff;
    }

    .portfolio-empty i {
        width: 40px;
        height: 40px;
        margin-bottom: 12px;
        color: #6657e8;
    }

    .portfolio-empty strong {
        display: block;
        margin-bottom: 7px;
        color: #303047;
        font-size: 15px;
    }

    .portfolio-empty p {
        margin: 0;
        color: #85859a;
        font-size: 12px;
    }

    @media (max-width: 800px) {
        .portfolio-form-grid {
            grid-template-columns: 1fr;
        }

        .portfolio-field-full {
            grid-column: auto;
        }

        .portfolio-item {
            flex-direction: column;
        }

        .portfolio-images {
            width: 100%;
        }
    }

    @media (max-width: 600px) {
        .portfolio-card {
            padding: 20px;
        }

        .portfolio-images {
            grid-template-columns: 1fr 1fr;
        }

        .portfolio-image-wrapper {
            height: 130px;
        }

        .portfolio-actions {
            flex-wrap: wrap;
        }

        .portfolio-edit-button,
        .portfolio-delete-button {
            flex: 1;
        }
    }
</style>

<div class="portfolio-page">

```
<div class="portfolio-title">
    <h1>أعمالي</h1>

    <p>
        أضف أعمالك السابقة مع صورها حتى يستطيع الآخرون التعرف على خبرتك وإبداعك.
    </p>
</div>


@if(session('success'))
    <div class="portfolio-success">
        {{ session('success') }}
    </div>
@endif


@if($errors->any())
    <div class="portfolio-errors">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif


{{-- إضافة عمل --}}
<section class="portfolio-card">

    <div class="portfolio-card-heading">
        <h2>إضافة عمل جديد</h2>

        <p>
            أضف معلومات العمل وارفع صورة أو أكثر له.
        </p>
    </div>


    <form
        method="POST"
        action="{{ route('portfolio.store') }}"
        enctype="multipart/form-data"
    >

        @csrf

        <div class="portfolio-form-grid">

            <div class="portfolio-field">
                <label for="title_ar">
                    عنوان العمل بالعربي
                </label>

                <input
                    type="text"
                    id="title_ar"
                    name="title_ar"
                    required
                    value="{{ old('title_ar') }}"
                    placeholder="مثال: تصميم فستان زفاف"
                >
            </div>


            <div class="portfolio-field">
                <label for="title_en">
                    عنوان العمل بالإنجليزي (اختياري)
                </label>

                <input
                    type="text"
                    id="title_en"
                    name="title_en"
                    value="{{ old('title_en') }}"
                    placeholder="Example: Wedding Dress Design"
                    dir="ltr"
                >
            </div>


            <div class="portfolio-field">
                <label for="work_date">
                    تاريخ العمل (اختياري)
                </label>

                <input
                    type="date"
                    id="work_date"
                    name="work_date"
                    value="{{ old('work_date') }}"
                >
            </div>


            <div class="portfolio-field portfolio-field-full">
                <label for="description_ar">
                    وصف العمل بالعربي (اختياري)
                </label>

                <textarea
                    id="description_ar"
                    name="description_ar"
                    rows="4"
                    placeholder="اكتب وصفًا مختصرًا عن العمل..."
                >{{ old('description_ar') }}</textarea>
            </div>


            <div class="portfolio-field portfolio-field-full">
                <label for="description_en">
                    وصف العمل بالإنجليزي (اختياري)
                </label>

                <textarea
                    id="description_en"
                    name="description_en"
                    rows="4"
                    placeholder="Write a short description about this work..."
                    dir="ltr"
                >{{ old('description_en') }}</textarea>
            </div>


            <div class="portfolio-field portfolio-field-full">
                <label for="images">
                    صور العمل (صورة واحدة على الأقل)
                </label>

                <input
                    type="file"
                    id="images"
                    name="images[]"
                    accept=".jpg,.jpeg,.png,.webp"
                    multiple
                    required
                >

                <small class="portfolio-help">
                    يمكنك اختيار أكثر من صورة — JPG / JPEG / PNG / WEBP
                </small>
            </div>

        </div>


        <button
            type="submit"
            class="portfolio-add-button"
        >
            <i data-lucide="plus"></i>
            إضافة العمل
        </button>

    </form>

</section>


{{-- الأعمال الحالية --}}
<section class="portfolio-card">

    <div class="portfolio-card-heading">

        <h2>
            أعمالي الحالية
        </h2>

        <p>
            الأعمال التي أضفتها إلى ملفك الشخصي.
        </p>

    </div>


    @forelse($portfolioItems as $portfolioItem)

        <div class="portfolio-item">

            <div class="portfolio-images">

                @forelse($portfolioItem->images as $image)

                    <div class="portfolio-image-wrapper">

                        <img
                            src="{{ asset('storage/' . $image->file_path) }}"
                            alt="{{ $image->alt_text ?? $portfolioItem->title_ar }}"
                            class="portfolio-image"
                        >

                    </div>

                @empty

                    <div class="portfolio-no-image">
                        لا توجد صورة
                    </div>

                @endforelse

            </div>


            <div class="portfolio-info">

                <h3>
                    {{ $portfolioItem->title_ar }}
                </h3>


                @if($portfolioItem->description_ar)

                    <p>
                        {{ $portfolioItem->description_ar }}
                    </p>

                @endif


                @if($portfolioItem->work_date)

                    <span class="portfolio-date">
                        تاريخ العمل:
                        {{ $portfolioItem->work_date->format('Y-m-d') }}
                    </span>

                @endif


                <div class="portfolio-actions">

                    <a
                        href="{{ route('portfolio.edit', $portfolioItem) }}"
                        class="portfolio-edit-button"
                    >
                        تعديل
                    </a>


                    <form
                        method="POST"
                        action="{{ route('portfolio.destroy', $portfolioItem) }}"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="portfolio-delete-button"
                            onclick="return confirm('هل أنت متأكد من حذف هذا العمل وجميع صوره؟')"
                        >
                            حذف
                        </button>

                    </form>

                </div>

            </div>

        </div>

    @empty

        <div class="portfolio-empty">

            <i data-lucide="images"></i>

            <strong>
                لم تضف أي أعمال بعد
            </strong>

            <p>
                أضف أول عمل لك من النموذج أعلاه.
            </p>

        </div>

    @endforelse

</section>


</div>

@endsection
