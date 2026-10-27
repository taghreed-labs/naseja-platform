<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#12122a">
    <meta name="description" content="NASEJA مجتمع المهارات والأعمال والخدمات. اكتشف أشخاصًا يصنعون الفرق.">
    <title>مرحبًا بك في NASEJA | اكتشف المهارات</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root{font-family:Cairo,Tahoma,sans-serif;color:#fff;background:#111126}*{box-sizing:border-box}body{margin:0}a{color:inherit;text-decoration:none}button{font:inherit}
        .page{min-height:100svh;isolation:isolate;overflow:hidden;position:relative;background:#111126}
        .page:before{content:"";position:absolute;inset:0;z-index:-2;background:radial-gradient(ellipse 54% 85% at 88% 60%,#413291 0%,#252152 42%,transparent 83%),radial-gradient(ellipse 48% 48% at 9% 98%,#163e4c 0,transparent 80%)}
        .page:after{content:"";position:absolute;inset:0;z-index:-1;pointer-events:none;opacity:.16;background-image:linear-gradient(#b5abea 1px,transparent 1px),linear-gradient(90deg,#b5abea 1px,transparent 1px);background-size:72px 72px;mask-image:linear-gradient(90deg,transparent 2%,#000 75%)}
        .container{width:min(100% - 84px,1390px);margin:auto}
        header{height:110px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #ffffff1b;gap:18px}
        .logo{display:inline-flex;align-items:center;gap:12px;font-size:24px;letter-spacing:.035em;font-weight:900;white-space:nowrap}.logo-symbol{width:45px;height:45px;display:grid;place-items:center;border:1px solid #b5a6ff6b;border-radius:13px;background:#ffffff18;font-size:25px;box-shadow:inset 0 1px #ffffff40}
        nav{display:flex;align-items:center;gap:9px;font-size:13px;font-weight:800}nav a{padding:10px 18px;border-radius:10px}nav .login{border:1px solid #ffffff45}nav .register{color:#c5bafc}
        main{min-height:calc(100svh - 172px);display:grid;grid-template-columns:minmax(0,1.06fr) minmax(0,.94fr);align-items:center;gap:4vw;padding:50px 0 65px}
        .intro{position:relative;z-index:2}.kicker{display:inline-flex;align-items:center;gap:10px;color:#c7bdff;font-size:13px;letter-spacing:.06em;font-weight:800}.kicker:before{content:"";width:29px;height:1px;background:#b6a8ff}
        h1{font-size:clamp(43px,5.4vw,82px);line-height:1.3;letter-spacing:-.055em;font-weight:900;margin:24px 0 20px}h1 em{font-style:normal;color:#ae9cff}h1 .line{display:block}
        .summary{max-width:575px;color:#d3d0e5;font-size:clamp(15px,1.35vw,18px);line-height:2.05;margin:0 0 32px;font-weight:500}
        .actions{display:flex;align-items:center;gap:14px;flex-wrap:wrap}.cta{display:inline-flex;justify-content:space-between;align-items:center;gap:25px;min-height:62px;padding:11px 24px;border-radius:12px;background:#e6e0ff;color:#241653;font-weight:900;font-size:15px;box-shadow:0 15px 44px #09071750;transition:transform .2s,background .2s}.cta:hover{transform:translateY(-3px);background:white}.cta b{font-size:23px;font-weight:500}.text-link{font-size:14px;font-weight:800;color:#ded8ff;padding:14px}
        .footnote{display:flex;align-items:center;gap:13px;margin-top:55px;color:#aaa7c5;font-size:12px;font-weight:700}.footnote i{display:block;width:32px;height:1px;background:#817bb1}
        .stage{height:min(610px,65vw);min-height:490px;position:relative;display:grid;place-items:center;perspective:900px}
        .orbit{position:absolute;width:min(94%,535px);aspect-ratio:1;border:1px solid #a997e94d;border-radius:50%;transform:rotate(-19deg)}.orbit:before,.orbit:after{content:"";position:absolute;inset:12%;border:1px solid #b3a0e738;border-radius:50%}.orbit:after{inset:25%}
        .disc{position:relative;width:min(77%,440px);aspect-ratio:1;border-radius:50%;background:radial-gradient(circle at 35% 22%,#ae95ff,#6c52cd 35%,#392683 67%,#1c174c 100%);box-shadow:inset 15px 15px 40px #ffffff34,inset -22px -35px 65px #0b0c36b2,0 36px 90px #060617a3;display:grid;place-items:center;transform:rotate(-12deg)}
        .disc:before{content:"";position:absolute;inset:12%;border:1px solid #ffffff40;border-radius:50%}.disc:after{content:"";position:absolute;inset:26%;border:1px solid #ffffff24;border-radius:50%}
        .monogram{font-family:Georgia,serif;font-size:clamp(130px,17vw,250px);line-height:1;color:#fff;text-shadow:5px 12px 3px #100a4b38;transform:rotate(12deg);font-style:italic;position:relative;z-index:1}
        .badge{position:absolute;z-index:2;border:1px solid #ffffff5c;background:#241e55cc;backdrop-filter:blur(15px);border-radius:13px;padding:12px 17px;box-shadow:0 16px 35px #07051657;font-size:12px;font-weight:800;white-space:nowrap}.badge i{font-style:normal;margin-left:6px;color:#c4b5ff}.badge.one{top:9%;right:0}.badge.two{bottom:17%;left:0}.badge.three{bottom:4%;right:18%;background:#d5caff;color:#251a55;border:0}.badge.three i{color:#5b41b8}
        .spark{position:absolute;width:9px;height:9px;border-radius:50%;background:#cbafff;box-shadow:0 0 28px 9px #bf9aff9c}.spark.a{top:7%;left:27%}.spark.b{bottom:30%;right:3%;width:5px;height:5px}
        footer{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:20px 0 27px;border-top:1px solid #ffffff1b;color:#aaa6c9;font-size:12px;font-weight:700}footer span:last-child{direction:ltr}
        a:focus-visible{outline:3px solid #d2c3ff;outline-offset:4px}
        @media(max-width:920px){.container{width:min(100% - 42px,680px)}header{height:80px}main{grid-template-columns:1fr;text-align:center;padding:55px 0 28px;gap:15px}.kicker{justify-content:center}.summary{margin-left:auto;margin-right:auto}.actions,.footnote{justify-content:center}.footnote{margin-top:30px}.stage{height:480px;min-height:0;width:min(100%,500px);margin:auto}.badge.one{right:3%}.badge.two{left:3%}.disc{width:73%}}
        @media(max-width:540px){.container{width:calc(100% - 36px)}header{height:72px}.logo{font-size:18px;gap:8px}.logo-symbol{width:36px;height:36px;font-size:20px}nav{font-size:11px}nav a{padding:7px 9px}nav .register{display:none}main{padding:42px 0 12px}.kicker{font-size:11px}h1{font-size:clamp(38px,10vw,54px);margin:19px 0 15px;line-height:1.38}.summary{font-size:13px;line-height:1.95;margin-bottom:22px}.actions{display:grid;gap:4px}.cta{min-height:55px;width:100%;font-size:13px}.text-link{font-size:12px}.footnote{display:none}.stage{height:320px;width:min(100%,350px)}.disc{width:68%}.monogram{font-size:120px}.badge{font-size:9px;padding:8px 9px}.badge.one{top:7%;right:1%}.badge.two{bottom:21%;left:0}.badge.three{bottom:4%;right:12%}footer{font-size:10px;padding:15px 0}}
        @media(prefers-reduced-motion:no-preference){.disc{animation:float 7s ease-in-out infinite}.badge{animation:float 6s ease-in-out infinite alternate}@keyframes float{50%{translate:0 -11px}}}
    </style>
</head>
<body>
<div class="page">
    <div class="container">
        <header>
            <a class="logo" href="{{ route('explore') }}" aria-label="NASEJA"><span class="logo-symbol" aria-hidden="true">N</span><span>NASEJA</span></a>
            <nav aria-label="الحساب"><a class="register" href="{{ route('start-register') }}">انضم إلينا</a><a class="login" href="{{ route('login') }}">تسجيل الدخول</a></nav>
        </header>
        <main>
            <section class="intro" aria-labelledby="welcome-title">
                <span class="kicker">مرحبًا بك في عالم NASEJA</span>
                <h1 id="welcome-title"><span class="line">خلف كل مهارة</span><span class="line"><em>حكاية تستحق</em> أن تُرى.</span></h1>
                <p class="summary">مساحة تلتقي فيها المواهب بالفرص. اكتشف أصحاب المهارات، تصفّح أعمالهم، واعثر على الخدمة التي تبحث عنها بكل سهولة.</p>
                <div class="actions"><a class="cta" href="{{ route('explore') }}">ابدأ الاستكشاف <b aria-hidden="true">←</b></a><a class="text-link" href="{{ route('start-register') }}">عندك مهارة؟ انضم إلى المجتمع ←</a></div>
                <div class="footnote"><i></i> اكتشف. تواصل. اصنع فرصتك.</div>
            </section>
            <div class="stage" aria-hidden="true"><div class="orbit"></div><div class="disc"><span class="monogram">N</span></div><div class="badge one"><i>✦</i> مهارات متنوعة</div><div class="badge two"><i>✳</i> أعمال مميزة</div><div class="badge three"><i>↗</i> فرص تبدأ هنا</div><span class="spark a"></span><span class="spark b"></span></div>
        </main>
        <footer><span>© {{ date('Y') }} NASEJA</span><span>WHERE SKILLS FIND THEIR PLACE</span></footer>
    </div>
</div>
</body>
</html>
