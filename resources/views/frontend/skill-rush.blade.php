@extends('layouts.frontend.public')

@section('title', 'صيد المهارات | NASEJA')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
:root{
    --rush-primary:#6d5dfc;
    --rush-primary-2:#8b7cff;
    --rush-deep:#1f1a35;
    --rush-panel:#ffffff;
    --rush-soft:#f7f5ff;
    --rush-border:#e7e1f5;
    --rush-text:#2f2a3d;
    --rush-muted:#8c8699;
    --rush-good:#27a576;
    --rush-bad:#d85b68;
    --rush-gold:#f5c44d;
}

.rush-page,
.rush-page *{
    box-sizing:border-box;
    font-family:'Cairo', sans-serif;
}

.rush-page{
    min-height:calc(100vh - 80px);
    padding:30px 18px 60px;
    direction:rtl;
    color:var(--rush-text);
    background:
        radial-gradient(circle at 12% 14%,rgba(109,93,252,.14),transparent 25%),
        radial-gradient(circle at 88% 86%,rgba(139,124,255,.12),transparent 27%),
        linear-gradient(180deg,#fbfaff 0%,#f4f1fb 100%);
}

.rush-shell{
    width:min(1080px,100%);
    margin:0 auto;
}

.rush-screen{
    display:none;
}

.rush-screen.active{
    display:block;
    animation:rushScreenIn .28s ease;
}

@keyframes rushScreenIn{
    from{opacity:0;transform:translateY(10px)}
    to{opacity:1;transform:none}
}

/* =========================
   START / RESULT
========================= */

.rush-panel{
    position:relative;
    overflow:hidden;
    border:1px solid var(--rush-border);
    border-radius:30px;
    background:rgba(255,255,255,.96);
    box-shadow:0 28px 80px rgba(72,55,145,.11);
}

.rush-panel::before{
    content:"";
    position:absolute;
    width:240px;
    height:240px;
    border-radius:50%;
    right:-120px;
    top:-120px;
    background:rgba(109,93,252,.06);
    pointer-events:none;
}

.rush-center{
    padding:48px 28px;
    text-align:center;
}

.rush-logo{
    width:88px;
    height:88px;
    margin:0 auto 16px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:26px;
    color:#fff;
    background:linear-gradient(135deg,var(--rush-primary),var(--rush-primary-2));
    box-shadow:0 16px 38px rgba(109,93,252,.26);
}

.rush-logo svg{
    width:38px;
    height:38px;
    stroke-width:2.1;
}

.rush-kicker{
    display:block;
    margin-bottom:7px;
    color:var(--rush-primary);
    font-size:10px;
    font-weight:900;
    letter-spacing:1.3px;
}

.rush-title{
    margin:0;
    font-size:clamp(32px,4vw,46px);
    line-height:1.3;
    font-weight:900;
    color:#2b2638;
}

.rush-intro{
    max-width:680px;
    margin:13px auto 0;
    color:var(--rush-muted);
    font-size:13px;
    line-height:2;
    font-weight:600;
}

.rush-rules{
    display:flex;
    justify-content:center;
    flex-wrap:wrap;
    gap:9px;
    margin:28px 0 24px;
}

.rush-rule{
    min-height:40px;
    display:inline-flex;
    align-items:center;
    gap:7px;
    padding:0 13px;
    border:1px solid #ebe6f5;
    border-radius:12px;
    background:#fbfaff;
    color:#655f70;
    font-size:10px;
    font-weight:800;
}

.rush-rule svg{
    width:14px;
    height:14px;
    color:var(--rush-primary);
}

.rush-btn{
    min-height:50px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    padding:0 22px;
    border-radius:15px;
    font-family:'Cairo',sans-serif;
    font-size:12px;
    font-weight:900;
    text-decoration:none;
    cursor:pointer;
    transition:.18s ease;
}

.rush-btn svg{
    width:17px;
    height:17px;
}

.rush-btn.primary{
    border:0;
    color:#fff;
    background:linear-gradient(135deg,var(--rush-primary),#7a68ee);
    box-shadow:0 12px 28px rgba(109,93,252,.23);
}

.rush-btn.primary:hover{
    transform:translateY(-2px);
    box-shadow:0 15px 34px rgba(109,93,252,.28);
}

.rush-btn.secondary{
    border:1px solid #e3deed;
    color:#5e5868;
    background:#fff;
}

.rush-note{
    display:block;
    margin-top:12px;
    color:#aaa4b1;
    font-size:9px;
    font-weight:700;
}

.rush-empty{
    max-width:650px;
    margin:24px auto 0;
    padding:14px 16px;
    border:1px solid #efdcb5;
    border-radius:14px;
    background:#fffaf0;
    color:#8a682b;
    font-size:11px;
    font-weight:700;
}

/* =========================
   GAME WRAPPER
========================= */

.rush-game{
    padding:20px;
}

.rush-game-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:14px;
    margin-bottom:14px;
}

.rush-game-brand{
    display:flex;
    align-items:center;
    gap:10px;
}

.rush-game-badge{
    width:42px;
    height:42px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:14px;
    color:#fff;
    background:linear-gradient(135deg,var(--rush-primary),var(--rush-primary-2));
    box-shadow:0 10px 24px rgba(109,93,252,.20);
}

.rush-game-badge svg{
    width:19px;
    height:19px;
}

.rush-game-brand strong{
    display:block;
    font-size:12px;
    font-weight:900;
    color:#393247;
}

.rush-game-brand span{
    display:block;
    margin-top:1px;
    color:#9a94a4;
    font-size:8.5px;
    font-weight:700;
}

.rush-live-wrap{
    display:flex;
    align-items:center;
    gap:8px;
    padding:7px 10px;
    border-radius:10px;
    color:#6556d4;
    background:#f1eeff;
    font-size:8.5px;
    font-weight:900;
}

.rush-live{
    width:7px;
    height:7px;
    border-radius:50%;
    background:#6f5ef6;
    box-shadow:0 0 0 5px rgba(111,94,246,.10);
    animation:rushLive 1.2s infinite;
}

@keyframes rushLive{
    50%{transform:scale(.72);opacity:.65}
}

/* =========================
   HUD
========================= */

.rush-hud{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:10px;
    margin-bottom:12px;
}

.rush-stat{
    min-height:66px;
    padding:11px 13px;
    border:1px solid #ebe6f4;
    border-radius:15px;
    background:#fbfaff;
}

.rush-stat span{
    display:block;
    margin-bottom:4px;
    color:#9a94a4;
    font-size:8.5px;
    font-weight:800;
}

.rush-stat strong{
    display:block;
    color:#393341;
    font-size:15px;
    font-weight:900;
}

.rush-stat.combo strong{
    color:#d17c30;
}

.rush-stat.timer strong{
    color:var(--rush-primary);
}

.rush-progress{
    height:7px;
    overflow:hidden;
    margin-bottom:15px;
    border-radius:999px;
    background:#eeebf4;
}

.rush-progress span{
    display:block;
    width:100%;
    height:100%;
    border-radius:inherit;
    background:linear-gradient(90deg,var(--rush-primary),#a18df6);
    transition:width .18s linear;
}

/* =========================
   ARCADE FIELD
========================= */

.rush-board{
    padding:14px;
    border:1px solid #e4def0;
    border-radius:24px;
    background:
        linear-gradient(180deg,rgba(255,255,255,.98),rgba(248,246,255,.98));
}

.rush-board-top{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    margin-bottom:12px;
    padding:0 3px;
}

.rush-board-top strong{
    color:#57505f;
    font-size:10px;
    font-weight:900;
}

.rush-speed{
    padding:6px 9px;
    border-radius:9px;
    color:#6859d7;
    background:#f0edff;
    font-size:8px;
    font-weight:900;
}

.rush-field{
    position:relative;
    height:560px;
    overflow:hidden;
    border:1px solid #ded7eb;
    border-radius:22px;
    background:
        radial-gradient(circle at 50% 8%,rgba(133,114,255,.16),transparent 30%),
        linear-gradient(rgba(255,255,255,.035) 1px,transparent 1px),
        linear-gradient(90deg,rgba(255,255,255,.035) 1px,transparent 1px),
        linear-gradient(180deg,#29233f 0%,#201b33 100%);
    background-size:auto,28px 28px,28px 28px,auto;
    box-shadow:inset 0 0 60px rgba(10,7,24,.18);
}

.rush-field::before{
    content:"";
    position:absolute;
    top:0;
    left:50%;
    width:1px;
    height:100%;
    transform:translateX(-50%);
    background:linear-gradient(180deg,rgba(255,255,255,.14),rgba(255,255,255,0));
    pointer-events:none;
}

.rush-fall{
    position:absolute;
    inset:0 0 150px 0;
    overflow:visible;
    pointer-events:none;
}

.rush-danger{
    position:absolute;
    left:22px;
    right:22px;
    bottom:151px;
    height:1px;
    border-top:1px dashed rgba(255,158,186,.44);
    pointer-events:none;
}

.rush-danger span{
    position:absolute;
    left:50%;
    top:-11px;
    transform:translateX(-50%);
    padding:2px 8px;
    border-radius:7px;
    color:#ffc0d3;
    background:#2d243d;
    font-size:7px;
    font-weight:800;
    white-space:nowrap;
}

/* =========================
   PORTALS
========================= */

.rush-portals{
    position:absolute;
    left:12px;
    right:12px;
    bottom:12px;
    height:124px;
    display:grid;
    grid-template-columns:repeat(var(--count,4),1fr);
    gap:9px;
}

.rush-portal{
    position:relative;
    overflow:hidden;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:12px 10px 18px;
    border:1px solid rgba(201,190,255,.24);
    border-radius:17px;
    color:#efeaff;
    background:
        linear-gradient(180deg,rgba(124,103,241,.18),rgba(72,58,130,.20));
    backdrop-filter:blur(8px);
    font-size:9.5px;
    line-height:1.55;
    font-weight:900;
    text-align:center;
    transition:.16s ease;
}

.rush-portal::after{
    content:"";
    position:absolute;
    left:10px;
    right:10px;
    bottom:8px;
    height:5px;
    border-radius:999px;
    background:#7d6af2;
    box-shadow:0 0 18px rgba(125,106,242,.65);
}

.rush-portal.over{
    transform:translateY(-4px) scale(1.015);
    border-color:#aa9cff;
    color:#fff;
    background:rgba(109,93,252,.30);
    box-shadow:0 12px 28px rgba(109,93,252,.16);
}

.rush-portal.good{
    border-color:rgba(79,220,161,.70);
    color:#dffbef;
    background:rgba(39,165,118,.23);
}

.rush-portal.good::after{
    background:#45d49b;
    box-shadow:0 0 18px rgba(69,212,155,.70);
}

.rush-portal.bad{
    border-color:rgba(255,112,128,.70);
    color:#ffe4e8;
    background:rgba(216,91,104,.22);
}

.rush-portal.bad::after{
    background:#e96876;
    box-shadow:0 0 18px rgba(233,104,118,.66);
}

/* =========================
   FALLING SKILL CARD
========================= */

.rush-token{
    position:absolute;
    top:0;
    left:0;
    right:auto;

    width:190px;
    min-height:78px;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:12px 15px;

    border:2px solid #cfc6f4;
    border-radius:19px;

    color:#2e2840;
    background:
        linear-gradient(145deg,#ffffff 0%,#f7f4ff 100%);

    box-shadow:
        0 16px 38px rgba(5,2,19,.28),
        0 0 0 1px rgba(255,255,255,.65) inset;

    font-size:13.5px;
    line-height:1.65;
    font-weight:900;
    text-align:center;

    cursor:grab;
    pointer-events:auto;
    touch-action:none;
    user-select:none;
    z-index:5;

    will-change:transform;
    animation:rushCardGlow .75s ease-in-out infinite alternate;
}

.rush-token::before{
    content:"";
    position:absolute;
    inset:5px;
    border-radius:14px;
    border:1px solid rgba(109,93,252,.08);
    pointer-events:none;
}

.rush-token-label{
    position:relative;
    z-index:2;
    display:block;
    animation:rushLabelFloat .55s ease-in-out infinite alternate;
}

@keyframes rushCardGlow{
    from{
        border-color:#cfc6f4;
        box-shadow:
            0 14px 32px rgba(5,2,19,.24),
            0 0 0 1px rgba(255,255,255,.65) inset;
    }
    to{
        border-color:#9e8ef1;
        box-shadow:
            0 20px 44px rgba(55,37,137,.34),
            0 0 22px rgba(109,93,252,.16);
    }
}

@keyframes rushLabelFloat{
    from{transform:translateY(-2px)}
    to{transform:translateY(2px)}
}

.rush-token.drag{
    cursor:grabbing;
    z-index:30;
    border-color:#8f7cf3;
    box-shadow:
        0 24px 55px rgba(25,15,74,.36),
        0 0 28px rgba(109,93,252,.22);
}

/* GOLD */
.rush-token.gold{
    border-color:#f2cd65;
    color:#624a12;
    background:
        linear-gradient(145deg,#fffef7 0%,#fff2bf 100%);
    animation:rushGoldGlow .65s ease-in-out infinite alternate;
}

.rush-token.gold::after{
    content:"x2";
    position:absolute;
    top:-9px;
    right:-9px;
    min-width:30px;
    height:24px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:0 6px;
    border-radius:9px;
    color:#634b10;
    background:linear-gradient(135deg,#ffe892,#f3c649);
    box-shadow:0 8px 18px rgba(204,158,44,.28);
    font-size:8px;
    font-weight:900;
}

@keyframes rushGoldGlow{
    from{
        box-shadow:0 15px 34px rgba(80,60,10,.22);
    }
    to{
        box-shadow:
            0 21px 44px rgba(141,105,18,.32),
            0 0 25px rgba(245,196,77,.24);
    }
}

.rush-feedback{
    min-height:30px;
    padding-top:10px;
    text-align:center;
    font-size:10px;
    font-weight:900;
}

.rush-feedback.good{
    color:var(--rush-good);
}

.rush-feedback.bad{
    color:var(--rush-bad);
}

/* =========================
   RESULT
========================= */

.rush-final{
    width:154px;
    height:154px;
    margin:22px auto 13px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    border:1px solid #dfd8f2;
    border-radius:50%;
    background:linear-gradient(145deg,#fff,#f6f2ff);
    box-shadow:0 18px 40px rgba(109,93,252,.10);
}

.rush-final strong{
    color:var(--rush-primary);
    font-size:42px;
    line-height:1;
    font-weight:900;
}

.rush-final span{
    margin-top:7px;
    color:#928b9e;
    font-size:9px;
    font-weight:700;
}

.rush-rank{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:36px;
    padding:0 14px;
    margin-bottom:20px;
    border-radius:12px;
    color:#6253d2;
    background:#f0edff;
    font-size:10px;
    font-weight:900;
}

.rush-result-grid{
    max-width:650px;
    margin:0 auto 23px;
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:10px;
}

.rush-result-item{
    padding:15px;
    border:1px solid #ebe6f3;
    border-radius:15px;
    background:#fbfaff;
}

.rush-result-item span{
    display:block;
    color:#9b95a3;
    font-size:8.5px;
    font-weight:700;
}

.rush-result-item strong{
    display:block;
    margin-top:4px;
    color:#393340;
    font-size:17px;
    font-weight:900;
}

.rush-actions{
    display:flex;
    justify-content:center;
    gap:10px;
    flex-wrap:wrap;
}

/* =========================
   MOBILE
========================= */

@media(max-width:800px){
    .rush-page{
        padding:20px 10px 44px;
    }

    .rush-center{
        padding:34px 16px;
    }

    .rush-game{
        padding:14px;
    }

    .rush-game-head{
        align-items:flex-start;
    }

    .rush-hud{
        grid-template-columns:repeat(2,1fr);
    }

    .rush-field{
        height:610px;
    }

    .rush-fall{
        bottom:212px;
    }

    .rush-danger{
        bottom:213px;
    }

    .rush-portals{
        height:192px;
        grid-template-columns:repeat(2,1fr) !important;
    }

    .rush-token{
        width:158px;
        min-height:72px;
        font-size:12px;
    }

    .rush-result-grid{
        grid-template-columns:1fr;
    }
}
</style>
@endpush

@section('content')

<div class="rush-page">
    <div class="rush-shell">

        {{-- START --}}
        <section class="rush-screen active" id="rushStart">
            <div class="rush-panel rush-center">

                <div class="rush-logo">
                    <i data-lucide="gamepad-2"></i>
                </div>

                <span class="rush-kicker">NASEJA ARCADE</span>

                <h1 class="rush-title">صيد المهارات</h1>

                <p class="rush-intro">
                    المهارات تنزل من <strong>منتصف الساحة</strong>.
                    اسحب كل بطاقة بسرعة إلى بوابة المجال المناسب قبل أن تصل إلى خط الخطر.
                </p>

                <div class="rush-rules">
                    <span class="rush-rule">
                        <i data-lucide="heart"></i>
                        3 قلوب
                    </span>

                    <span class="rush-rule">
                        <i data-lucide="timer"></i>
                        45 ثانية
                    </span>

                    <span class="rush-rule">
                        <i data-lucide="flame"></i>
                        Combo
                    </span>

                    <span class="rush-rule">
                        <i data-lucide="sparkles"></i>
                        بطاقة ذهبية x2
                    </span>
                </div>

                @if(count($gameCategories) >= 2 && count($gameSkills) >= 4)

                    <button
                        type="button"
                        class="rush-btn primary"
                        id="rushStartBtn"
                    >
                        <i data-lucide="play"></i>
                        ابدأ الجولة
                    </button>

                    <small class="rush-note">
                        اسحب البطاقة إلى المجال الصحيح — لا توجد أسئلة تقليدية.
                    </small>

                @else

                    <div class="rush-empty">
                        تحتاج اللعبة إلى مجالين نشطين على الأقل ومهارات مرتبطة بهما.
                    </div>

                @endif

            </div>
        </section>


        {{-- PLAY --}}
        <section class="rush-screen" id="rushPlay">
            <div class="rush-panel rush-game">

                <div class="rush-game-head">

                    <div class="rush-game-brand">
                        <div class="rush-game-badge">
                            <i data-lucide="crosshair"></i>
                        </div>

                        <div>
                            <strong>صيد المهارات</strong>
                            <span>اسحب المهارة إلى بوابتها قبل أن تفلت</span>
                        </div>
                    </div>

                    <div class="rush-live-wrap">
                        <span class="rush-live"></span>
                        الجولة نشطة
                    </div>

                </div>


                <div class="rush-hud">

                    <div class="rush-stat">
                        <span>النقاط</span>
                        <strong id="rushScore">0</strong>
                    </div>

                    <div class="rush-stat combo">
                        <span>Combo</span>
                        <strong id="rushCombo">0</strong>
                    </div>

                    <div class="rush-stat">
                        <span>القلوب</span>
                        <strong id="rushHearts">❤️❤️❤️</strong>
                    </div>

                    <div class="rush-stat timer">
                        <span>الوقت</span>
                        <strong id="rushTime">45</strong>
                    </div>

                </div>


                <div class="rush-progress">
                    <span id="rushProgress"></span>
                </div>


                <div class="rush-board">

                    <div class="rush-board-top">

                        <strong>
                            المهارات تنزل من منتصف الساحة
                        </strong>

                        <span
                            class="rush-speed"
                            id="rushSpeed"
                        >
                            1.0x
                        </span>

                    </div>


                    <div class="rush-field">

                        <div
                            class="rush-fall"
                            id="rushFall"
                        ></div>


                        <div class="rush-danger">
                            <span>
                                خط الخطر
                            </span>
                        </div>


                        <div
                            class="rush-portals"
                            id="rushPortals"
                        ></div>

                    </div>


                    <div
                        class="rush-feedback"
                        id="rushFeedback"
                        aria-live="polite"
                    ></div>

                </div>

            </div>
        </section>


        {{-- RESULT --}}
        <section class="rush-screen" id="rushResult">
            <div class="rush-panel rush-center">

                <div class="rush-logo">
                    <i data-lucide="trophy"></i>
                </div>

                <span class="rush-kicker">ROUND COMPLETE</span>

                <h2
                    class="rush-title"
                    id="rushResultTitle"
                >
                    أحسنت!
                </h2>


                <div class="rush-final">
                    <strong id="rushFinalScore">0</strong>
                    <span>نقطة</span>
                </div>


                <div
                    class="rush-rank"
                    id="rushRank"
                >
                    مستكشف نسيجة
                </div>


                <div class="rush-result-grid">

                    <div class="rush-result-item">
                        <span>تم صيدها</span>
                        <strong id="rushCaught">0</strong>
                    </div>

                    <div class="rush-result-item">
                        <span>أفضل Combo</span>
                        <strong id="rushBestCombo">0</strong>
                    </div>

                    <div class="rush-result-item">
                        <span>أفضل نتيجة</span>
                        <strong id="rushBestScore">0</strong>
                    </div>

                </div>


                <div class="rush-actions">

                    <button
                        type="button"
                        class="rush-btn primary"
                        id="rushAgainBtn"
                    >
                        <i data-lucide="rotate-ccw"></i>
                        العب مرة أخرى
                    </button>

                    <a
                        href="{{ route('explore') }}"
                        class="rush-btn secondary"
                    >
                        <i data-lucide="compass"></i>
                        الاستكشاف
                    </a>

                </div>

            </div>
        </section>

    </div>
</div>


<script>
(function () {
    "use strict";

    const categories = @json($gameCategories);
    const skills = @json($gameSkills);

    const startScreen = document.getElementById("rushStart");
    const playScreen = document.getElementById("rushPlay");
    const resultScreen = document.getElementById("rushResult");

    const startBtn = document.getElementById("rushStartBtn");
    const againBtn = document.getElementById("rushAgainBtn");

    const scoreEl = document.getElementById("rushScore");
    const comboEl = document.getElementById("rushCombo");
    const heartsEl = document.getElementById("rushHearts");
    const timeEl = document.getElementById("rushTime");
    const progressEl = document.getElementById("rushProgress");
    const speedEl = document.getElementById("rushSpeed");

    const fall = document.getElementById("rushFall");
    const portals = document.getElementById("rushPortals");
    const feedback = document.getElementById("rushFeedback");

    const finalScoreEl = document.getElementById("rushFinalScore");
    const caughtEl = document.getElementById("rushCaught");
    const bestComboEl = document.getElementById("rushBestCombo");
    const bestScoreEl = document.getElementById("rushBestScore");
    const rankEl = document.getElementById("rushRank");
    const resultTitleEl = document.getElementById("rushResultTitle");

    let active = [];
    let score = 0;
    let combo = 0;
    let bestCombo = 0;
    let hearts = 3;
    let caught = 0;
    let seconds = 45;
    let elapsed = 0;
    let finished = false;
    let lastFrame = 0;
    let lastSpawn = 0;
    let animationId = null;


    function show(screen) {
        [startScreen, playScreen, resultScreen].forEach(item => {
            if (item) item.classList.remove("active");
        });

        if (screen) {
            screen.classList.add("active");
        }
    }


    function renderHearts() {
        let result = "";

        for (let i = 0; i < 3; i++) {
            result += i < hearts ? "❤️" : "🖤";
        }

        heartsEl.textContent = result;
    }


    function speedMultiplier() {
        return 1 + Math.min(1.35, elapsed / 32);
    }


    function spawnInterval() {
        return Math.max(
            700,
            1380 - elapsed * 18
        );
    }


    function updateHud() {
        scoreEl.textContent = score;
        comboEl.textContent = combo;
        timeEl.textContent = Math.max(0, Math.ceil(seconds));

        progressEl.style.width =
            Math.max(0, (seconds / 45) * 100) + "%";

        speedEl.textContent =
            speedMultiplier().toFixed(1) + "x";

        renderHearts();
    }


    function buildPortals() {
        portals.innerHTML = "";

        portals.style.setProperty(
            "--count",
            Math.max(2, categories.length)
        );

        categories.forEach(category => {
            const portal = document.createElement("div");

            portal.className = "rush-portal";
            portal.dataset.categoryId = String(category.id);
            portal.textContent = category.name;

            portals.appendChild(portal);
        });
    }


    function say(text, type) {
        feedback.textContent = text;
        feedback.className =
            "rush-feedback " + (type || "");

        clearTimeout(say.timer);

        say.timer = setTimeout(() => {
            feedback.textContent = "";
            feedback.className = "rush-feedback";
        }, 850);
    }


    function flash(portal, className) {
        if (!portal) return;

        portal.classList.add(className);

        setTimeout(() => {
            portal.classList.remove(className);
        }, 430);
    }


    function removeToken(obj) {
        const index = active.indexOf(obj);

        if (index !== -1) {
            active.splice(index, 1);
        }

        if (obj.el && obj.el.parentNode) {
            obj.el.remove();
        }
    }


    function loseHeart(message, portal = null) {
        hearts--;
        combo = 0;

        if (portal) {
            flash(portal, "bad");
        }

        say(message, "bad");
        updateHud();

        if (hearts <= 0) {
            finish();
        }
    }


    function correct(obj, portal) {
        caught++;
        combo++;

        bestCombo = Math.max(
            bestCombo,
            combo
        );

        let points =
            10 +
            Math.min(
                (combo - 1) * 2,
                12
            );

        if (obj.gold) {
            points *= 2;
        }

        score += points;

        flash(portal, "good");

        say(
            "+" +
            points +
            (combo >= 2 ? " 🔥 Combo x" + combo : "") +
            (obj.gold ? " ✨ x2" : ""),
            "good"
        );

        removeToken(obj);
        updateHud();
    }


    function wrong(obj, portal) {
        removeToken(obj);

        loseHeart(
            "بوابة خاطئة — خسرت قلبًا",
            portal
        );
    }


    function missed(obj) {
        removeToken(obj);

        loseHeart(
            "أفلتت منك مهارة — خسرت قلبًا"
        );
    }


    function hitPortal(clientX, clientY) {
        let found = null;

        portals
            .querySelectorAll(".rush-portal")
            .forEach(portal => {

                portal.classList.remove("over");

                const rect =
                    portal.getBoundingClientRect();

                if (
                    clientX >= rect.left &&
                    clientX <= rect.right &&
                    clientY >= rect.top &&
                    clientY <= rect.bottom
                ) {
                    found = portal;
                }
            });

        return found;
    }


    function attachDrag(obj) {
        const el = obj.el;

        el.addEventListener("pointerdown", event => {
            if (finished) return;

            const areaRect =
                fall.getBoundingClientRect();

            const tokenRect =
                el.getBoundingClientRect();

            /*
             * نحول مكان البطاقة المرئي الحالي إلى إحداثيات فعلية
             * حتى لا تقفز البطاقة عند بدء السحب.
             */
            obj.x =
                tokenRect.left -
                areaRect.left;

            obj.y =
                tokenRect.top -
                areaRect.top;

            obj.dragging = true;
            obj.pointerId = event.pointerId;

            obj.dragOffsetX =
                event.clientX -
                tokenRect.left;

            obj.dragOffsetY =
                event.clientY -
                tokenRect.top;

            el.classList.add("drag");

            el.setPointerCapture(
                event.pointerId
            );

            event.preventDefault();
        });


        el.addEventListener("pointermove", event => {
            if (
                !obj.dragging ||
                obj.pointerId !== event.pointerId
            ) {
                return;
            }

            const areaRect =
                fall.getBoundingClientRect();

            obj.x =
                event.clientX -
                areaRect.left -
                obj.dragOffsetX;

            obj.y =
                event.clientY -
                areaRect.top -
                obj.dragOffsetY;

            obj.x =
                Math.max(
                    0,
                    Math.min(
                        areaRect.width - obj.w,
                        obj.x
                    )
                );

            /*
             * نسمح بالسحب إلى منطقة البوابات تحت منطقة السقوط.
             */
            obj.y =
                Math.max(
                    0,
                    Math.min(
                        areaRect.height -
                        obj.h +
                        142,
                        obj.y
                    )
                );

            el.style.transform =
                "translate3d(" +
                obj.x +
                "px," +
                obj.y +
                "px,0)";


            portals
                .querySelectorAll(".rush-portal")
                .forEach(portal => {

                    portal.classList.remove("over");

                    const portalRect =
                        portal.getBoundingClientRect();

                    if (
                        event.clientX >= portalRect.left &&
                        event.clientX <= portalRect.right &&
                        event.clientY >= portalRect.top &&
                        event.clientY <= portalRect.bottom
                    ) {
                        portal.classList.add("over");
                    }
                });

            event.preventDefault();
        });


        el.addEventListener("pointerup", event => {
            if (
                !obj.dragging ||
                obj.pointerId !== event.pointerId
            ) {
                return;
            }

            obj.dragging = false;

            el.classList.remove("drag");

            const portal =
                hitPortal(
                    event.clientX,
                    event.clientY
                );

            if (portal) {

                if (
                    String(obj.skill.category_id) ===
                    portal.dataset.categoryId
                ) {
                    correct(obj, portal);
                }
                else {
                    wrong(obj, portal);
                }
            }

            try {
                el.releasePointerCapture(
                    event.pointerId
                );
            }
            catch (error) {}
        });


        el.addEventListener("pointercancel", () => {
            obj.dragging = false;
            el.classList.remove("drag");
        });
    }


    /*
     * ==============================
     * CREATE FALLING SKILL
     * تبدأ من منتصف الساحة بالضبط
     * ==============================
     */
    function spawn() {
        if (
            finished ||
            active.length >= 5 ||
            !skills.length
        ) {
            return;
        }

        const skill =
            skills[
                Math.floor(
                    Math.random() *
                    skills.length
                )
            ];

        const el =
            document.createElement("div");

        el.className = "rush-token";

        el.innerHTML =
            '<span class="rush-token-label"></span>';

        el.querySelector(
            ".rush-token-label"
        ).textContent = skill.name;


        const gold =
            Math.random() < 0.16;

        if (gold) {
            el.classList.add("gold");
        }


        fall.appendChild(el);


        const w =
            el.offsetWidth || 190;

        const h =
            el.offsetHeight || 78;

        const areaW =
            fall.clientWidth || 700;


        /*
         * مهم:
         * left:0 موجود في CSS
         * وهنا نحسب منتصف المساحة بالضبط.
         */
        const centerX =
            (areaW - w) / 2;

        const x =
            Math.max(
                4,
                Math.min(
                    areaW - w - 4,
                    centerX
                )
            );


        const obj = {
            el: el,
            skill: skill,
            gold: gold,

            /*
             * مكان البداية من المنتصف
             */
            x: x,
            y: -h - 6,

            w: w,
            h: h,

            /*
             * سرعة حماسية
             */
            speed:
                (
                    50 +
                    Math.random() * 18
                ) *
                speedMultiplier(),

            /*
             * حركة يمين/يسار بسيطة أثناء النزول
             * مع بقاء نقطة البداية في المنتصف.
             */
            drift:
                8 +
                Math.random() * 7,

            driftPhase:
                Math.random() *
                Math.PI *
                2,

            dragging: false
        };


        el.style.transform =
            "translate3d(" +
            obj.x +
            "px," +
            obj.y +
            "px,0)";


        active.push(obj);

        attachDrag(obj);
    }


    function loop(timestamp) {
        if (finished) return;

        if (!lastFrame) {
            lastFrame = timestamp;
        }

        const delta =
            Math.min(
                0.04,
                (timestamp - lastFrame) / 1000
            );

        lastFrame = timestamp;

        elapsed += delta;
        seconds -= delta;


        if (
            timestamp - lastSpawn >=
            spawnInterval()
        ) {
            spawn();
            lastSpawn = timestamp;
        }


        const limit =
            fall.clientHeight;


        active
            .slice()
            .forEach(obj => {

                if (obj.dragging) {
                    return;
                }

                obj.y +=
                    obj.speed *
                    delta;


                /*
                 * حركة خفيفة تعطي حياة للكرت
                 * بدون أن يخرج من المنتصف بشكل مزعج.
                 */
                const driftX =
                    Math.sin(
                        elapsed * 3.2 +
                        obj.driftPhase
                    ) *
                    obj.drift;


                obj.el.style.transform =
                    "translate3d(" +
                    (obj.x + driftX) +
                    "px," +
                    obj.y +
                    "px,0)";


                if (
                    obj.y >
                    limit -
                    obj.h -
                    4
                ) {
                    missed(obj);
                }
            });


        updateHud();


        if (seconds <= 0) {
            finish();
            return;
        }


        animationId =
            requestAnimationFrame(
                loop
            );
    }


    function getRank() {
        if (score >= 260) {
            return "🏆 أسطورة نسيجة";
        }

        if (score >= 180) {
            return "🔥 صائد محترف";
        }

        if (score >= 110) {
            return "✨ صائد مهارات";
        }

        if (score >= 60) {
            return "🎯 مستكشف نسيجة";
        }

        return "🌱 مبتدئ نسيجة";
    }


    function getTitle() {
        if (score >= 260) {
            return "جولة خارقة! 🏆";
        }

        if (score >= 180) {
            return "صيد قوي جدًا! 🔥";
        }

        if (score >= 110) {
            return "أداء ممتاز ✨";
        }

        if (score >= 60) {
            return "جولة جميلة 🎯";
        }

        return "جرّب جولة ثانية 🌱";
    }


    function finish() {
        if (finished) return;

        finished = true;

        if (animationId) {
            cancelAnimationFrame(
                animationId
            );
        }

        active
            .slice()
            .forEach(removeToken);


        const key =
            "naseja_skill_rush_best_v3";

        const oldBest =
            parseInt(
                localStorage.getItem(key) || "0",
                10
            );

        const best =
            Math.max(
                oldBest,
                score
            );

        localStorage.setItem(
            key,
            String(best)
        );


        finalScoreEl.textContent =
            score;

        caughtEl.textContent =
            caught;

        bestComboEl.textContent =
            bestCombo;

        bestScoreEl.textContent =
            best;

        rankEl.textContent =
            getRank();

        resultTitleEl.textContent =
            getTitle();


        show(resultScreen);


        if (window.lucide) {
            window.lucide.createIcons();
        }
    }


    function start() {
        if (
            categories.length < 2 ||
            skills.length < 4
        ) {
            return;
        }

        active = [];

        score = 0;
        combo = 0;
        bestCombo = 0;
        hearts = 3;
        caught = 0;
        seconds = 45;
        elapsed = 0;
        finished = false;
        lastFrame = 0;
        lastSpawn = 0;


        buildPortals();
        updateHud();

        show(playScreen);


        setTimeout(() => {
            spawn();

            animationId =
                requestAnimationFrame(
                    loop
                );
        }, 250);


        if (window.lucide) {
            window.lucide.createIcons();
        }
    }


    if (startBtn) {
        startBtn.addEventListener(
            "click",
            start
        );
    }


    if (againBtn) {
        againBtn.addEventListener(
            "click",
            () => location.reload()
        );
    }


    if (window.lucide) {
        window.lucide.createIcons();
    }

})();
</script>

@endsection
