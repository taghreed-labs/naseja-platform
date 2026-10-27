@extends('layouts.frontend.user')

@section('title', 'تعديل المهارة | NASEJA')

@section('content')

<style>
    /* ================================
       أزرار تعديل المهارة
    ================================= */

    .skill-edit-actions {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-start !important;
        gap: 12px !important;
        margin-top: 25px !important;
        direction: rtl !important;
    }

    /* حفظ التغييرات */
    .skill-save-button {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;

        width: 150px !important;
        height: 46px !important;

        padding: 0 !important;
        margin: 0 !important;

        background: #22a447 !important;
        border: 1px solid #22a447 !important;
        border-radius: 10px !important;

        color: #000000 !important;

        font-family: inherit !important;
        font-size: 14px !important;
        font-weight: 700 !important;

        cursor: pointer !important;
        box-sizing: border-box !important;

        text-decoration: none !important;

        transition: 0.2s ease !important;
    }

    .skill-save-button:hover {
        background: #198f3b !important;
        border-color: #198f3b !important;
        color: #000000 !important;
    }

    .skill-save-button i {
        width: 17px !important;
        height: 17px !important;
        margin-left: 8px !important;
        color: #000000 !important;
    }


    /* إلغاء */
    .skill-cancel-button {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;

        width: 120px !important;
        height: 46px !important;

        padding: 0 !important;
        margin: 0 !important;

        background: #e53935 !important;
        border: 1px solid #e53935 !important;
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

    .skill-cancel-button:hover {
        background: #c62828 !important;
        border-color: #c62828 !important;
        color: #000000 !important;
    }


    /* إخفاء الأيقونة الفارغة الموجودة في زر الإلغاء */
    .skill-cancel-button i {
        display: none !important;
    }


    /* الشاشات الصغيرة */
    @media (max-width: 600px) {

        .skill-edit-actions {
            width: 100% !important;
            flex-direction: row !important;
            gap: 10px !important;
        }

        .skill-save-button,
        .skill-cancel-button {
            width: auto !important;
            flex: 1 !important;
        }
    }
</style>

<div class="skills-page">

```
{{-- ============================= --}}
{{-- عنوان الصفحة --}}
{{-- ============================= --}}

<div class="skills-title">

    <div style="text-align: center; margin-top: -30px;">

        <h1>تعديل المهارة</h1>

        <p>
            عدّل مهارتك ومستوى خبرتك ثم احفظ التغييرات.
        </p>

    </div>

</div>


{{-- ============================= --}}
{{-- بطاقة التعديل --}}
{{-- ============================= --}}

<section class="skills-card">

    <div class="skills-card-heading">

        <h2>
            تعديل المهارة
        </h2>

        <p>
            يمكنك تغيير المهارة أو مستوى الخبرة أو سنوات الخبرة.
        </p>

    </div>


    <form
        method="POST"
        action="{{ route('skills.update', $userSkill) }}"
        class="skills-form"
    >

        @csrf

        @method('PUT')


        {{-- ============================= --}}
        {{-- الحقول --}}
        {{-- ============================= --}}

        <div class="skills-form-grid">


            {{-- المهارة --}}

            <div class="skills-field">

                <label for="skill_id">
                    المهارة
                </label>

                <select
                    id="skill_id"
                    name="skill_id"
                >

                    <option value="">
                        اختر المهارة
                    </option>

                    @foreach($skills as $skill)

                        <option
                            value="{{ $skill->id }}"
                            @selected(old('skill_id', $userSkill->skill_id) == $skill->id)
                        >
                            {{ $skill->name_ar }}
                        </option>

                    @endforeach

                </select>


                @error('skill_id')

                    <small class="skills-error">
                        {{ $message }}
                    </small>

                @enderror

            </div>



            {{-- مستوى الخبرة --}}

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
                        @selected(old('level', $userSkill->level) == 'مبتدئ')
                    >
                        مبتدئ
                    </option>

                    <option
                        value="متوسط"
                        @selected(old('level', $userSkill->level) == 'متوسط')
                    >
                        متوسط
                    </option>

                    <option
                        value="متقدم"
                        @selected(old('level', $userSkill->level) == 'متقدم')
                    >
                        متقدم
                    </option>

                    <option
                        value="خبير"
                        @selected(old('level', $userSkill->level) == 'خبير')
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



            {{-- سنوات الخبرة --}}

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
                    value="{{ old('years_experience', $userSkill->years_experience) }}"
                    placeholder="مثال: 3"
                >


                @error('years_experience')

                    <small class="skills-error">
                        {{ $message }}
                    </small>

                @enderror

            </div>

        </div>


        {{-- ============================= --}}
        {{-- أزرار الصفحة --}}
        {{-- ============================= --}}

        <div class="skill-edit-actions">

            {{-- حفظ التغييرات --}}

            <button
                type="submit"
                class="skill-save-button"
            >
                <i data-lucide="save"></i>
                حفظ التغييرات
            </button>


            {{-- إلغاء --}}

            <a
                href="{{ route('skills.index') }}"
                class="skill-cancel-button"
            >
                إلغاء
            </a>

        </div>

    </form>

</section>


</div>

@endsection
