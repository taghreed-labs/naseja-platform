@extends('layouts.frontend.user')

@section('title', 'مهاراتي | NASEJA')

@section('content')

<style>

    /* =========================================
       أزرار المهارات
    ========================================= */

    .skill-actions {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-start !important;

        gap: 12px !important;
        margin-right: auto !important;
        margin-top: 0 !important;

        direction: rtl !important;
    }


    /* =========================================
       زر تعديل
    ========================================= */

    .skill-edit-button {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;

        width: 100px !important;
        height: 44px !important;

        padding: 0 !important;
        margin: 0 !important;

        background: #22a447 !important;
        border: 1px solid #22a447 !important;
        border-radius: 10px !important;

        color: #000000 !important;

        font-family: inherit !important;
        font-size: 14px !important;
        font-weight: 700 !important;

        text-decoration: none !important;
        cursor: pointer !important;

        box-sizing: border-box !important;

        transition: 0.2s ease !important;
    }

    .skill-edit-button:hover {
        background: #198f3b !important;
        border-color: #198f3b !important;
        color: #000000 !important;

        transform: translateY(-1px) !important;
    }


    /* =========================================
       زر حذف
    ========================================= */

    .skill-delete-button {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;

        width: 100px !important;
        height: 44px !important;

        padding: 0 !important;
        margin: 0 !important;

        background: #e53935 !important;
        border: 1px solid #e53935 !important;
        border-radius: 10px !important;

        color: #000000 !important;

        font-family: inherit !important;
        font-size: 14px !important;
        font-weight: 700 !important;

        cursor: pointer !important;

        box-sizing: border-box !important;

        transition: 0.2s ease !important;
    }

    .skill-delete-button:hover {
        background: #c62828 !important;
        border-color: #c62828 !important;
        color: #000000 !important;

        transform: translateY(-1px) !important;
    }


    .skill-actions form {
        margin: 0 !important;
        padding: 0 !important;
    }


    /* =========================================
       رسالة النجاح
    ========================================= */

    .skills-success {
        display: block !important;

        width: fit-content !important;
        min-width: 280px !important;

        margin: 25px auto 20px !important;
        padding: 14px 24px !important;

        background: #eaf8ee !important;
        border: 1px solid #b7e4c2 !important;
        border-radius: 10px !important;

        color: #166534 !important;

        font-family: inherit !important;
        font-size: 14px !important;
        font-weight: 600 !important;

        text-align: center !important;

        box-sizing: border-box !important;
    }


    /* =========================================
       تنبيه عدم وجود خدمات
    ========================================= */

    .skills-service-warning {
        margin-bottom: 20px !important;
        padding: 16px 20px !important;

        border: 1px solid #fde68a !important;
        border-radius: 12px !important;

        background: #fffbeb !important;
        color: #92400e !important;

        font-size: 13px !important;
        font-weight: 600 !important;

        text-align: center !important;
    }


    /* =========================================
       الشاشات الصغيرة
    ========================================= */

    @media (max-width: 600px) {

        .skill-actions {
            width: 100% !important;
            margin-top: 15px !important;
            justify-content: flex-start !important;
        }

        .skill-edit-button,
        .skill-delete-button {
            width: 100px !important;
        }
    }

</style>


<div class="skills-page">


{{-- ============================= --}}
{{-- عنوان الصفحة --}}
{{-- ============================= --}}

<div class="skills-title">

    <div style="text-align: center; margin-top: -50px;">

        <h1>مهاراتي</h1>

        <p>
            أضف مهاراتك ومستوى خبرتك حتى يستطيع الآخرون التعرف على قدراتك.
        </p>

    </div>

</div>



{{-- ============================= --}}
{{-- رسالة النجاح --}}
{{-- ============================= --}}

@if(session('success'))

    <div class="skills-success">

        {{ session('success') }}

    </div>

@endif



{{-- ============================= --}}
{{-- حالة عدم وجود خدمة --}}
{{-- ============================= --}}

@if($categoryIds->isEmpty())

    <div class="skills-service-warning">

        يجب عليك أولًا إضافة خدمة من صفحة
        <strong>خدماتي</strong>
        حتى تظهر لك المهارات المرتبطة بمجالك.

    </div>

@endif



{{-- ============================= --}}
{{-- إضافة مهارة --}}
{{-- ============================= --}}

<section class="skills-card">

    <div class="skills-card-heading">

        <h2>
            إضافة مهارة
        </h2>

        <p>
            اختر المهارة وحدد مستوى خبرتك فيها.
        </p>

    </div>


    <form
        method="POST"
        action="{{ route('skills.store') }}"
        class="skills-form"
    >

        @csrf


        <div class="skills-form-grid">


            {{-- =============================
                 المهارة
            ============================== --}}

            <div class="skills-field">

                <label for="skill_id">
                    المهارة
                </label>


                <select
                    id="skill_id"
                    name="skill_id"
                    {{ $skills->isEmpty() ? 'disabled' : '' }}
                >

                    <option value="">

                        @if($skills->isEmpty())

                            لا توجد مهارات متاحة

                        @else

                            اختر المهارة

                        @endif

                    </option>


                    @foreach($skills as $skill)

                        <option
                            value="{{ $skill->id }}"
                            @selected(old('skill_id') == $skill->id)
                        >

                            {{ $skill->name_ar }}

                            @if($skill->category)

                                — {{ $skill->category->name_ar }}

                            @endif

                        </option>

                    @endforeach

                </select>


                @error('skill_id')

                    <small class="skills-error">

                        {{ $message }}

                    </small>

                @enderror

            </div>



            {{-- =============================
                 مستوى الخبرة
            ============================== --}}

            <div class="skills-field">

                <label for="level">

                    مستوى الخبرة

                </label>


                <select
                    id="level"
                    name="level"
                >

                    <option value="">

                        اختر المستوى

                    </option>


                    <option
                        value="مبتدئ"
                        @selected(old('level') == 'مبتدئ')
                    >

                        مبتدئ

                    </option>


                    <option
                        value="متوسط"
                        @selected(old('level') == 'متوسط')
                    >

                        متوسط

                    </option>


                    <option
                        value="متقدم"
                        @selected(old('level') == 'متقدم')
                    >

                        متقدم

                    </option>


                    <option
                        value="خبير"
                        @selected(old('level') == 'خبير')
                    >

                        خبير

                    </option>

                </select>


                @error('level')

                    <small class="skills-error">

                        {{ $message }}

                    </small>

                @enderror

            </div>



            {{-- =============================
                 سنوات الخبرة
            ============================== --}}

            <div class="skills-field">

                <label for="years_experience">

                    سنوات الخبرة

                </label>


                <input
                    type="number"
                    id="years_experience"
                    name="years_experience"
                    min="0"
                    max="100"
                    value="{{ old('years_experience') }}"
                    placeholder="مثال: 3"
                >


                @error('years_experience')

                    <small class="skills-error">

                        {{ $message }}

                    </small>

                @enderror

            </div>

        </div>



        {{-- =============================
             زر إضافة المهارة
        ============================== --}}

        <button
            type="submit"
            class="skills-add-button"
            {{ $skills->isEmpty() ? 'disabled' : '' }}
        >

            <i data-lucide="plus"></i>

            إضافة المهارة

        </button>

    </form>

</section>



{{-- ============================= --}}
{{-- مهارات المستخدم الحالية --}}
{{-- ============================= --}}

<section class="skills-card">

    <div class="skills-card-heading">

        <h2>
            مهاراتي الحالية
        </h2>

        <p>
            المهارات التي أضفتها إلى ملفك الشخصي.
        </p>

    </div>


    @forelse($userSkills as $userSkill)

        <div class="user-skill-item">


            {{-- =============================
                 معلومات المهارة
            ============================== --}}

            <div class="user-skill-info">

                <h3>

                    <i data-lucide="sparkles"></i>

                    {{ $userSkill->skill->name_ar }}

                </h3>


                {{-- التصنيف التابع له --}}
                @if($userSkill->skill->category)

                    <small>

                        المجال:

                        {{ $userSkill->skill->category->name_ar }}

                    </small>

                @endif


                <span>

                    المستوى:

                    {{ $userSkill->level }}

                </span>


                @if($userSkill->years_experience !== null)

                    <small>

                        <i data-lucide="clock-3"></i>

                        {{ $userSkill->years_experience }}

                        سنوات خبرة

                    </small>

                @endif

            </div>



            {{-- =============================
                 أزرار المهارة
            ============================== --}}

            <div class="skill-actions">


                {{-- تعديل --}}

                <a
                    href="{{ route('skills.edit', $userSkill) }}"
                    class="skill-edit-button"
                >

                    تعديل

                </a>



                {{-- حذف --}}

                <form
                    method="POST"
                    action="{{ route('skills.destroy', $userSkill) }}"
                >

                    @csrf

                    @method('DELETE')


                    <button
                        type="submit"
                        class="skill-delete-button"
                        onclick="return confirm('هل أنت متأكد من حذف هذه المهارة؟')"
                    >

                        حذف

                    </button>

                </form>

            </div>

        </div>


    @empty


        {{-- =============================
             لا توجد مهارات
        ============================== --}}

        <div class="skills-empty">

            <i data-lucide="sparkles"></i>


            <strong>

                لم تضف أي مهارات بعد

            </strong>


            <p>

                @if($categoryIds->isEmpty())

                    أضف خدمة أولًا من صفحة خدماتي،
                    ثم ستظهر لك المهارات المناسبة لمجالك.

                @else

                    أضف أول مهارة لك من النموذج أعلاه.

                @endif

            </p>

        </div>


    @endforelse

</section>


</div>

@endsection