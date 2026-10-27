@extends('layouts.frontend.public')

@php
    $seoProfile = $user->profile;

    $seoBio = filled($seoProfile?->bio_ar)
        ? $seoProfile->bio_ar
        : (filled($seoProfile?->bio_en) ? $seoProfile->bio_en : null);

    $seoDescription = \Illuminate\Support\Str::limit(
        trim(strip_tags(
            $seoBio ?: ('اكتشف مهارات وخدمات ' . $user->name . ' على NASEJA.')
        )),
        155,
        ''
    );

    $seoProfileUrl = route('users.show', [
        'slug' => $seoProfile->slug,
    ]);

    $seoProfileImage = filled($seoProfile?->avatar)
        ? asset('storage/' . $seoProfile->avatar)
        : asset('images/naseja-logo.png');

    $seoSkillNames = $user->userSkills
        ->map(fn ($userSkill) => $userSkill->skill?->name_ar ?: $userSkill->skill?->name_en)
        ->filter()
        ->unique()
        ->take(10)
        ->values()
        ->all();

    $seoPersonSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'ProfilePage',
        'url' => $seoProfileUrl,
        'name' => $user->name . ' | NASEJA',
        'description' => $seoDescription,
        'mainEntity' => array_filter([
            '@type' => 'Person',
            'name' => $user->name,
            'url' => $seoProfileUrl,
            'image' => $seoProfileImage,
            'description' => $seoDescription,
            'jobTitle' => 'صاحب مهارة',
            'knowsAbout' => $seoSkillNames ?: null,
            'address' => filled($seoProfile?->location)
                ? [
                    '@type' => 'PostalAddress',
                    'addressLocality' => $seoProfile->location,
                ]
                : null,
        ], fn ($value) => $value !== null && $value !== []),
    ];
@endphp

@section('title', $user->name . ' | صاحب مهارة على NASEJA')
@section('meta_description', $seoDescription)
@section('canonical', $seoProfileUrl)
@section('og_type', 'profile')
@section('og_image', $seoProfileImage)

@push('structured_data')
<script type="application/ld+json">
{!! json_encode(
    $seoPersonSchema,
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
) !!}
</script>
@endpush

@section('content')
@php
    $experienceYears = $user->userSkills->max('years_experience') ?? 0;
    $avatar = $user->profile->avatar ?? null;

    /* بيانات الملف العام */
    $bioArRaw = $user->profile->bio_ar ?? null;
    $bioEnRaw = $user->profile->bio_en ?? null;

    $bioAr = filled($bioArRaw)
        ? $bioArRaw
        : (filled($bioEnRaw) ? $bioEnRaw : null);

    $bioEn = filled($bioEnRaw)
        ? $bioEnRaw
        : (filled($bioArRaw) ? $bioArRaw : null);

    $locationParts = array_filter([
        $user->profile?->governorate,
        $user->profile?->district,
        $user->profile?->street,
    ], fn ($value) => filled($value));
    $location = $locationParts ? implode('، ', $locationParts) : ($user->profile?->location ?? null);

    /* وسائل التواصل العامة الاختيارية لصاحب المهارة */
    $contactPhoneRaw = $user->profile->contact_phone ?? null;
    $contactPhoneLink = preg_replace('/[^0-9+]/', '', trim((string) $contactPhoneRaw));

    $whatsappRaw = $user->profile->whatsapp ?? null;
    $whatsappDigits = preg_replace('/\D+/', '', (string) $whatsappRaw);

    $telegramRaw = $user->profile->telegram_username ?? null;
    $telegramUsername = ltrim(trim((string) $telegramRaw), '@');

    $hasPublicContact = filled($contactPhoneLink)
        || filled($whatsappDigits)
        || filled($telegramUsername);

    $memberSince = $user->created_at
        ? $user->created_at->format('Y/m/d')
        : null;

    $viewerIsCustomer = auth()->check()
        && auth()->user()->roles()->where('slug', 'customer')->exists();


    $viewerHasFavorited = $viewerIsCustomer
        && \App\Models\Favorite::query()
            ->where('user_id', auth()->id())
            ->where('favorite_user_id', $user->id)
            ->exists();
@endphp


<style>
@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap');

:root {
    --naseja-violet: #7357ff;
    --naseja-violet-2: #9b6dff;
    --naseja-blue: #3487ff;
    --naseja-cyan: #20d4ef;
    --naseja-pink: #ff5fa2;
    --naseja-orange: #ff9f43;
    --naseja-green: #21c995;
    --naseja-red: #ff5d73;
    --naseja-ink: #17162c;
    --naseja-soft: #6f7489;
}

.public-profile-page,
.public-profile-page * {
    box-sizing: border-box;
}

.public-profile-page {
    --pp-card: rgba(255,255,255,.82);
    --pp-card-solid: #ffffff;
    --pp-text: #17162c;
    --pp-text-soft: #73788d;
    --pp-line: rgba(115,87,255,.12);
    --pp-shadow: 0 24px 70px rgba(69,55,145,.12);

    position: relative;
    isolation: isolate;
    max-width: 1260px;
    margin: 0 auto;
    padding: 34px 18px 90px;
    color: var(--pp-text);
    font-family: 'Cairo', sans-serif;
}

.public-profile-page::before,
.public-profile-page::after {
    content: "";
    position: fixed;
    z-index: -2;
    pointer-events: none;
    border-radius: 50%;
    filter: blur(70px);
    opacity: .26;
}

.public-profile-page::before {
    width: 440px;
    height: 440px;
    top: 90px;
    right: -160px;
    background: linear-gradient(135deg, #7457ff, #36c7ff);
    animation: ppFloatOne 11s ease-in-out infinite alternate;
}

.public-profile-page::after {
    width: 380px;
    height: 380px;
    left: -120px;
    bottom: 40px;
    background: linear-gradient(135deg, #ff5fa2, #ffb259);
    animation: ppFloatTwo 13s ease-in-out infinite alternate;
}

@keyframes ppFloatOne {
    from { transform: translate3d(0,0,0) scale(1); }
    to   { transform: translate3d(-35px,55px,0) scale(1.14); }
}

@keyframes ppFloatTwo {
    from { transform: translate3d(0,0,0) scale(.96); }
    to   { transform: translate3d(45px,-35px,0) scale(1.10); }
}

@keyframes ppAurora {
    0%   { background-position: 0% 50%; }
    50%  { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

@keyframes ppShine {
    0% { transform: translateX(-160%) skewX(-22deg); }
    100% { transform: translateX(250%) skewX(-22deg); }
}

@keyframes ppPulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(33,201,149,.28); }
    50% { box-shadow: 0 0 0 9px rgba(33,201,149,0); }
}

@keyframes ppHeartBeat {
    0%,100% { transform: scale(1); }
    12% { transform: scale(1.14); }
    24% { transform: scale(.98); }
    36% { transform: scale(1.10); }
}

@keyframes ppBob {
    0%,100% { transform: translateY(0); }
    50% { transform: translateY(-7px); }
}

/* ================= TOPBAR ================= */

.public-profile-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 20px;
}

.public-profile-back {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 11px 17px;
    border: 1px solid rgba(115,87,255,.13);
    border-radius: 999px;
    background: rgba(255,255,255,.74);
    backdrop-filter: blur(18px);
    color: #343149;
    text-decoration: none;
    font-size: 13px;
    font-weight: 900;
    box-shadow: 0 10px 30px rgba(50,42,100,.07);
    transition: .25s ease;
}

.public-profile-back:hover {
    color: #6d52ef;
    border-color: rgba(115,87,255,.30);
    transform: translateY(-3px);
    box-shadow: 0 16px 36px rgba(82,64,176,.12);
}

.public-profile-breadcrumb {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 13px;
    border-radius: 999px;
    background: rgba(255,255,255,.55);
    backdrop-filter: blur(15px);
    color: #8b8fa2;
    font-size: 12px;
    font-weight: 800;
}

/* ================= FLASH ================= */

.public-profile-flash-wrap {
    display: grid;
    gap: 10px;
    margin-bottom: 18px;
}

.public-profile-report-flash {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 16px;
    border-radius: 18px;
    font-size: 12px;
    font-weight: 900;
    line-height: 1.7;
    backdrop-filter: blur(16px);
    animation: ppPop .35s ease both;
}

@keyframes ppPop {
    from { opacity: 0; transform: translateY(-8px) scale(.98); }
    to   { opacity: 1; transform: none; }
}

.public-profile-report-flash svg {
    width: 18px;
    height: 18px;
    flex-shrink: 0;
}

.public-profile-report-flash.success {
    border: 1px solid rgba(33,201,149,.20);
    background: rgba(234,255,247,.90);
    color: #148662;
}

.public-profile-report-flash.info {
    border: 1px solid rgba(52,135,255,.18);
    background: rgba(239,247,255,.92);
    color: #286dd2;
}

.public-profile-report-flash.error {
    border: 1px solid rgba(255,93,115,.18);
    background: rgba(255,242,245,.92);
    color: #d4485e;
}

/* ================= HERO ================= */

.public-profile-hero {
    display: grid;
    grid-template-columns: minmax(0, 1.48fr) minmax(340px, .82fr);
    gap: 20px;
    margin-bottom: 24px;
    perspective: 1200px;
}

.public-profile-intro {
    position: relative;
    overflow: hidden;
    min-height: 440px;
    padding: 32px;
    border: 1px solid rgba(255,255,255,.22);
    border-radius: 34px;
    background:
        radial-gradient(circle at var(--mx,75%) var(--my,20%), rgba(255,255,255,.24), transparent 23%),
        linear-gradient(125deg, #17172f 0%, #38286f 34%, #6749d8 65%, #2f9fdc 100%);
    background-size: 180% 180%;
    animation: ppAurora 12s ease infinite;
    color: #fff;
    box-shadow:
        0 28px 80px rgba(52,38,126,.28),
        inset 0 1px 0 rgba(255,255,255,.18);
    transform-style: preserve-3d;
}

.public-profile-intro::before {
    content: "";
    position: absolute;
    width: 360px;
    height: 360px;
    top: -180px;
    left: -100px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(32,212,239,.34), rgba(32,212,239,0) 70%);
    animation: ppBob 7s ease-in-out infinite;
}

.public-profile-intro::after {
    content: "";
    position: absolute;
    inset: 0;
    pointer-events: none;
    background:
        linear-gradient(rgba(255,255,255,.035) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.035) 1px, transparent 1px);
    background-size: 32px 32px;
    mask-image: linear-gradient(to bottom, rgba(0,0,0,.7), transparent 88%);
}

.public-profile-intro-head,
.public-profile-maininfo,
.public-profile-stats {
    position: relative;
    z-index: 2;
}

.public-profile-intro-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 34px;
}

.public-profile-badge,
.public-profile-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    min-height: 39px;
    padding: 0 14px;
    border: 1px solid rgba(255,255,255,.16);
    border-radius: 999px;
    background: rgba(255,255,255,.11);
    backdrop-filter: blur(16px);
    color: #fff;
    font-size: 11px;
    font-weight: 900;
}

.public-profile-badge i,
.public-profile-status-pill i {
    width: 15px;
    height: 15px;
}

.public-profile-status-pill i {
    color: #72f5c7;
}

.public-profile-status-pill::before {
    content: "";
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #52e5b2;
    animation: ppPulse 2s ease-in-out infinite;
}

.public-profile-maininfo {
    display: grid;
    grid-template-columns: auto minmax(0,1fr);
    align-items: center;
    gap: 24px;
}

.public-profile-avatar {
    position: relative;
    width: 142px;
    height: 142px;
    flex-shrink: 0;
    display: grid;
    place-items: center;
    overflow: hidden;
    border: 5px solid rgba(255,255,255,.80);
    border-radius: 40px;
    background: linear-gradient(135deg, #ff6bab, #7d5cff 50%, #32d7eb);
    color: #fff;
    font-size: 42px;
    font-weight: 900;
    box-shadow:
        0 20px 50px rgba(4,8,38,.32),
        0 0 0 10px rgba(255,255,255,.06);
    transform: rotate(-2deg);
    transition: .35s ease;
}

.public-profile-avatar:hover {
    transform: rotate(0deg) scale(1.035);
}

.public-profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.public-profile-name {
    margin: 0 0 9px;
    color: #fff;
    font-size: clamp(30px,4vw,45px);
    font-weight: 800;
    line-height: 1.15;
    letter-spacing: -.4px;
    text-shadow: 0 5px 25px rgba(0,0,0,.20);
}

.public-profile-subtitle {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
    color: rgba(255,255,255,.80);
    font-size: 13px;
    font-weight: 700;
}

.public-profile-meta-chip {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 12px;
    border: 1px solid rgba(255,255,255,.14);
    border-radius: 999px;
    background: rgba(255,255,255,.10);
    color: rgba(255,255,255,.90);
    backdrop-filter: blur(12px);
    font-size: 11px;
    font-weight: 800;
}

.public-profile-meta-chip i {
    width: 14px;
    height: 14px;
}

.public-profile-bio {
    position: relative;
    z-index: 2;
    max-width: 760px;
    margin: 25px 0 0;
    padding: 18px 20px;
    border: 1px solid rgba(255,255,255,.13);
    border-radius: 20px;
    background: rgba(9,10,35,.18);
    color: rgba(255,255,255,.86);
    backdrop-filter: blur(12px);
    font-size: 13px;
    font-weight: 600;
    line-height: 2;
}

.public-profile-stats {
    display: grid;
    grid-template-columns: repeat(3,1fr);
    gap: 11px;
    margin-top: 24px;
}

.public-profile-stat {
    position: relative;
    overflow: hidden;
    min-height: 102px;
    padding: 15px;
    border: 1px solid rgba(255,255,255,.14);
    border-radius: 20px;
    background: rgba(255,255,255,.10);
    backdrop-filter: blur(16px);
    transition: .28s ease;
}

.public-profile-stat:hover {
    transform: translateY(-5px);
    background: rgba(255,255,255,.16);
}

.public-profile-stat::after {
    content: "";
    position: absolute;
    width: 70px;
    height: 70px;
    left: -25px;
    bottom: -35px;
    border-radius: 50%;
    background: rgba(255,255,255,.08);
}

.public-profile-stat-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    color: rgba(255,255,255,.70);
    font-size: 10px;
    font-weight: 800;
}

.public-profile-stat-top i {
    width: 16px;
    height: 16px;
}

.public-profile-stat strong {
    display: block;
    margin: 8px 0 2px;
    color: #fff;
    font-size: 27px;
    font-weight: 900;
}

.public-profile-stat > span {
    color: rgba(255,255,255,.62);
    font-size: 9.5px;
    font-weight: 700;
}

/* ================= ACTION PANEL ================= */

.public-profile-actions-panel {
    position: relative;
    overflow: hidden;
    padding: 24px;
    border: 1px solid rgba(115,87,255,.13);
    border-radius: 34px;
    background:
        linear-gradient(160deg, rgba(255,255,255,.93), rgba(247,244,255,.85));
    backdrop-filter: blur(24px);
    box-shadow: var(--pp-shadow);
}

.public-profile-actions-panel::before {
    content: "";
    position: absolute;
    width: 210px;
    height: 210px;
    top: -100px;
    right: -80px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(115,87,255,.16), transparent 70%);
}

.public-profile-actions-top {
    position: relative;
    z-index: 2;
    padding: 3px 3px 16px;
}

.public-profile-actions-title {
    margin: 0 0 6px;
    color: #1d1b33;
    font-size: 22px;
    font-weight: 900;
}

.public-profile-actions-desc {
    margin: 0;
    color: #85889c;
    font-size: 11px;
    font-weight: 600;
    line-height: 1.8;
}

.public-profile-action-cards {
    position: relative;
    z-index: 2;
    display: grid;
    gap: 12px;
}

.public-profile-action-card {
    position: relative;
    overflow: hidden;
    padding: 17px;
    border: 1px solid rgba(0,0,0,.055);
    border-radius: 23px;
    background: #fff;
    box-shadow: 0 12px 28px rgba(61,48,120,.055);
    transition:
        transform .28s cubic-bezier(.2,.8,.2,1),
        box-shadow .28s ease,
        border-color .28s ease;
}

.public-profile-action-card:nth-child(1) {
    background:
        radial-gradient(circle at top left, rgba(255,95,162,.13), transparent 45%),
        #fff;
}

.public-profile-action-card:nth-child(2) {
    background:
        radial-gradient(circle at top left, rgba(33,201,149,.14), transparent 45%),
        #fff;
}

.public-profile-action-card:nth-child(3) {
    background:
        radial-gradient(circle at top left, rgba(255,93,115,.12), transparent 45%),
        #fff;
}

.public-profile-action-card:hover {
    transform: translateY(-6px) scale(1.008);
    box-shadow: 0 20px 40px rgba(70,52,150,.12);
    border-color: rgba(115,87,255,.15);
}

.public-profile-action-card::after {
    content: "";
    position: absolute;
    top: -30%;
    left: -38%;
    width: 42%;
    height: 170%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,.72), transparent);
    transform: skewX(-22deg);
    opacity: 0;
}

.public-profile-action-card:hover::after {
    opacity: .45;
    animation: ppShine .85s ease;
}

.public-profile-action-card-head {
    display: grid;
    grid-template-columns: 48px minmax(0,1fr);
    gap: 12px;
    align-items: center;
    margin-bottom: 13px;
}

.public-profile-action-card h3 {
    margin: 0 0 4px;
    color: #24213a;
    font-size: 14px;
    font-weight: 900;
}

.public-profile-action-card p {
    margin: 0;
    color: #85889a;
    font-size: 10px;
    line-height: 1.65;
    font-weight: 600;
}

.public-profile-action-icon {
    width: 48px;
    height: 48px;
    display: grid;
    place-items: center;
    border-radius: 16px;
    color: #fff;
    box-shadow: 0 10px 22px rgba(0,0,0,.11);
}

.public-profile-action-icon i {
    width: 21px;
    height: 21px;
}

.public-profile-action-icon.favorite {
    background: linear-gradient(135deg, #ff6cae, #ff4b73);
}

.public-profile-action-icon.favorite i {
    animation: ppHeartBeat 2.4s ease-in-out infinite;
}

.public-profile-action-icon.contact {
    background: linear-gradient(135deg, #20c997, #27d8e9);
}

.public-profile-action-icon.report {
    background: linear-gradient(135deg, #ff7c70, #ff4b6c);
}

.public-profile-action-icon.order {
    background: linear-gradient(135deg, #7357ff, #3487ff);
}

.public-profile-action-card.order-card {
    background:
        radial-gradient(circle at top left, rgba(115,87,255,.14), transparent 45%),
        #fff;
}

#publicProfileServices {
    scroll-margin-top: 90px;
}

.public-profile-action-btn,
.public-profile-soft-btn,
.public-profile-outline-btn {
    position: relative;
    overflow: hidden;
    min-height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border-radius: 13px;
    font-family: inherit;
    font-size: 10.5px;
    font-weight: 900;
    text-decoration: none;
    cursor: pointer;
    transition: .25s ease;
}

.public-profile-action-btn {
    width: 100%;
    border: 0;
    background: linear-gradient(135deg, #ff64a8, #7357ff);
    color: #fff;
    box-shadow: 0 10px 22px rgba(115,87,255,.20);
}

.public-profile-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(115,87,255,.28);
}

.public-profile-action-btn i,
.public-profile-soft-btn i,
.public-profile-outline-btn i {
    width: 15px;
    height: 15px;
}

.public-profile-contact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(105px, 1fr));
    gap: 9px;
}

.public-profile-outline-btn {
    border: 1px solid rgba(33,201,149,.18);
    background: linear-gradient(135deg, #f3fff9, #effcff);
    color: #0e926d;
}

.public-profile-outline-btn:hover {
    transform: translateY(-2px);
    border-color: rgba(33,201,149,.35);
    background: linear-gradient(135deg, #eafff6, #e6fbff);
    box-shadow: 0 10px 22px rgba(33,201,149,.12);
}

.public-profile-outline-btn.whatsapp {
    border-color: rgba(37,211,102,.22);
    background: linear-gradient(135deg, #f0fff5, #ecfff8);
    color: #118a43;
}

.public-profile-outline-btn.call {
    border-color: rgba(115,87,255,.20);
    background: linear-gradient(135deg, #f6f2ff, #f2f7ff);
    color: #6750d7;
}

.public-profile-outline-btn.telegram {
    border-color: rgba(52,135,255,.20);
    background: linear-gradient(135deg, #f1f7ff, #eefcff);
    color: #2878d8;
}

.public-profile-soft-btn {
    width: 100%;
    border: 0;
    background: linear-gradient(135deg, #fff0f3, #fff6f2);
    color: #d84d62;
}

.public-profile-soft-btn:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #ffe6eb, #fff0e9);
    box-shadow: 0 10px 22px rgba(255,93,115,.12);
}

.public-profile-contact-note,
.public-profile-report-note {
    margin-top: 10px;
    padding: 9px 10px;
    border-radius: 10px;
    background: rgba(247,247,251,.80);
    color: #9a9cad;
    font-size: 9px;
    line-height: 1.6;
}

.public-profile-contact-note strong {
    color: #5c6072;
}

/* ================= MAIN SECTIONS ================= */

.public-profile-layout {
    display: grid;
    gap: 22px;
}

.public-profile-section {
    position: relative;
    overflow: hidden;
    padding: 27px;
    border: 1px solid rgba(115,87,255,.10);
    border-radius: 30px;
    background: rgba(255,255,255,.78);
    backdrop-filter: blur(20px);
    box-shadow: 0 20px 54px rgba(58,45,122,.075);
}

.public-profile-section::before {
    content: "";
    position: absolute;
    width: 170px;
    height: 170px;
    top: -110px;
    left: -70px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(115,87,255,.12), transparent 70%);
    pointer-events: none;
}

.public-profile-section-header {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 22px;
}

.public-profile-section-title-wrap {
    display: flex;
    align-items: center;
    gap: 12px;
}

.public-profile-section-icon {
    width: 46px;
    height: 46px;
    display: grid;
    place-items: center;
    border-radius: 15px;
    background: linear-gradient(135deg, #7357ff, #3d9bff);
    color: #fff;
    box-shadow: 0 10px 25px rgba(115,87,255,.22);
}

.public-profile-section:nth-child(2) .public-profile-section-icon {
    background: linear-gradient(135deg, #ff7a9d, #ff9c53);
    box-shadow: 0 10px 25px rgba(255,112,120,.20);
}

.public-profile-section:nth-child(3) .public-profile-section-icon {
    background: linear-gradient(135deg, #20c997, #24c7ec);
    box-shadow: 0 10px 25px rgba(32,201,151,.20);
}

.public-profile-section-icon i {
    width: 20px;
    height: 20px;
}

.public-profile-section-title {
    margin: 0;
    color: #1e1c34;
    font-size: 23px;
    font-weight: 900;
}

.public-profile-section-subtitle {
    margin: 4px 0 0;
    color: #9295a7;
    font-size: 10.5px;
    font-weight: 600;
}

.public-profile-count-pill {
    min-width: 42px;
    min-height: 30px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0 11px;
    border-radius: 999px;
    background: linear-gradient(135deg, rgba(115,87,255,.10), rgba(52,135,255,.08));
    color: #6b53d9;
    font-size: 11px;
    font-weight: 900;
}

/* ================= SKILLS ================= */

.public-profile-skills {
    position: relative;
    z-index: 2;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.public-profile-skill {
    position: relative;
    overflow: hidden;
    padding: 10px 15px;
    border: 1px solid rgba(115,87,255,.11);
    border-radius: 13px;
    background: linear-gradient(135deg, #f7f4ff, #f5f9ff);
    color: #644ed6;
    font-size: 11px;
    font-weight: 900;
    box-shadow: 0 8px 20px rgba(65,49,137,.055);
    transition: .22s ease;
}

.public-profile-skill:nth-child(4n+2) {
    background: linear-gradient(135deg, #fff2f7, #fff6f0);
    color: #d9577a;
    border-color: rgba(255,95,162,.13);
}

.public-profile-skill:nth-child(4n+3) {
    background: linear-gradient(135deg, #edfff9, #effcff);
    color: #128f76;
    border-color: rgba(33,201,149,.14);
}

.public-profile-skill:nth-child(4n+4) {
    background: linear-gradient(135deg, #fff8eb, #fff1ee);
    color: #d5782e;
    border-color: rgba(255,159,67,.15);
}

.public-profile-skill:hover {
    transform: translateY(-4px) scale(1.04);
    box-shadow: 0 14px 28px rgba(65,49,137,.10);
}

/* ================= SERVICES ================= */

.public-profile-services {
    position: relative;
    z-index: 2;
    display: grid;
    grid-template-columns: repeat(3,minmax(0,1fr));
    gap: 15px;
}

.public-profile-service {
    --sx: 50%;
    --sy: 50%;
    position: relative;
    overflow: hidden;
    min-height: 210px;
    padding: 19px;
    border: 1px solid rgba(115,87,255,.10);
    border-radius: 22px;
    background:
        radial-gradient(circle at var(--sx) var(--sy), rgba(115,87,255,.10), transparent 28%),
        linear-gradient(160deg, #fff 0%, #faf9ff 100%);
    box-shadow: 0 12px 30px rgba(57,44,116,.06);
    transform-style: preserve-3d;
    transition:
        transform .18s ease,
        box-shadow .25s ease,
        border-color .25s ease;
}

.public-profile-service:nth-child(3n+2) {
    background:
        radial-gradient(circle at var(--sx) var(--sy), rgba(255,95,162,.10), transparent 28%),
        linear-gradient(160deg, #fff 0%, #fff8fb 100%);
}

.public-profile-service:nth-child(3n+3) {
    background:
        radial-gradient(circle at var(--sx) var(--sy), rgba(33,201,149,.10), transparent 28%),
        linear-gradient(160deg, #fff 0%, #f8fffc 100%);
}

.public-profile-service:hover {
    border-color: rgba(115,87,255,.24);
    box-shadow: 0 24px 48px rgba(64,48,132,.13);
}

.public-profile-service-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 14px;
}

.public-profile-service-icon {
    width: 48px;
    height: 48px;
    display: grid;
    place-items: center;
    border-radius: 16px;
    background: linear-gradient(135deg, #7357ff, #3487ff);
    color: #fff;
    box-shadow: 0 12px 24px rgba(115,87,255,.20);
}

.public-profile-service:nth-child(3n+2) .public-profile-service-icon {
    background: linear-gradient(135deg, #ff5fa2, #ff8a61);
}

.public-profile-service:nth-child(3n+3) .public-profile-service-icon {
    background: linear-gradient(135deg, #21c995, #22c8ed);
}

.public-profile-service-icon i {
    width: 21px;
    height: 21px;
}

.public-profile-service h3 {
    margin: 0 0 8px;
    color: #211f37;
    font-size: 15px;
    font-weight: 900;
    line-height: 1.45;
}

.public-profile-service p {
    margin: 0;
    color: #85899c;
    font-size: 10.5px;
    font-weight: 600;
    line-height: 1.8;
}

.public-profile-service-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    margin-top: 16px;
}

.public-profile-service-meta-item {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 9px;
    border-radius: 10px;
    background: rgba(115,87,255,.075);
    color: #644fd2;
    font-size: 9.5px;
    font-weight: 900;
}

.public-profile-service-meta-item i {
    width: 13px;
    height: 13px;
}


.public-profile-service-order-wrap {
    margin-top: 16px;
    padding-top: 14px;
    border-top: 1px solid rgba(115,87,255,.09);
}

.public-profile-service-order-btn {
    width: 100%;
    min-height: 43px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 0 14px;
    border: 0;
    border-radius: 13px;
    background: linear-gradient(135deg, #7357ff, #3487ff);
    color: #fff;
    text-decoration: none;
    font-family: inherit;
    font-size: 10.5px;
    font-weight: 900;
    box-shadow: 0 10px 24px rgba(115,87,255,.18);
    transition: .24s ease;
}

.public-profile-service-order-btn:hover {
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(115,87,255,.27);
}

.public-profile-service-order-btn i {
    width: 15px;
    height: 15px;
}

html[data-theme="dark"] .public-profile-service-order-wrap {
    border-color: rgba(157,137,255,.13);
}

/* ================= PORTFOLIO ================= */

.public-profile-works {
    position: relative;
    z-index: 2;
    display: grid;
    grid-template-columns: repeat(3,minmax(0,1fr));
    gap: 17px;
}

.public-profile-work {
    --wx: 50%;
    --wy: 50%;
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(115,87,255,.10);
    border-radius: 23px;
    background: #fff;
    box-shadow: 0 12px 30px rgba(56,43,116,.065);
    transform-style: preserve-3d;
    transition:
        transform .18s ease,
        box-shadow .28s ease,
        border-color .28s ease;
}

.public-profile-work::after {
    content: "";
    position: absolute;
    inset: 0;
    pointer-events: none;
    opacity: 0;
    background: radial-gradient(circle at var(--wx) var(--wy), rgba(255,255,255,.35), transparent 22%);
    transition: opacity .2s ease;
}

.public-profile-work:hover::after {
    opacity: 1;
}

.public-profile-work:hover {
    border-color: rgba(115,87,255,.24);
    box-shadow: 0 28px 52px rgba(61,45,130,.15);
}

.public-profile-work-image {
    position: relative;
    height: 230px;
    overflow: hidden;
    background: linear-gradient(135deg, #eee9ff, #eaf8ff);
}

.public-profile-work-image::after {
    content: "";
    position: absolute;
    inset: auto 0 0;
    height: 46%;
    background: linear-gradient(to top, rgba(17,15,44,.32), transparent);
    opacity: .8;
}

.public-profile-work-image img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .55s cubic-bezier(.2,.8,.2,1), filter .35s ease;
}

.public-profile-work:hover .public-profile-work-image img {
    transform: scale(1.08);
    filter: saturate(1.08) contrast(1.03);
}

.public-profile-work-image-placeholder {
    width: 100%;
    height: 100%;
    display: grid;
    place-items: center;
    color: #8a7ed1;
}

.public-profile-work-gallery {
    display: flex;
    gap: 8px;
    padding: 10px 14px;
    overflow-x: auto;
    background: rgba(248, 247, 255, .9);
}

.public-profile-work-gallery a {
    flex: 0 0 64px;
    width: 64px;
    height: 64px;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #ddd7fb;
}

.public-profile-work-gallery img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.public-profile-work-image-placeholder i {
    width: 42px;
    height: 42px;
}

.public-profile-work-info {
    padding: 17px;
}

.public-profile-work-info h3 {
    margin: 0 0 7px;
    color: #211f37;
    font-size: 14px;
    font-weight: 900;
}

.public-profile-work-info p {
    margin: 0;
    color: #888c9f;
    font-size: 10.5px;
    font-weight: 600;
    line-height: 1.75;
}

.public-profile-work-description {
    display: block;
    margin: 0 0 14px !important;
    color: #73788d !important;
    font-size: 11px !important;
    line-height: 1.9 !important;
    white-space: normal;
    overflow: visible;
    -webkit-line-clamp: unset;
}

.public-profile-work-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    padding-top: 13px;
    border-top: 1px solid rgba(115,87,255,.09);
}

.public-profile-work-meta-item {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    min-height: 30px;
    padding: 0 10px;
    border-radius: 10px;
    background: linear-gradient(135deg, rgba(115,87,255,.075), rgba(52,135,255,.06));
    color: #6652cf;
    font-size: 9.5px;
    font-weight: 900;
}

.public-profile-work-meta-item.location {
    background: linear-gradient(135deg, rgba(33,201,149,.08), rgba(32,212,239,.07));
    color: #168c73;
}

.public-profile-work-meta-item i {
    width: 13px;
    height: 13px;
}

/* ================= EMPTY ================= */

.public-profile-empty {
    position: relative;
    z-index: 2;
    padding: 30px 16px;
    border: 1px dashed rgba(115,87,255,.22);
    border-radius: 18px;
    background: linear-gradient(135deg, rgba(115,87,255,.055), rgba(52,135,255,.04));
    color: #9093a7;
    text-align: center;
    font-size: 11px;
    font-weight: 700;
}

/* ================= REPORT MODAL ================= */
.naseja-report-modal {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: rgba(19, 17, 42, .66);
    backdrop-filter: blur(5px);
}
.naseja-report-modal.is-open { display: flex; }
.naseja-report-dialog {
    width: min(560px, 100%);
    max-height: min(760px, calc(100dvh - 40px));
    overflow-y: auto;
    overscroll-behavior: contain;
    border: 1px solid #e9e5f6;
    border-radius: 24px;
    background: #fff;
    color: #23203b;
    box-shadow: 0 24px 75px rgba(17, 14, 49, .27);
    font-family: 'Cairo', sans-serif;
}
.naseja-report-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 14px;
    padding: 24px 26px 20px;
    border-bottom: 1px solid #eeebf5;
    background: #f8f7ff;
}
.naseja-report-title-wrap { display: flex; align-items: flex-start; gap: 13px; }
.naseja-report-icon {
    width: 44px;
    height: 44px;
    flex: none;
    display: grid;
    place-items: center;
    border-radius: 13px;
    background: #ebe7ff;
    color: #5543c3;
}
.naseja-report-icon svg { width: 21px; height: 21px; }
.naseja-report-head h2 { margin: 0 0 3px; color: #24203d; font-size: 21px; font-weight: 800; }
.naseja-report-head p { margin: 0; color: #5f5a70; font-size: 13px; line-height: 1.8; }
.naseja-report-close {
    width: 38px;
    height: 38px;
    flex: none;
    display: grid;
    place-items: center;
    border: 1px solid #ddd8ed;
    border-radius: 11px;
    background: #fff;
    color: #514a69;
    cursor: pointer;
}
.naseja-report-close:hover { background: #ebe7ff; }
.naseja-report-close svg { width: 18px; height: 18px; }
.naseja-report-body { padding: 22px 26px; }
.naseja-report-label { display: block; margin-bottom: 12px; color: #312c4b; font-size: 14px; font-weight: 700; }
.naseja-report-reasons { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 10px; }
.naseja-report-reason { position: relative; cursor: pointer; }
.naseja-report-reason input { position: absolute; width: 1px; height: 1px; opacity: 0; }
.naseja-report-reason span {
    min-height: 54px;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 13px;
    border: 1px solid #e4e0ef;
    border-radius: 12px;
    background: #fff;
    color: #39334c;
    font-size: 13px;
    font-weight: 600;
    transition: background .15s, border-color .15s;
}
.naseja-report-reason span::before {
    content: '';
    width: 17px;
    height: 17px;
    flex: none;
    border: 2px solid #aaa3bd;
    border-radius: 50%;
}
.naseja-report-reason input:checked + span { border-color: #6551df; background: #f5f2ff; color: #3e2dae; }
.naseja-report-reason input:checked + span::before { border-color: #6551df; background: #6551df; box-shadow: inset 0 0 0 3px #fff; }
.naseja-report-reason input:focus-visible + span { outline: 3px solid #a69bf8; outline-offset: 2px; }
.naseja-report-details { margin-top: 20px; }
.naseja-report-details textarea {
    width: 100%;
    min-height: 110px;
    resize: vertical;
    padding: 12px 14px;
    border: 1px solid #ddd8e9;
    border-radius: 12px;
    background: #fff;
    color: #302b40;
    font-family: inherit;
    font-size: 13px;
    line-height: 1.9;
}
.naseja-report-details textarea:focus { outline: 3px solid #e5dfff; border-color: #6551df; }
.naseja-report-help {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-top: 15px;
    padding: 12px 14px;
    border-radius: 12px;
    background: #f4f3fb;
    color: #504b64;
    font-size: 12px;
    line-height: 1.8;
}
.naseja-report-help svg { width: 18px; height: 18px; flex: none; margin-top: 3px; color: #5846c4; }
.naseja-report-errors {
    margin-bottom: 17px;
    padding: 11px 13px;
    border: 1px solid #f2bcc5;
    border-radius: 12px;
    background: #fff3f4;
    color: #a72742;
    font-size: 13px;
    line-height: 1.8;
}
.naseja-report-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 17px 26px 22px;
    border-top: 1px solid #eeebf5;
}
.naseja-report-cancel, .naseja-report-submit {
    min-height: 46px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 8px 19px;
    border-radius: 11px;
    font-family: inherit;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
}
.naseja-report-cancel { border: 1px solid #dcd6e9; background: #fff; color: #413b56; }
.naseja-report-submit { border: 1px solid #5140c3; background: #5140c3; color: #fff; }
.naseja-report-submit:hover { background: #3e30a3; }
.naseja-report-submit svg { width: 17px; height: 17px; }
.naseja-report-close:focus-visible, .naseja-report-cancel:focus-visible,
.naseja-report-submit:focus-visible { outline: 3px solid #a69bf8; outline-offset: 2px; }
@media (max-width: 600px) {
    .naseja-report-head { padding: 21px 19px 17px; }
    .naseja-report-body { padding: 20px 19px; }
    .naseja-report-footer { padding: 16px 19px 20px; }
}
@media (prefers-reduced-motion: reduce) {
    .naseja-report-reason span { transition: none; }
}

body.naseja-report-lock {
    overflow: hidden;
}

/* ================= SCROLL REVEAL ================= */

.public-profile-page.pp-motion-ready .pp-reveal {
    opacity: 0;
    transform: translateY(24px) scale(.985);
    transition:
        opacity .65s cubic-bezier(.2,.8,.2,1),
        transform .65s cubic-bezier(.2,.8,.2,1);
}

.public-profile-page.pp-motion-ready .pp-reveal.pp-visible {
    opacity: 1;
    transform: none;
}

/* ================= DARK ================= */

html[data-theme="dark"] .public-profile-page {
    --pp-card: rgba(25,25,40,.80);
    --pp-card-solid: #1c1b2b;
    --pp-text: #f5f3fb;
    --pp-text-soft: #a8a5b7;
    --pp-line: rgba(157,137,255,.18);
}

html[data-theme="dark"] .public-profile-back,
html[data-theme="dark"] .public-profile-breadcrumb,
html[data-theme="dark"] .public-profile-actions-panel,
html[data-theme="dark"] .public-profile-section {
    background: rgba(27,26,43,.82);
    border-color: rgba(157,137,255,.16);
    color: #f1eff7;
}

html[data-theme="dark"] .public-profile-actions-title,
html[data-theme="dark"] .public-profile-section-title,
html[data-theme="dark"] .public-profile-action-card h3,
html[data-theme="dark"] .public-profile-service h3,
html[data-theme="dark"] .public-profile-work-info h3 {
    color: #f4f2f8;
}

html[data-theme="dark"] .public-profile-actions-desc,
html[data-theme="dark"] .public-profile-section-subtitle,
html[data-theme="dark"] .public-profile-action-card p,
html[data-theme="dark"] .public-profile-service p,
html[data-theme="dark"] .public-profile-work-info p {
    color: #aaa7b6;
}

html[data-theme="dark"] .public-profile-action-card,
html[data-theme="dark"] .public-profile-service,
html[data-theme="dark"] .public-profile-work {
    background: rgba(34,33,51,.92);
    border-color: rgba(157,137,255,.13);
}

html[data-theme="dark"] .public-profile-contact-note,
html[data-theme="dark"] .public-profile-report-note {
    background: rgba(255,255,255,.04);
}

html[data-theme="dark"] .naseja-report-dialog {
    background: #1d1c2c;
    border-color: rgba(157,137,255,.20);
}

html[data-theme="dark"] .naseja-report-head,
html[data-theme="dark"] .naseja-report-footer {
    border-color: #333145;
}

html[data-theme="dark"] .naseja-report-head h2,
html[data-theme="dark"] .naseja-report-label {
    color: #f2eff7;
}

html[data-theme="dark"] .naseja-report-head p {
    color: #aaa7b7;
}

html[data-theme="dark"] .naseja-report-close,
html[data-theme="dark"] .naseja-report-help,
html[data-theme="dark"] .naseja-report-reason span,
html[data-theme="dark"] .naseja-report-details textarea,
html[data-theme="dark"] .naseja-report-cancel {
    background: #29283a;
    color: #cbc7d5;
    border-color: #3a384a;
}

/* ================= RESPONSIVE ================= */

@media (max-width: 1050px) {
    .public-profile-hero {
        grid-template-columns: 1fr;
    }

    .public-profile-actions-panel {
        display: grid;
        grid-template-columns: .72fr 1.28fr;
        gap: 18px;
        align-items: start;
    }

    .public-profile-action-cards {
        grid-template-columns: repeat(3,1fr);
    }

    .public-profile-action-card-head {
        grid-template-columns: 42px minmax(0,1fr);
    }

    .public-profile-action-icon {
        width: 42px;
        height: 42px;
    }
}

@media (max-width: 900px) {
    .public-profile-services,
    .public-profile-works {
        grid-template-columns: repeat(2,minmax(0,1fr));
    }

    .public-profile-actions-panel {
        display: block;
    }

    .public-profile-action-cards {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 650px) {
    .public-profile-page {
        padding: 20px 10px 58px;
    }

    .public-profile-topbar {
        align-items: stretch;
        flex-direction: column;
    }

    .public-profile-breadcrumb {
        width: fit-content;
    }

    .public-profile-intro,
    .public-profile-actions-panel,
    .public-profile-section {
        border-radius: 24px;
    }

    .public-profile-intro {
        min-height: 0;
        padding: 23px 17px;
    }

    .public-profile-intro-head {
        margin-bottom: 24px;
    }

    .public-profile-maininfo {
        grid-template-columns: 1fr;
        text-align: center;
    }

    .public-profile-avatar {
        width: 112px;
        height: 112px;
        margin: 0 auto;
        border-radius: 32px;
    }

    .public-profile-subtitle {
        justify-content: center;
    }

    .public-profile-bio {
        text-align: start;
    }

    .public-profile-stats {
        grid-template-columns: 1fr;
    }

    .public-profile-services,
    .public-profile-works {
        grid-template-columns: 1fr;
    }

    .public-profile-work-image {
        height: 245px;
    }

    .public-profile-section {
        padding: 21px 15px;
    }

    .public-profile-section-header {
        align-items: flex-start;
    }

    .public-profile-contact-grid {
        grid-template-columns: 1fr;
    }

    .naseja-report-modal {
        align-items: flex-end;
        padding: 0;
    }

    .naseja-report-dialog {
        width: 100%;
        max-height: 92vh;
        border-radius: 28px 28px 0 0;
    }

    .naseja-report-reasons {
        grid-template-columns: 1fr;
    }

    .naseja-report-footer {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }
}

html[dir="ltr"] .public-profile-page {
    direction: ltr;
}

html[dir="ltr"] .public-profile-avatar {
    transform: rotate(2deg);
}

html[data-font-size="small"] .public-profile-page { font-size: 14px; }
html[data-font-size="normal"] .public-profile-page { font-size: 16px; }
html[data-font-size="large"] .public-profile-page { font-size: 18px; }

html[data-reduced-motion="true"] .public-profile-page *,
html[data-reduced-motion="true"] .public-profile-page *::before,
html[data-reduced-motion="true"] .public-profile-page *::after {
    animation-duration: .001ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: .001ms !important;
    scroll-behavior: auto !important;
}
</style>


<div class="public-profile-page">

    <div class="public-profile-flash-wrap">
        @if(session('report_success'))
            <div class="public-profile-report-flash success">
                <i data-lucide="circle-check"></i>
                <span>{{ session('report_success') }}</span>
            </div>
        @endif

        @if(session('report_info'))
            <div class="public-profile-report-flash info">
                <i data-lucide="info"></i>
                <span>{{ session('report_info') }}</span>
            </div>
        @endif

        @if(session('report_error'))
            <div class="public-profile-report-flash error">
                <i data-lucide="circle-alert"></i>
                <span>{{ session('report_error') }}</span>
            </div>
        @endif
    </div>

    <div class="public-profile-topbar">
        <a
            href="{{ route('explore') }}"
            class="public-profile-back"
            data-naseja-ar="← العودة إلى الاستكشاف"
            data-naseja-en="Back to explore →"
        >
            ← العودة إلى الاستكشاف
        </a>

        <div
            class="public-profile-breadcrumb"
            data-naseja-ar="NASEJA / الملف العام"
            data-naseja-en="NASEJA / Public profile"
        >
            NASEJA / الملف العام
        </div>
    </div>

    <section class="public-profile-hero">
        <div class="public-profile-intro">
            <div class="public-profile-intro-head">
                <div
                    class="public-profile-badge"
                    data-naseja-ar="ملف مهني عام"
                    data-naseja-en="Public professional profile"
                >
                    <i data-lucide="badge-check"></i>
                    ملف مهني عام
                </div>

                <div
                    class="public-profile-status-pill"
                    data-naseja-ar="متاح لاستقبال الطلبات"
                    data-naseja-en="Available for new requests"
                >
                    <i data-lucide="sparkles"></i>
                    متاح لاستقبال الطلبات
                </div>
            </div>

            <div class="public-profile-maininfo">
                <div class="public-profile-avatar">
                    @if($avatar)
                        <img src="{{ asset('storage/' . $avatar) }}" alt="{{ $user->name }}">
                    @else
                        {{ mb_substr($user->name, 0, 1) }}
                    @endif
                </div>

                <div>
                    <h1 class="public-profile-name">{{ $user->name }}</h1>

                    <div class="public-profile-subtitle">
                        <span
                            class="public-profile-meta-chip"
                            data-naseja-ar="صاحب مهارة"
                            data-naseja-en="Skilled professional"
                        >
                            <i data-lucide="briefcase"></i>
                            صاحب مهارة
                        </span>

                        @if($location)
                            <span class="public-profile-meta-chip">
                                <i data-lucide="map-pin"></i>
                                {{ $location }}
                            </span>
                        @endif

                        @if($memberSince)
                            <span
                                class="public-profile-meta-chip"
                                data-naseja-ar="عضو منذ {{ $memberSince }}"
                                data-naseja-en="Member since {{ $memberSince }}"
                            >
                                <i data-lucide="calendar-days"></i>
                                عضو منذ {{ $memberSince }}
                            </span>
                        @endif
                    </div>

                    @if($bioAr || $bioEn)
                        <p
                            class="public-profile-bio"
                            data-naseja-ar="{{ $bioAr }}"
                            data-naseja-en="{{ $bioEn }}"
                        >
                            {{ $bioAr }}
                        </p>
                    @else
                        <p
                            class="public-profile-bio"
                            data-naseja-ar="هذا الملف يعرض نبذة عن صاحب المهارة وخدماته وأعماله المتاحة عبر منصة NASEJA."
                            data-naseja-en="This profile highlights the professional, their services, and selected portfolio work on NASEJA."
                        >
                            هذا الملف يعرض نبذة عن صاحب المهارة وخدماته وأعماله المتاحة عبر منصة NASEJA.
                        </p>
                    @endif
                </div>
            </div>

            <div class="public-profile-stats">
                <div class="public-profile-stat">
                    <div class="public-profile-stat-top">
                        <span data-naseja-ar="المهارات" data-naseja-en="Skills">المهارات</span>
                        <i data-lucide="layers"></i>
                    </div>
                    <strong>{{ $user->userSkills->count() }}</strong>
                    <span data-naseja-ar="مهارة مضافة إلى الملف" data-naseja-en="skills listed in the profile">مهارة مضافة إلى الملف</span>
                </div>

                <div class="public-profile-stat">
                    <div class="public-profile-stat-top">
                        <span data-naseja-ar="الخبرة" data-naseja-en="Experience">الخبرة</span>
                        <i data-lucide="hourglass"></i>
                    </div>
                    <strong>{{ $experienceYears }}</strong>
                    <span data-naseja-ar="أعلى عدد سنوات خبرة" data-naseja-en="highest years of experience">أعلى عدد سنوات خبرة</span>
                </div>

                <div class="public-profile-stat">
                    <div class="public-profile-stat-top">
                        <span data-naseja-ar="الأعمال" data-naseja-en="Portfolio">الأعمال</span>
                        <i data-lucide="images"></i>
                    </div>
                    <strong>{{ $user->portfolioItems->count() }}</strong>
                    <span data-naseja-ar="نماذج معروضة في الملف" data-naseja-en="portfolio items displayed">نماذج معروضة في الملف</span>
                </div>
            </div>
        </div>

        <aside class="public-profile-actions-panel">
            <div class="public-profile-actions-top">
                <h2
                    class="public-profile-actions-title"
                    data-naseja-ar="التواصل والإجراءات"
                    data-naseja-en="Contact & actions"
                >
                    التواصل والإجراءات
                </h2>

                <p
                    class="public-profile-actions-desc"
                    data-naseja-ar="من هنا يمكنك طلب خدمة من صاحب المهارة، أو حفظ الملف في المفضلة، أو التواصل معه، أو إرسال بلاغ عند الحاجة."
                    data-naseja-en="From here, you can request a service, save this profile, contact the professional, or report the account when needed."
                >
                    من هنا يمكنك طلب خدمة من صاحب المهارة، أو حفظ الملف في المفضلة، أو التواصل معه، أو إرسال بلاغ عند الحاجة.
                </p>
            </div>

            <div class="public-profile-action-cards">
                @if($user->services->count() && (!auth()->check() || $viewerIsCustomer))
                    <div class="public-profile-action-card order-card">
                        <div class="public-profile-action-card-head">
                            <div class="public-profile-action-icon order">
                                <i data-lucide="shopping-bag"></i>
                            </div>
                            <div>
                                <h3 data-naseja-ar="طلب خدمة" data-naseja-en="Request a service">طلب خدمة</h3>
                                <p data-naseja-ar="اختر إحدى الخدمات المتاحة ثم أكمل طلبك من داخل المنصة." data-naseja-en="Choose one of the available services, then continue your request inside the platform.">
                                    اختر إحدى الخدمات المتاحة ثم أكمل طلبك من داخل المنصة.
                                </p>
                            </div>
                        </div>

                        <a href="#publicProfileServices" class="public-profile-action-btn">
                            <i data-lucide="shopping-cart"></i>
                            <span data-naseja-ar="استعراض الخدمات وطلبها" data-naseja-en="Browse services & request">استعراض الخدمات وطلبها</span>
                        </a>
                    </div>
                @endif

                @if(!auth()->check() || $viewerIsCustomer)
                    <div class="public-profile-action-card">
                        <div class="public-profile-action-card-head">
                            <div class="public-profile-action-icon favorite">
                                <i data-lucide="heart"></i>
                            </div>
                            <div>
                                <h3 data-naseja-ar="المفضلة" data-naseja-en="Favorites">المفضلة</h3>

                                @if($viewerHasFavorited)
                                    <p data-naseja-ar="هذا الملف محفوظ في مفضلتك." data-naseja-en="This profile is saved in your favorites.">
                                        هذا الملف محفوظ في مفضلتك.
                                    </p>
                                @else
                                    <p data-naseja-ar="احفظ صاحب المهارة للرجوع إليه وطلب خدماته لاحقًا." data-naseja-en="Save this professional to return and request services later.">
                                        احفظ صاحب المهارة للرجوع إليه وطلب خدماته لاحقًا.
                                    </p>
                                @endif
                            </div>
                        </div>

                        @if($viewerHasFavorited)
                            <form method="POST" action="{{ route('favorites.destroy', $user) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="public-profile-action-btn">
                                    <i data-lucide="heart-off"></i>
                                    <span data-naseja-ar="إزالة من المفضلة" data-naseja-en="Remove from favorites">
                                        إزالة من المفضلة
                                    </span>
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('favorites.store', $user) }}">
                                @csrf

                                <button type="submit" class="public-profile-action-btn">
                                    <i data-lucide="heart"></i>

                                    @auth
                                        <span data-naseja-ar="حفظ في المفضلة" data-naseja-en="Save to favorites">
                                            حفظ في المفضلة
                                        </span>
                                    @else
                                        <span data-naseja-ar="احفظ في المفضلة" data-naseja-en="Save to favorites">
                                            احفظ في المفضلة
                                        </span>
                                    @endauth
                                </button>
                            </form>
                        @endif
                    </div>
                @endif

                <div class="public-profile-action-card">
                    <div class="public-profile-action-card-head">
                        <div class="public-profile-action-icon contact">
                            <i data-lucide="message-circle"></i>
                        </div>
                        <div>
                            <h3 data-naseja-ar="التواصل" data-naseja-en="Contact">التواصل</h3>
                            <p data-naseja-ar="ابدأ التواصل مع صاحب المهارة عبر الطرق المتاحة في الملف." data-naseja-en="Reach the professional using the available contact methods.">
                                ابدأ التواصل مع صاحب المهارة عبر الطرق المتاحة في الملف.
                            </p>
                        </div>
                    </div>

                    <div class="public-profile-contact-grid">
                        @if($whatsappDigits)
                            <a
                                href="https://wa.me/{{ $whatsappDigits }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="public-profile-outline-btn whatsapp"
                                aria-label="التواصل عبر واتساب"
                            >
                                <i data-lucide="message-circle"></i>
                                <span data-naseja-ar="واتساب" data-naseja-en="WhatsApp">واتساب</span>
                            </a>
                        @endif

                        @if($contactPhoneLink)
                            <a
                                href="tel:{{ $contactPhoneLink }}"
                                class="public-profile-outline-btn call"
                                aria-label="الاتصال بصاحب المهارة"
                            >
                                <i data-lucide="phone"></i>
                                <span data-naseja-ar="اتصال" data-naseja-en="Call">اتصال</span>
                            </a>
                        @endif

                        @if($telegramUsername)
                            <a
                                href="https://t.me/{{ $telegramUsername }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="public-profile-outline-btn telegram"
                                aria-label="التواصل عبر تليجرام"
                            >
                                <i data-lucide="send"></i>
                                <span data-naseja-ar="تليجرام" data-naseja-en="Telegram">تليجرام</span>
                            </a>
                        @endif

                        @unless($hasPublicContact)
                            <div class="public-profile-empty" style="padding:16px; font-size:12px; border-style:solid; grid-column:1 / -1;">
                                <span data-naseja-ar="لا توجد وسائل تواصل عامة مضافة حاليًا." data-naseja-en="No public contact methods are available right now.">
                                    لا توجد وسائل تواصل عامة مضافة حاليًا.
                                </span>
                            </div>
                        @endunless
                    </div>

                    @if($hasPublicContact)
                        <div class="public-profile-contact-note">
                            <span
                                data-naseja-ar="تظهر فقط وسائل التواصل التي اختار صاحب المهارة إضافتها إلى ملفه العام."
                                data-naseja-en="Only contact methods the professional chose to publish are shown here."
                            >
                                تظهر فقط وسائل التواصل التي اختار صاحب المهارة إضافتها إلى ملفه العام.
                            </span>
                        </div>
                    @endif
                </div>

                @if(!auth()->check() || auth()->id() !== $user->id)
                        <div class="public-profile-action-card">
                            <div class="public-profile-action-card-head">
                                <div class="public-profile-action-icon report">
                                    <i data-lucide="shield"></i>
                                </div>
                                <div>
                                    <h3 data-naseja-ar="الإبلاغ" data-naseja-en="Report">الإبلاغ</h3>
                                    <p data-naseja-ar="إذا لاحظت محتوى مخالفًا أو حسابًا غير موثوق، يمكنك إرسال بلاغ للإدارة." data-naseja-en="If you notice inappropriate or suspicious activity, send a report to the admin team.">
                                        إذا لاحظت محتوى مخالفًا أو حسابًا غير موثوق، يمكنك إرسال بلاغ للإدارة.
                                    </p>
                                </div>
                            </div>

                            <button
                                type="button"
                                class="public-profile-soft-btn"
                                id="openNasejaReportModal"
                            >
                                <i data-lucide="flag"></i>
                                <span data-naseja-ar="إرسال بلاغ" data-naseja-en="Submit a report">إرسال بلاغ</span>
                            </button>

                            <div class="public-profile-report-note">
                                <span data-naseja-ar="سيتم إرسال البلاغ بسرية إلى إدارة NASEJA ومراجعته بعناية." data-naseja-en="The report is sent confidentially to NASEJA admin for review.">
                                    سيتم إرسال البلاغ بسرية إلى إدارة NASEJA ومراجعته بعناية.
                                </span>
                            </div>
                        </div>
                @endif
            </div>
        </aside>
    </section>

    <div class="public-profile-layout">
        <section class="public-profile-section">
            <div class="public-profile-section-header">
                <div class="public-profile-section-title-wrap">
                    <div class="public-profile-section-icon">
                        <i data-lucide="sparkles"></i>
                    </div>
                    <div>
                        <h2 class="public-profile-section-title" data-naseja-ar="المهارات" data-naseja-en="Skills">المهارات</h2>
                        <p class="public-profile-section-subtitle" data-naseja-ar="المهارات التي يمتلكها صاحب الملف" data-naseja-en="Skills listed by this professional">
                            المهارات التي يمتلكها صاحب الملف
                        </p>
                    </div>
                </div>

                <div class="public-profile-count-pill">{{ $user->userSkills->count() }}</div>
            </div>

            @if($user->userSkills->count())
                <div class="public-profile-skills">
                    @foreach($user->userSkills as $userSkill)
                        @if($userSkill->skill)
                            <span
                                class="public-profile-skill"
                                data-naseja-ar="{{ $userSkill->skill->name_ar ?? $userSkill->skill->name_en }}"
                                data-naseja-en="{{ $userSkill->skill->name_en ?? $userSkill->skill->name_ar }}"
                            >
                                <i data-lucide="star"></i>
                                {{ $userSkill->skill->name_ar ?? $userSkill->skill->name_en }}
                            </span>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="public-profile-empty" data-naseja-ar="لم تتم إضافة مهارات حتى الآن." data-naseja-en="No skills have been added yet.">
                    لم تتم إضافة مهارات حتى الآن.
                </div>
            @endif
        </section>

        <section class="public-profile-section" id="publicProfileServices">
            <div class="public-profile-section-header">
                <div class="public-profile-section-title-wrap">
                    <div class="public-profile-section-icon">
                        <i data-lucide="package"></i>
                    </div>
                    <div>
                        <h2 class="public-profile-section-title" data-naseja-ar="الخدمات" data-naseja-en="Services">الخدمات</h2>
                        <p class="public-profile-section-subtitle" data-naseja-ar="الخدمات التي يقدمها صاحب المهارة" data-naseja-en="Services offered by this professional">
                            الخدمات التي يقدمها صاحب المهارة
                        </p>
                    </div>
                </div>

                <div class="public-profile-count-pill">{{ $user->services->count() }}</div>
            </div>

            @if($user->services->count())
                <div class="public-profile-services">
                    @foreach($user->services as $service)
                        <article class="public-profile-service">
                            <div class="public-profile-service-header">
                                <div class="public-profile-service-icon">
                                    <i data-lucide="sparkles"></i>
                                </div>
                                <div>
                                    <h3 data-naseja-ar="{{ $service->title_ar ?? $service->title_en }}" data-naseja-en="{{ $service->title_en ?? $service->title_ar }}">
                                        {{ $service->title_ar ?? $service->title_en }}
                                    </h3>

                                    @if($service->description_ar || $service->description_en)
                                        <p data-naseja-ar="{{ $service->description_ar ?? $service->description_en }}" data-naseja-en="{{ $service->description_en ?? $service->description_ar }}">
                                            {{ $service->description_ar ?? $service->description_en }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="public-profile-service-meta">
                                @if($service->price_type === 'حسب الطلب')
                                    <span class="public-profile-service-meta-item">
                                        <i data-lucide="badge-dollar-sign"></i>
                                        <span data-naseja-ar="السعر حسب الطلب" data-naseja-en="Price on request">السعر حسب الطلب</span>
                                    </span>
                                @elseif($service->price !== null)
                                    <span class="public-profile-service-meta-item">
                                        <i data-lucide="badge-dollar-sign"></i>
                                        <span
                                            data-naseja-ar="{{ $service->price_type === 'يبدأ من' ? 'يبدأ من' : 'السعر:' }}"
                                            data-naseja-en="{{ $service->price_type === 'يبدأ من' ? 'From' : 'Price:' }}"
                                        >{{ $service->price_type === 'يبدأ من' ? 'يبدأ من' : 'السعر:' }}</span>
                                        {{ number_format((float) $service->price, 0) }}
                                        <span data-naseja-ar="ريال" data-naseja-en="YER">ريال</span>
                                    </span>
                                @endif

                                @if($service->duration)
                                    <span class="public-profile-service-meta-item">
                                        <i data-lucide="clock-3"></i>
                                        {{ $service->duration }}
                                    </span>
                                @endif
                            </div>

                            @if(!auth()->check() || $viewerIsCustomer)
                                <div class="public-profile-service-order-wrap">
                                    <a
                                        href="{{ route('orders.create', $service) }}"
                                        class="public-profile-service-order-btn"
                                    >
                                        <i data-lucide="shopping-cart"></i>
                                        @guest
                                            <span data-naseja-ar="تسجيل الدخول لطلب الخدمة" data-naseja-en="Sign in to request">تسجيل الدخول لطلب الخدمة</span>
                                        @else
                                            <span data-naseja-ar="طلب هذه الخدمة" data-naseja-en="Request this service">طلب هذه الخدمة</span>
                                        @endguest
                                    </a>
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>
            @else
                <div class="public-profile-empty" data-naseja-ar="لا توجد خدمات مضافة حتى الآن." data-naseja-en="No services have been added yet.">
                    لا توجد خدمات مضافة حتى الآن.
                </div>
            @endif
        </section>

        <section class="public-profile-section">
            <div class="public-profile-section-header">
                <div class="public-profile-section-title-wrap">
                    <div class="public-profile-section-icon">
                        <i data-lucide="images"></i>
                    </div>
                    <div>
                        <h2 class="public-profile-section-title" data-naseja-ar="الأعمال" data-naseja-en="Portfolio">الأعمال</h2>
                        <p class="public-profile-section-subtitle" data-naseja-ar="نماذج من الأعمال التي نفذها صاحب المهارة" data-naseja-en="Selected work completed by this professional">
                            نماذج من الأعمال التي نفذها صاحب المهارة
                        </p>
                    </div>
                </div>

                <div class="public-profile-count-pill">{{ $user->portfolioItems->count() }}</div>
            </div>

            @if($user->portfolioItems->count())
                <div class="public-profile-works">
                    @foreach($user->portfolioItems as $portfolioItem)
                        @php
                            $firstImage = $portfolioItem->images->first();
                        @endphp

                        <article class="public-profile-work">
                            <div class="public-profile-work-image">
                                @if($firstImage && $firstImage->file_path)
                                    <img
                                        src="{{ asset('storage/' . $firstImage->file_path) }}"
                                        alt="{{ $portfolioItem->title_ar ?? $portfolioItem->title_en }}"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="public-profile-work-image-placeholder">
                                        <i data-lucide="image"></i>
                                    </div>
                                @endif
                            </div>

                            @if($portfolioItem->images->count() > 1)
                                <div class="public-profile-work-gallery" aria-label="صور إضافية للعمل">
                                    @foreach($portfolioItem->images as $workImage)
                                        @if($workImage->file_path)
                                            <a href="{{ asset('storage/' . $workImage->file_path) }}" target="_blank" rel="noopener" aria-label="عرض صورة العمل {{ $loop->iteration }}">
                                                <img src="{{ asset('storage/' . $workImage->file_path) }}" alt="{{ $portfolioItem->title_ar }} - {{ $loop->iteration }}" loading="lazy">
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            @php
                                $workTitleArRaw = $portfolioItem->title_ar ?? null;
                                $workTitleEnRaw = $portfolioItem->title_en ?? null;

                                $workTitleAr = filled($workTitleArRaw)
                                    ? $workTitleArRaw
                                    : $workTitleEnRaw;

                                $workTitleEn = filled($workTitleEnRaw)
                                    ? $workTitleEnRaw
                                    : $workTitleArRaw;

                                $workDescriptionArRaw = $portfolioItem->description_ar ?? null;
                                $workDescriptionEnRaw = $portfolioItem->description_en ?? null;

                                $workDescriptionAr = filled($workDescriptionArRaw)
                                    ? $workDescriptionArRaw
                                    : $workDescriptionEnRaw;

                                $workDescriptionEn = filled($workDescriptionEnRaw)
                                    ? $workDescriptionEnRaw
                                    : $workDescriptionArRaw;

                                $workDateValue = $portfolioItem->work_date ?? null;

                                if ($workDateValue instanceof \Carbon\CarbonInterface) {
                                    $workDate = $workDateValue->format('Y/m/d');
                                } elseif (filled($workDateValue)) {
                                    try {
                                        $workDate = \Carbon\Carbon::parse($workDateValue)->format('Y/m/d');
                                    } catch (\Throwable $e) {
                                        $workDate = $workDateValue;
                                    }
                                } else {
                                    $workDate = null;
                                }

                                $workLocation =
                                    data_get($portfolioItem, 'location')
                                    ?: data_get($portfolioItem, 'work_location')
                                    ?: data_get($portfolioItem, 'project_location')
                                    ?: $location;
                            @endphp

                            <div class="public-profile-work-info">
                                <h3
                                    data-naseja-ar="{{ $workTitleAr }}"
                                    data-naseja-en="{{ $workTitleEn }}"
                                >
                                    {{ $workTitleAr }}
                                </h3>

                                @if(filled($workDescriptionAr) || filled($workDescriptionEn))
                                    <p
                                        class="public-profile-work-description"
                                        data-naseja-ar="{{ $workDescriptionAr }}"
                                        data-naseja-en="{{ $workDescriptionEn }}"
                                    >
                                        {{ $workDescriptionAr }}
                                    </p>
                                @endif

                                @if($workDate || $workLocation)
                                    <div class="public-profile-work-meta">
                                        @if($workDate)
                                            <span
                                                class="public-profile-work-meta-item"
                                                data-naseja-ar="تاريخ العمل: {{ $workDate }}"
                                                data-naseja-en="Work date: {{ $workDate }}"
                                            >
                                                <i data-lucide="calendar-days"></i>
                                                تاريخ العمل: {{ $workDate }}
                                            </span>
                                        @endif

                                        @if($workLocation)
                                            <span
                                                class="public-profile-work-meta-item location"
                                                data-naseja-ar="الموقع: {{ $workLocation }}"
                                                data-naseja-en="Location: {{ $workLocation }}"
                                            >
                                                <i data-lucide="map-pin"></i>
                                                الموقع: {{ $workLocation }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="public-profile-empty" data-naseja-ar="لا توجد أعمال مضافة حتى الآن." data-naseja-en="No portfolio items have been added yet.">
                    لا توجد أعمال مضافة حتى الآن.
                </div>
            @endif
        </section>
    </div>
</div>

@if(!auth()->check() || auth()->id() !== $user->id)
        <div
            class="naseja-report-modal {{ $errors->report->any() ? 'is-open' : '' }}"
            id="nasejaReportModal"
            aria-hidden="{{ $errors->report->any() ? 'false' : 'true' }}"
        >
            <div class="naseja-report-dialog" role="dialog" aria-modal="true" aria-labelledby="nasejaReportTitle">
                <form method="POST" action="{{ route('reports.users.store', $user) }}">
                    @csrf

                    <div class="naseja-report-head">
                        <div class="naseja-report-title-wrap">
                            <div class="naseja-report-icon">
                                <i data-lucide="flag"></i>
                            </div>
                            <div>
                                <h2 id="nasejaReportTitle">الإبلاغ عن هذا الحساب</h2>
                                <p>
                                    أخبرنا بسبب البلاغ، وسيقوم فريق NASEJA بمراجعته بشكل سري ومهني.
                                </p>
                            </div>
                        </div>

                        <button type="button" class="naseja-report-close" id="closeNasejaReportModal" aria-label="إغلاق">
                            <i data-lucide="x"></i>
                        </button>
                    </div>

                    <div class="naseja-report-body">
                        @if($errors->report->any())
                            <div class="naseja-report-errors">
                                @foreach($errors->report->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <div class="naseja-report-label" id="nasejaReportReasonLabel">ما سبب البلاغ؟</div>

                        <div class="naseja-report-reasons" role="group" aria-labelledby="nasejaReportReasonLabel">
                            <label class="naseja-report-reason">
                                <input type="radio" name="reason" value="inappropriate_content" required {{ old('reason') === 'inappropriate_content' ? 'checked' : '' }}>
                                <span>محتوى غير مناسب</span>
                            </label>

                            <label class="naseja-report-reason">
                                <input type="radio" name="reason" value="misleading_information" {{ old('reason') === 'misleading_information' ? 'checked' : '' }}>
                                <span>معلومات مضللة</span>
                            </label>

                            <label class="naseja-report-reason">
                                <input type="radio" name="reason" value="impersonation" {{ old('reason') === 'impersonation' ? 'checked' : '' }}>
                                <span>انتحال شخصية</span>
                            </label>

                            <label class="naseja-report-reason">
                                <input type="radio" name="reason" value="fraud_or_abuse" {{ old('reason') === 'fraud_or_abuse' ? 'checked' : '' }}>
                                <span>احتيال أو إساءة</span>
                            </label>

                            <label class="naseja-report-reason">
                                <input type="radio" name="reason" value="other" {{ old('reason') === 'other' ? 'checked' : '' }}>
                                <span>سبب آخر</span>
                            </label>
                        </div>

                        <div class="naseja-report-details">
                            <label for="nasejaReportDescription" class="naseja-report-label">
                                تفاصيل إضافية
                                <small style="font-weight:500; color:#6b657d;">(مطلوبة عند اختيار «سبب آخر»)</small>
                            </label>

                            <textarea
                                id="nasejaReportDescription"
                                name="description"
                                maxlength="2000"
                                placeholder="اكتب تفاصيل تساعد الإدارة على فهم المشكلة..."
                            >{{ old('description') }}</textarea>
                        </div>

                        <div class="naseja-report-help">
                            <i data-lucide="shield-check"></i>
                            <span>
                                البلاغ يصل إلى إدارة NASEJA فقط، ولا يظهر لصاحب الحساب من الذي أرسل البلاغ.
                            </span>
                        </div>
                    </div>

                    <div class="naseja-report-footer">
                        <button type="button" class="naseja-report-cancel" id="cancelNasejaReportModal">
                            إلغاء
                        </button>

                        <button type="submit" class="naseja-report-submit">
                            <i data-lucide="send"></i>
                            إرسال البلاغ
                        </button>
                    </div>
                </form>
            </div>
        </div>
@endif

@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    function syncPublicProfileTitle() {
        document.title = document.documentElement.lang === 'en'
            ? 'User Profile | NASEJA'
            : 'ملف المستخدم | NASEJA';
    }

    document.addEventListener('DOMContentLoaded', syncPublicProfileTitle);

    var profileTitleObserver = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'lang') {
                syncPublicProfileTitle();
            }
        });
    });

    profileTitleObserver.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['lang']
    });
})();
</script>

<script>
(function () {
    'use strict';

    var modal = document.getElementById('nasejaReportModal');
    var openBtn = document.getElementById('openNasejaReportModal');
    var closeBtn = document.getElementById('closeNasejaReportModal');
    var cancelBtn = document.getElementById('cancelNasejaReportModal');

    if (!modal) {
        return;
    }

    function openModal() {
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('naseja-report-lock');
    }

    function closeModal() {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('naseja-report-lock');
    }

    if (openBtn) {
        openBtn.addEventListener('click', openModal);
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', closeModal);
    }

    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modal.classList.contains('is-open')) {
            closeModal();
        }
    });

    if (modal.classList.contains('is-open')) {
        document.body.classList.add('naseja-report-lock');
    }
})();
</script>

<script>
(function () {
    'use strict';

    var page = document.querySelector('.public-profile-page');
    if (!page) return;

    var reduced = document.documentElement.getAttribute('data-reduced-motion') === 'true'
        || (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);

    if (reduced) return;

    page.classList.add('pp-motion-ready');

    var revealItems = page.querySelectorAll(
        '.public-profile-actions-panel, .public-profile-section'
    );

    revealItems.forEach(function (item, index) {
        item.classList.add('pp-reveal');
        item.style.transitionDelay = Math.min(index * 70, 210) + 'ms';
    });

    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('pp-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: .12 });

        revealItems.forEach(function (item) {
            observer.observe(item);
        });
    } else {
        revealItems.forEach(function (item) {
            item.classList.add('pp-visible');
        });
    }

    var intro = page.querySelector('.public-profile-intro');
    if (intro) {
        intro.addEventListener('pointermove', function (event) {
            var rect = intro.getBoundingClientRect();
            var x = ((event.clientX - rect.left) / rect.width) * 100;
            var y = ((event.clientY - rect.top) / rect.height) * 100;
            intro.style.setProperty('--mx', x + '%');
            intro.style.setProperty('--my', y + '%');
        });
    }

    function enableTilt(selector, xVar, yVar) {
        page.querySelectorAll(selector).forEach(function (card) {
            card.addEventListener('pointermove', function (event) {
                if (window.innerWidth < 800) return;

                var rect = card.getBoundingClientRect();
                var px = (event.clientX - rect.left) / rect.width;
                var py = (event.clientY - rect.top) / rect.height;

                var rx = (0.5 - py) * 5;
                var ry = (px - 0.5) * 6;

                card.style.transform =
                    'perspective(800px) rotateX(' + rx + 'deg) rotateY(' + ry + 'deg) translateY(-5px)';

                card.style.setProperty(xVar, (px * 100) + '%');
                card.style.setProperty(yVar, (py * 100) + '%');
            });

            card.addEventListener('pointerleave', function () {
                card.style.transform = '';
                card.style.removeProperty(xVar);
                card.style.removeProperty(yVar);
            });
        });
    }

    enableTilt('.public-profile-service', '--sx', '--sy');
    enableTilt('.public-profile-work', '--wx', '--wy');
})();
</script>

@endpush
