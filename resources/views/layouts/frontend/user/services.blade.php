@extends('layouts.frontend.user')

@section('title', 'خدماتي | NASEJA')

@section('content')

<style>
    /* =========================
       الصفحة كاملة
    ========================= */

    .services-page {
        width: 100%;
        max-width: 1250px;
        margin: 0 auto;
        padding: 45px 45px 80px;
        box-sizing: border-box;
    }

    /* =========================
       عنوان الصفحة
    ========================= */

    .services-title {
        text-align: center;
        margin-top: -25px;
        margin-bottom: 35px;
    }

    .services-title h1 {
        margin: 0;
        font-size: 38px;
        font-weight: 800;
        color: #17152d;
    }

    .services-title p {
        margin: 10px 0 0;
        color: #77758a;
        font-size: 16px;
    }

    /* =========================
       رسالة النجاح
    ========================= */

    .services-success {
        max-width: 1000px;
        margin: 0 auto 25px;
        padding: 15px 20px;
        border-radius: 14px;
        background: #ecfdf5;
        color: #087443;
        border: 1px solid #b7efd4;
        text-align: center;
        font-weight: 600;
    }

    /* =========================
       الكروت
    ========================= */

    .services-card {
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid #e9e7f4;
        border-radius: 24px;
        padding: 32px;
        margin-bottom: 30px;
        box-shadow: 0 12px 35px rgba(62, 48, 130, 0.08);
    }

    .services-card-heading {
        margin-bottom: 25px;
        text-align: right;
    }

    .services-card-heading h2 {
        margin: 0 0 7px;
        font-size: 24px;
        font-weight: 800;
        color: #211d3b;
    }

    .services-card-heading p {
        margin: 0;
        color: #858297;
        font-size: 14px;
    }

    /* =========================
       النموذج
    ========================= */

    .services-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
    }

    .services-field {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .services-field-full {
        grid-column: 1 / -1;
    }

    .services-field label {
        font-size: 14px;
        font-weight: 700;
        color: #39354f;
    }

    .services-field input,
    .services-field select,
    .services-field textarea {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #e2e0ed;
        border-radius: 12px;
        background: #fafaff;
        padding: 13px 15px;
        font-family: inherit;
        font-size: 14px;
        color: #29263d;
        outline: none;
        transition: 0.2s ease;
    }

    .services-field input,
    .services-field select {
        height: 48px;
    }

    .services-field textarea {
        min-height: 125px;
        resize: vertical;
        line-height: 1.8;
    }

    .services-field input:focus,
    .services-field select:focus,
    .services-field textarea:focus {
        border-color: #6652df;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(102, 82, 223, 0.09);
    }

    .services-field input::placeholder,
    .services-field textarea::placeholder {
        color: #aaa7b8;
    }

    /* =========================
       أخطاء التحقق
    ========================= */

    .services-error {
        color: #dc3545;
        font-size: 12px;
        font-weight: 600;
    }

    /* =========================
       زر الإضافة
    ========================= */

    .services-add-button {
        display: block;
        margin: 28px 0 0 auto;
        border: none;
        border-radius: 12px;
        padding: 13px 30px;
        background: linear-gradient(135deg, #5d48d8, #7560eb);
        color: #fff;
        font-family: inherit;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(93, 72, 216, 0.22);
        transition: 0.2s ease;
    }

    .services-add-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(93, 72, 216, 0.3);
    }

    /* =========================
       الخدمة الموجودة
    ========================= */

    .user-service-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 25px;
        padding: 24px;
        margin-top: 18px;
        border: 1px solid #eceaf5;
        border-radius: 18px;
        background: #fbfbff;
        transition: 0.2s ease;
    }

    .user-service-item:hover {
        border-color: #d9d3fa;
        box-shadow: 0 8px 22px rgba(70, 53, 150, 0.07);
        transform: translateY(-1px);
    }

    .user-service-info {
        flex: 1;
        min-width: 0;
    }

    .user-service-info h3 {
        margin: 0 0 9px;
        font-size: 19px;
        font-weight: 800;
        color: #27233f;
    }

    .user-service-info p {
        margin: 0 0 16px;
        color: #777489;
        font-size: 14px;
        line-height: 1.8;
    }

    .user-service-info span {
        display: inline-block;
        margin-left: 8px;
        margin-bottom: 7px;
        padding: 6px 10px;
        border-radius: 8px;
        background: #f0edff;
        color: #5746b7;
        font-size: 12px;
        font-weight: 600;
    }

    /* =========================
       أزرار الخدمة
    ========================= */

    .service-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .service-actions form {
        margin: 0;
    }

    .service-edit-button,
    .service-delete-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 75px;
        height: 42px;
        padding: 0 16px;
        border-radius: 10px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        box-sizing: border-box;
        transition: 0.2s ease;
    }

    .service-edit-button {
        background: #eeeaff;
        color: #5845c6;
        border: 1px solid #ddd7ff;
    }

    .service-edit-button:hover {
        background: #e3ddff;
    }

    .service-delete-button {
        background: #fff0f1;
        color: #d83b4b;
        border: 1px solid #ffd2d7;
    }

    .service-delete-button:hover {
        background: #ffe3e6;
    }

    /* =========================
       لا توجد خدمات
    ========================= */

    .services-empty {
        text-align: center;
        padding: 50px 20px;
        border: 1px dashed #dcd8eb;
        border-radius: 18px;
        background: #faf9ff;
    }

    .services-empty strong {
        display: block;
        margin-bottom: 8px;
        font-size: 18px;
        color: #363149;
    }

    .services-empty p {
        margin: 0;
        color: #888499;
        font-size: 14px;
    }

    /* =========================
       الجوال
    ========================= */

    @media (max-width: 900px) {

        .services-page {
            padding: 30px 20px 60px;
        }

        .services-form-grid {
            grid-template-columns: 1fr;
        }

        .services-field-full {
            grid-column: auto;
        }

        .user-service-item {
            flex-direction: column;
            align-items: stretch;
        }

        .service-actions {
            justify-content: flex-start;
        }
    }

    @media (max-width: 600px) {

        .services-page {
            padding: 25px 14px 50px;
        }

        .services-title h1 {
            font-size: 30px;
        }

        .services-card {
            padding: 20px;
            border-radius: 18px;
        }

        .services-add-button {
            width: 100%;
        }

        .service-actions {
            width: 100%;
        }

        .service-edit-button,
        .service-delete-button {
            flex: 1;
        }
    }
</style>


<div class="services-page">

    {{-- عنوان الصفحة --}}
    <div class="services-title">

        <h1>خدماتي</h1>

        <p>
            أضف خدماتك حتى يستطيع الآخرون التعرف على ما تقدمه.
        </p>

    </div>


    {{-- رسالة النجاح --}}
    @if(session('success'))

        <div class="services-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- =============================
         إضافة خدمة
    ============================== --}}

    <section class="services-card">

        <div class="services-card-heading">

            <h2>إضافة خدمة</h2>

            <p>
                أضف تفاصيل الخدمة التي تقدمها ليتمكن الآخرون من معرفتها.
            </p>

        </div>


        <form
            method="POST"
            action="{{ route('services.store') }}"
            class="services-form"
        >

            @csrf

            <div class="services-form-grid">

                {{-- التصنيف --}}
                <div class="services-field">

                    <label for="category_id">
                        تصنيف الخدمة
                    </label>

                    <select id="category_id" name="category_id">
                    

                        <option value="">
                            اختر التصنيف
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(old('category_id') == $category->id)
                            >
                                {{ $category->name_ar }}
                            </option>

                        @endforeach

                    </select>

                    @error('category_id')
                        <small class="services-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- السعر --}}
                <div class="services-field">

                    <label for="price">
                        المبلغ (اختياري؛ مطلوب للسعر الثابت أو «يبدأ من»)
                    </label>

                    <input
                        type="number"
                        id="price"
                        name="price"
                        min="0"
                        step="0.01"
                        value="{{ old('price') }}"
                        placeholder="مثال: 5000"
                    >

                    @error('price')
                        <small class="services-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- نوع السعر --}}
                <div class="services-field">

                    <label for="price_type">
                        نوع السعر (اختياري)
                    </label>

                    <select id="price_type" name="price_type">

                        <option value="">
                            بدون سعر معلن
                        </option>

                        <option
                            value="ثابت"
                            @selected(old('price_type') == 'ثابت')
                        >
                            سعر ثابت
                        </option>

                        <option
                            value="يبدأ من"
                            @selected(old('price_type') == 'يبدأ من')
                        >
                            يبدأ من
                        </option>

                        <option
                            value="حسب الطلب"
                            @selected(old('price_type') == 'حسب الطلب')
                        >
                            حسب الطلب
                        </option>

                    </select>

                    @error('price_type')
                        <small class="services-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- مدة التنفيذ --}}
                <div class="services-field">

                    <label for="duration">
                        مدة التنفيذ (اختياري)
                    </label>

                    <input
                        type="text"
                        id="duration"
                        name="duration"
                        value="{{ old('duration') }}"
                        placeholder="مثال: 3 أيام"
                    >

                    @error('duration')
                        <small class="services-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- اسم الخدمة بالعربي --}}
                <div class="services-field services-field-full">

                    <label for="title_ar">
                        اسم الخدمة بالعربي
                    </label>

                    <input
                        type="text"
                        id="title_ar"
                        name="title_ar"
                        value="{{ old('title_ar') }}"
                        placeholder="مثال: تصميم شعار احترافي"
                    >

                    @error('title_ar')
                        <small class="services-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- اسم الخدمة بالإنجليزي --}}
                <div class="services-field services-field-full">

                    <label for="title_en">
                        اسم الخدمة بالإنجليزي (اختياري)
                    </label>

                    <input
                        type="text"
                        id="title_en"
                        name="title_en"
                        value="{{ old('title_en') }}"
                        placeholder="Example: Professional Logo Design"
                        dir="ltr"
                    >

                    @error('title_en')
                        <small class="services-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- وصف الخدمة بالعربي --}}
                <div class="services-field services-field-full">

                    <label for="description_ar">
                        وصف الخدمة بالعربي (اختياري)
                    </label>

                    <textarea
                        id="description_ar"
                        name="description_ar"
                        rows="4"
                        placeholder="اكتب وصفًا واضحًا للخدمة التي تقدمها..."
                    >{{ old('description_ar') }}</textarea>

                    @error('description_ar')
                        <small class="services-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- وصف الخدمة بالإنجليزي --}}
                <div class="services-field services-field-full">

                    <label for="description_en">
                        وصف الخدمة بالإنجليزي (اختياري)
                    </label>

                    <textarea
                        id="description_en"
                        name="description_en"
                        rows="4"
                        placeholder="Write a clear description of your service..."
                        dir="ltr"
                    >{{ old('description_en') }}</textarea>

                    @error('description_en')
                        <small class="services-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

            </div>


            <button
                type="submit"
                class="services-add-button"
            >
                إضافة الخدمة
            </button>

        </form>

    </section>


    {{-- =============================
         الخدمات الحالية
    ============================== --}}

    <section class="services-card">

        <div class="services-card-heading">

            <h2>خدماتي الحالية</h2>

            <p>
                الخدمات التي أضفتها إلى ملفك الشخصي.
            </p>

        </div>


        @forelse($services as $service)

            <div class="user-service-item">

                <div class="user-service-info">

                    <h3>
                        {{ $service->title_ar }}
                    </h3>

                    @if(filled($service->description_ar) || filled($service->description_en))
                        <p>{{ $service->description_ar ?: $service->description_en }}</p>
                    @endif

                    <span>
                        التصنيف:
                        {{ $service->category->name_ar }}
                    </span>

                    @if($service->price_type === 'حسب الطلب')
                        <span>السعر حسب الطلب</span>
                    @elseif($service->price !== null)
                        <span>{{ $service->price_type === 'يبدأ من' ? 'يبدأ من' : 'السعر:' }} {{ number_format((float) $service->price, 0) }} ريال</span>
                    @endif

                    @if(filled($service->duration))
                        <span>مدة التنفيذ: {{ $service->duration }}</span>
                    @endif

                </div>


                <div class="service-actions">

                    <a
                        href="{{ route('services.edit', $service) }}"
                        class="service-edit-button"
                    >
                        تعديل
                    </a>


                    <form
                        method="POST"
                        action="{{ route('services.destroy', $service) }}"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="service-delete-button"
                            onclick="return confirm('هل أنت متأكد من حذف هذه الخدمة؟')"
                        >
                            حذف
                        </button>

                    </form>

                </div>

            </div>

        @empty

            <div class="services-empty">

                <strong>
                    لم تضف أي خدمات بعد
                </strong>

                <p>
                    أضف أول خدمة لك من النموذج أعلاه.
                </p>

            </div>

        @endforelse

    </section>

</div>

@endsection
