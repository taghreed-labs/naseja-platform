
@extends('layouts.frontend.user')

@section('title', 'تعديل الخدمة | NASEJA')

@section('content')

<style>
    .services-edit-page {
        width: 100%;
        max-width: 1100px;
        margin: 0 auto;
        padding: 35px 45px 70px;
        direction: rtl;
        box-sizing: border-box;
    }

    .services-edit-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .services-edit-header h1 {
        margin: 0 0 8px;
        font-size: 34px;
        font-weight: 800;
        color: #17152b;
    }

    .services-edit-header p {
        margin: 0;
        color: #77758a;
        font-size: 16px;
    }

    .services-edit-card {
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid #e8e5f5;
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 12px 35px rgba(72, 55, 160, 0.08);
    }

    .services-edit-card-header {
        margin-bottom: 28px;
    }

    .services-edit-card-header h2 {
        margin: 0 0 7px;
        font-size: 24px;
        font-weight: 800;
        color: #211d3a;
    }

    .services-edit-card-header p {
        margin: 0;
        color: #858296;
        font-size: 14px;
    }

    .services-edit-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
    }

    .services-edit-field {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .services-edit-field-full {
        grid-column: 1 / -1;
    }

    .services-edit-field label {
        font-size: 14px;
        font-weight: 700;
        color: #302c48;
    }

    .services-edit-field input,
    .services-edit-field select,
    .services-edit-field textarea {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #ddd9ec;
        border-radius: 12px;
        background: #faf9fe;
        padding: 13px 15px;
        font-family: inherit;
        font-size: 14px;
        color: #29263c;
        outline: none;
        transition: 0.2s ease;
    }

    .services-edit-field input,
    .services-edit-field select {
        height: 48px;
    }

    .services-edit-field textarea {
        min-height: 120px;
        resize: vertical;
        line-height: 1.8;
    }

    .services-edit-field input:focus,
    .services-edit-field select:focus,
    .services-edit-field textarea:focus {
        border-color: #6655df;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(102, 85, 223, 0.10);
    }

    .services-edit-field input::placeholder,
    .services-edit-field textarea::placeholder {
        color: #aaa7b8;
    }

    .services-edit-error {
        color: #dc3545;
        font-size: 12px;
        margin-top: 2px;
    }

    .services-edit-success {
        background: #ecfdf3;
        border: 1px solid #b7ebc9;
        color: #18794e;
        border-radius: 12px;
        padding: 13px 16px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .services-edit-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid #eeeaf7;
    }

    .services-edit-save {
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg, #5946d8, #7664ed);
        color: white;
        padding: 13px 28px;
        font-family: inherit;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(89, 70, 216, 0.22);
        transition: 0.2s ease;
    }

    .services-edit-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(89, 70, 216, 0.28);
    }

    .services-edit-cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        border: 1px solid #ddd9ec;
        border-radius: 12px;
        background: white;
        color: #5d5872;
        padding: 12px 25px;
        font-size: 14px;
        font-weight: 700;
        transition: 0.2s ease;
    }

    .services-edit-cancel:hover {
        border-color: #6655df;
        color: #6655df;
        background: #f8f7ff;
    }

    @media (max-width: 800px) {
        .services-edit-page {
            padding: 25px 20px 50px;
        }

        .services-edit-grid {
            grid-template-columns: 1fr;
        }

        .services-edit-field-full {
            grid-column: auto;
        }

        .services-edit-card {
            padding: 22px;
        }
    }
</style>


<div class="services-edit-page">

    {{-- عنوان الصفحة --}}
    <div class="services-edit-header">

        <h1>تعديل الخدمة</h1>

        <p>
            عدّل تفاصيل الخدمة ثم احفظ التغييرات.
        </p>

    </div>


    {{-- رسالة النجاح --}}
    @if(session('success'))

        <div class="services-edit-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- بطاقة التعديل --}}
    <section class="services-edit-card">

        <div class="services-edit-card-header">

            <h2>
                تعديل الخدمة
            </h2>

            <p>
                قم بتحديث معلومات الخدمة التي تقدمها.
            </p>

        </div>


        <form
            method="POST"
            action="{{ route('services.update', $service) }}"
        >

            @csrf
            @method('PUT')


            <div class="services-edit-grid">

                {{-- التصنيف --}}
                <div class="services-edit-field">

                    <label for="category_id">
                        تصنيف الخدمة
                    </label>

                    <select
                        id="category_id"
                        name="category_id"
                    >

                        <option value="">
                            اختر التصنيف
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(old('category_id', $service->category_id) == $category->id)
                            >
                                {{ $category->name_ar }}
                            </option>

                        @endforeach

                    </select>

                    @error('category_id')
                        <small class="services-edit-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- السعر --}}
                <div class="services-edit-field">

                    <label for="price">
                        المبلغ (اختياري؛ مطلوب للسعر الثابت أو «يبدأ من»)
                    </label>

                    <input
                        type="number"
                        id="price"
                        name="price"
                        min="0"
                        step="0.01"
                        value="{{ old('price', $service->price) }}"
                        placeholder="مثال: 5000"
                    >

                    @error('price')
                        <small class="services-edit-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- نوع السعر --}}
                <div class="services-edit-field">

                    <label for="price_type">
                        نوع السعر (اختياري)
                    </label>

                    <select
                        id="price_type"
                        name="price_type"
                    >

                        <option value="">
                            بدون سعر معلن
                        </option>

                        <option
                            value="ثابت"
                            @selected(old('price_type', $service->price_type) == 'ثابت')
                        >
                            سعر ثابت
                        </option>

                        <option
                            value="يبدأ من"
                            @selected(old('price_type', $service->price_type) == 'يبدأ من')
                        >
                            يبدأ من
                        </option>

                        <option
                            value="حسب الطلب"
                            @selected(old('price_type', $service->price_type) == 'حسب الطلب')
                        >
                            حسب الطلب
                        </option>

                    </select>

                    @error('price_type')
                        <small class="services-edit-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- مدة التنفيذ --}}
                <div class="services-edit-field">

                    <label for="duration">
                        مدة التنفيذ (اختياري)
                    </label>

                    <input
                        type="text"
                        id="duration"
                        name="duration"
                        value="{{ old('duration', $service->duration) }}"
                        placeholder="مثال: 3 أيام"
                    >

                    @error('duration')
                        <small class="services-edit-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- اسم الخدمة بالعربي --}}
                <div class="services-edit-field services-edit-field-full">

                    <label for="title_ar">
                        اسم الخدمة بالعربي
                    </label>

                    <input
                        type="text"
                        id="title_ar"
                        name="title_ar"
                        value="{{ old('title_ar', $service->title_ar) }}"
                        placeholder="مثال: تصميم شعار احترافي"
                    >

                    @error('title_ar')
                        <small class="services-edit-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- اسم الخدمة بالإنجليزي --}}
                <div class="services-edit-field services-edit-field-full">

                    <label for="title_en">
                        اسم الخدمة بالإنجليزي (اختياري)
                    </label>

                    <input
                        type="text"
                        id="title_en"
                        name="title_en"
                        value="{{ old('title_en', $service->title_en) }}"
                        placeholder="Example: Professional Logo Design"
                        dir="ltr"
                    >

                    @error('title_en')
                        <small class="services-edit-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- وصف الخدمة بالعربي --}}
                <div class="services-edit-field services-edit-field-full">

                    <label for="description_ar">
                        وصف الخدمة بالعربي (اختياري)
                    </label>

                    <textarea
                        id="description_ar"
                        name="description_ar"
                        rows="4"
                        placeholder="اكتب وصفًا واضحًا للخدمة التي تقدمها..."
                    >{{ old('description_ar', $service->description_ar) }}</textarea>

                    @error('description_ar')
                        <small class="services-edit-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- وصف الخدمة بالإنجليزي --}}
                <div class="services-edit-field services-edit-field-full">

                    <label for="description_en">
                        وصف الخدمة بالإنجليزي (اختياري)
                    </label>

                    <textarea
                        id="description_en"
                        name="description_en"
                        rows="4"
                        placeholder="Write a clear description of your service..."
                        dir="ltr"
                    >{{ old('description_en', $service->description_en) }}</textarea>

                    @error('description_en')
                        <small class="services-edit-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

            </div>


            {{-- أزرار الحفظ والإلغاء --}}
            <div class="services-edit-actions">

                <button
                    type="submit"
                    class="services-edit-save"
                >
                    حفظ التغييرات
                </button>

                <a
                    href="{{ route('services.index') }}"
                    class="services-edit-cancel"
                >
                    إلغاء
                </a>

            </div>

        </form>

    </section>

</div>

@endsection

