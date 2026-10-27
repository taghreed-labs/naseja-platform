
@extends('layouts.frontend.app')

@section('title', 'NASEJA | منصة المهارات والخدمات')

@section('content')

<div class="home-page">

    {{-- =========================
         Navbar
    ========================== --}}
    <header class="home-navbar">

        <a href="{{ url('/') }}" class="home-brand">
            <span class="home-brand-icon">N</span>
            <span>NASEJA</span>
        </a>

        <nav class="home-nav">

            <a href="#">الرئيسية</a>
            <a href="#">اكتشف المهارات</a>
            <a href="#">الخدمات</a>
            <a href="#">الأعمال</a>

        </nav>

        <div class="home-actions">

            <button class="notification-btn">
                🔔
            </button>

            <a href="#" class="profile-btn">
                <span class="profile-avatar">م</span>
                <span>حسابي</span>
            </a>

        </div>

    </header>


    {{-- =========================
         Hero
    ========================== --}}
    <main>

        <section class="home-hero">

            <div class="hero-content">

                <span class="hero-label">
                    ✦ اكتشف المهارات من حولك
                </span>

                <h1>
                    ابحث عن المهارة
                    <span>التي تحتاجها.</span>
                </h1>

                <p>
                    اكتشف أصحاب المهارات والخدمات المميزة،
                    وتواصل مع الشخص المناسب لإنجاز ما تحتاجه.
                </p>


                {{-- البحث --}}
                <form class="home-search">

                    <span class="search-icon">⌕</span>

                    <input
                        type="text"
                        placeholder="ابحث عن مهارة، خدمة، أو شخص..."
                    >

                    <button type="submit">
                        بحث
                    </button>

                </form>

            </div>


            {{-- العنصر البصري --}}
            <div class="hero-visual">

                <div class="hero-orbit orbit-one"></div>
                <div class="hero-orbit orbit-two"></div>

                <div class="hero-card">

                    <div class="hero-card-icon">
                        ✦
                    </div>

                    <strong>
                        مهارة تستحق أن تُرى
                    </strong>

                    <small>
                        NASEJA
                    </small>

                </div>

            </div>

        </section>


        {{-- =========================
             Categories
        ========================== --}}
        <section class="home-section">

            <div class="section-heading">

                <div>
                    <span>استكشف</span>
                    <h2>التصنيفات</h2>
                </div>

                <a href="#">
                    عرض الكل ←
                </a>

            </div>


            <div class="categories-grid">

                <a href="#" class="category-card">
                    <span>🧵</span>
                    <strong>الخياطة والتطريز</strong>
                    <small>اكتشف أصحاب المهارات</small>
                </a>

                <a href="#" class="category-card">
                    <span>🎂</span>
                    <strong>صناعة الحلويات</strong>
                    <small>خدمات مميزة</small>
                </a>

                <a href="#" class="category-card">
                    <span>🎨</span>
                    <strong>الفنون والتصميم</strong>
                    <small>إبداع من أصحاب المهارات</small>
                </a>

                <a href="#" class="category-card">
                    <span>📷</span>
                    <strong>التصوير</strong>
                    <small>مصوّرون وخدمات</small>
                </a>

                <a href="#" class="category-card">
                    <span>💻</span>
                    <strong>التقنية</strong>
                    <small>مهارات رقمية</small>
                </a>

                <a href="#" class="category-card">
                    <span>✨</span>
                    <strong>المزيد</strong>
                    <small>اكتشف المزيد</small>
                </a>

            </div>

        </section>


        {{-- =========================
             Featured Skills
        ========================== --}}
        <section class="home-section">

            <div class="section-heading">

                <div>
                    <span>مختارات NASEJA</span>
                    <h2>أصحاب مهارات مميزون</h2>
                </div>

                <a href="#">
                    اكتشف المزيد ←
                </a>

            </div>


            <div class="skills-grid">

                <article class="skill-card">

                    <div class="skill-image">
                        <span>✦</span>
                    </div>

                    <div class="skill-info">

                        <span class="skill-category">
                            تطريز
                        </span>

                        <h3>
                            أعمال تطريز يدوية مميزة
                        </h3>

                        <p>
                            تصميم وتنفيذ أعمال تطريز حسب الطلب.
                        </p>

                        <div class="skill-footer">

                            <strong>
                                ⭐ 4.9
                            </strong>

                            <span>
                                24 تقييم
                            </span>

                        </div>

                    </div>

                </article>


                <article class="skill-card">

                    <div class="skill-image">
                        <span>✦</span>
                    </div>

                    <div class="skill-info">

                        <span class="skill-category">
                            حلويات
                        </span>

                        <h3>
                            كيك وحلويات للمناسبات
                        </h3>

                        <p>
                            تصاميم مخصصة للمناسبات الخاصة.
                        </p>

                        <div class="skill-footer">

                            <strong>
                                ⭐ 4.8
                            </strong>

                            <span>
                                18 تقييم
                            </span>

                        </div>

                    </div>

                </article>


                <article class="skill-card">

                    <div class="skill-image">
                        <span>✦</span>
                    </div>

                    <div class="skill-info">

                        <span class="skill-category">
                            تصميم
                        </span>

                        <h3>
                            تصميم هويات وشعارات
                        </h3>

                        <p>
                            تصميمات إبداعية تناسب مشروعك.
                        </p>

                        <div class="skill-footer">

                            <strong>
                                ⭐ 5.0
                            </strong>

                            <span>
                                31 تقييم
                            </span>

                        </div>

                    </div>

                </article>

            </div>

        </section>

    </main>


    {{-- =========================
         Footer
    ========================== --}}
    <footer class="home-footer">

        <div class="home-brand">
            <span class="home-brand-icon">N</span>
            <span>NASEJA</span>
        </div>

        <p>
            منصة تجمع المهارات والخدمات في مكان واحد.
        </p>

        <span>
            © {{ date('Y') }} NASEJA
        </span>

    </footer>

</div>

@endsection

