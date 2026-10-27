@extends('layouts.frontend.user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/favorites.css') }}">

    <style>
        .favorite-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 9px;
            align-items: center;
        }

        .favorite-remove-form {
            margin: 0;
        }

        .favorite-remove-button {
            min-height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 0 13px;
            border: 1px solid rgba(220, 72, 96, .18);
            border-radius: 12px;
            background: #fff3f5;
            color: #c8445a;
            font-family: inherit;
            font-size: 10px;
            font-weight: 900;
            cursor: pointer;
            transition: .2s ease;
        }

        .favorite-remove-button:hover {
            transform: translateY(-1px);
            background: #ffe9ed;
        }

        .favorite-remove-button i {
            width: 15px;
            height: 15px;
        }
    </style>
@endpush

@section('title', 'المفضلة | NASEJA')

@section('content')

<div class="favorites-page">

    {{-- =====================================================
         رأس الصفحة
    ====================================================== --}}
    <div class="favorites-hero">

        <div class="favorites-hero-icon">
            <i data-lucide="heart"></i>
        </div>

        <div>

            <span class="favorites-hero-label">
                اختياراتك المحفوظة
            </span>

            <h1>
                المفضلة
            </h1>

            <p>
                أصحاب المهارات الذين حفظتهم للرجوع إليهم وطلب خدماتهم لاحقًا.
            </p>

        </div>

    </div>


    {{-- =====================================================
         رسائل النظام
    ====================================================== --}}

    @if(session('success'))

        <div class="favorites-success">

            <i data-lucide="check-circle"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    @if(session('info'))

        <div class="favorites-info">

            <i data-lucide="info"></i>

            <span>
                {{ session('info') }}
            </span>

        </div>

    @endif


    {{-- =====================================================
         محتوى المفضلة
    ====================================================== --}}
    <section class="favorites-section">

        <div class="favorites-section-header">

            <div>

                <h2>
                    أصحاب المهارات المحفوظون
                </h2>

                <p>
                    افتح أي ملف لاستعراض خدماته أو احذفه من مفضلتك.
                </p>

            </div>


            <div class="favorites-count">

                {{ $favorites->count() }}

                <span>
                    محفوظ
                </span>

            </div>

        </div>


        {{-- =================================================
             قائمة أصحاب المهارات
        ================================================== --}}

        @forelse($favorites as $favorite)

            @php
                $favoriteUser = $favorite->favoriteUser;

                $bio = $favoriteUser?->profile?->bio_ar
                    ?: $favoriteUser?->profile?->bio_en;

                $profileSlug = $favoriteUser?->profile?->slug;
            @endphp


            @if($favoriteUser)

                <article class="favorite-item">


                    {{-- الصورة --}}
                    <div class="favorite-avatar">

                        @if($favoriteUser->profile?->avatar)

                            <img
                                src="{{ asset('storage/' . $favoriteUser->profile->avatar) }}"
                                alt="{{ $favoriteUser->name }}"
                            >

                        @else

                            <span>
                                {{ mb_substr($favoriteUser->name, 0, 1) }}
                            </span>

                        @endif

                    </div>


                    {{-- المعلومات --}}
                    <div class="favorite-info">

                        <h3>
                            {{ $favoriteUser->name }}
                        </h3>


                        @if($favoriteUser->profile?->location)

                            <div class="favorite-location">

                                <i data-lucide="map-pin"></i>

                                <span>
                                    {{ $favoriteUser->profile->location }}
                                </span>

                            </div>

                        @else

                            <div class="favorite-location">

                                <i data-lucide="sparkles"></i>

                                <span>
                                    صاحب مهارة على NASEJA
                                </span>

                            </div>

                        @endif


                        @if($bio)

                            <p>
                                {{ \Illuminate\Support\Str::limit($bio, 110) }}
                            </p>

                        @else

                            <p>
                                محفوظ في مفضلتك للرجوع إليه وطلب خدماته لاحقًا.
                            </p>

                        @endif

                    </div>


                    {{-- الأزرار --}}
                    <div class="favorite-actions">

                        @if($profileSlug)
                            <a
                                href="{{ route('users.show', ['slug' => $profileSlug]) }}"
                                class="favorite-view-button"
                            >

                                <i data-lucide="user-round"></i>

                                <span>
                                    عرض الملف
                                </span>

                            </a>
                        @endif


                        <form
                            method="POST"
                            action="{{ route('favorites.destroy', $favoriteUser) }}"
                            class="favorite-remove-form"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="favorite-remove-button"
                            >
                                <i data-lucide="heart-off"></i>

                                <span>
                                    إزالة
                                </span>
                            </button>
                        </form>

                    </div>

                </article>

            @endif


        @empty

            <div class="favorites-empty">

                <div class="favorites-empty-icon">
                    <i data-lucide="heart"></i>
                </div>


                <h3>
                    مفضلتك فارغة حاليًا
                </h3>


                <p>
                    استكشف أصحاب المهارات، واضغط على القلب لحفظ من يعجبك هنا.
                </p>


                <a
                    href="{{ route('explore') }}"
                    class="favorites-explore-button"
                >

                    <i data-lucide="compass"></i>

                    <span>
                        استكشف NASEJA
                    </span>

                </a>

            </div>

        @endforelse

    </section>

</div>

@endsection
