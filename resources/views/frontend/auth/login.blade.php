@extends('layouts.frontend.app')

@section('title', 'تسجيل الدخول | NASEJA')
@section('description', 'سجّل دخولك إلى حسابك في نسيجة لمتابعة مهاراتك واستكشاف الخدمات وأصحاب المواهب في مكان واحد.')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
/* أنماط واجهة الدخول محصورة في هذه الصفحة. */
.naseja-signup, .naseja-signup * { box-sizing: border-box; }
.naseja-signup { --ink:#24213b; --muted:#66647b; --accent:#594be1; --line:#e5e4f2; font-family:'Cairo',sans-serif; direction:rtl; color:var(--ink); min-height:100vh; background:radial-gradient(circle at 88% 7%,#eeeaff 0,transparent 32%),radial-gradient(circle at 3% 93%,#eeeaff 0,transparent 27%),#f8f8fe; padding:34px 20px; }
.naseja-signup a { color:#4336be; text-decoration:none; font-weight:800; }
.naseja-signup a:hover { text-decoration:underline; }
.naseja-signup .signup-shell { width:min(1060px,100%); margin:auto; display:grid; grid-template-columns:minmax(0, .92fr) minmax(0,1.08fr); border:1px solid #e7e5f2; border-radius:26px; background:white; box-shadow:0 22px 70px rgba(42,36,96,.09); overflow:hidden; }
.naseja-signup .signup-aside { position:relative; overflow:hidden; padding:46px 42px; background:linear-gradient(155deg,#3931a4 0%,#6153e3 57%,#7c6ef0 100%); color:white; display:flex; flex-direction:column; min-height:680px; }
.naseja-signup .signup-aside:before,.naseja-signup .signup-aside:after { content:''; position:absolute; width:370px; height:370px; border:1px solid rgba(255,255,255,.15); border-radius:50%; pointer-events:none; }
.naseja-signup .signup-aside:before { top:-190px; left:-135px; box-shadow:0 0 0 48px rgba(255,255,255,.045),0 0 0 100px rgba(255,255,255,.035); }
.naseja-signup .signup-aside:after { bottom:-270px; right:-125px; box-shadow:0 0 0 55px rgba(255,255,255,.045); }
.naseja-signup .signup-brand { position:relative; z-index:1; display:flex; align-items:center; gap:12px; direction:ltr; width:max-content; font-family:'Cairo',sans-serif; font-size:25px; font-weight:900; letter-spacing:.07em; color:white; }
.naseja-signup .signup-mark { width:44px; height:44px; display:grid; place-items:center; border-radius:13px; background:rgba(255,255,255,.19); border:1px solid rgba(255,255,255,.4); font-size:27px; letter-spacing:0; }
.naseja-signup .signup-aside-body { position:relative; z-index:1; margin:auto 0; padding:60px 0; }
.naseja-signup .signup-eyebrow { display:inline-flex; align-items:center; gap:9px; border:1px solid rgba(255,255,255,.28); border-radius:999px; padding:5px 13px; background:rgba(255,255,255,.1); font-weight:700; font-size:12px; }
.naseja-signup .signup-aside h2 { margin:24px 0 14px; font-size:clamp(30px,3.5vw,46px); line-height:1.45; font-weight:900; color:white; }
.naseja-signup .signup-aside p { color:#f0eeff; font-size:15px; line-height:2.05; max-width:380px; margin:0; }
.naseja-signup .signup-perks { position:relative; z-index:1; display:grid; gap:12px; }
.naseja-signup .signup-perk { display:flex; align-items:center; gap:13px; padding:12px 14px; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.16); border-radius:15px; font-size:13px; font-weight:700; }
.naseja-signup .perk-symbol { display:grid; place-items:center; flex:0 0 30px; width:30px; height:30px; background:rgba(255,255,255,.18); border-radius:9px; font-size:16px; }
.naseja-signup .signup-main { padding:44px clamp(24px,5vw,65px) 34px; }
.naseja-signup .signup-mobile-brand { display:none; }
.naseja-signup .signup-kicker { color:var(--accent); font-size:12px; font-weight:900; margin:0 0 4px; }
.naseja-signup h1 { font-size:30px; margin:0; line-height:1.5; font-weight:900; color:var(--ink); }
.naseja-signup .signup-intro { color:var(--muted); margin:3px 0 21px; font-size:13px; line-height:1.9; }
.naseja-signup .signup-account { display:flex; align-items:center; gap:12px; border:1px solid #ddd9fa; background:#f8f7ff; border-radius:15px; padding:12px 14px; margin-bottom:19px; }
.naseja-signup .account-icon { display:grid; place-items:center; flex:0 0 39px; width:39px; height:39px; border-radius:11px; background:#e8e5ff; color:#4f40d0; font-size:20px; font-weight:900; }
.naseja-signup .account-copy { display:grid; line-height:1.5; min-width:0; }
.naseja-signup .account-copy strong { font-size:13px; font-weight:900; }
.naseja-signup .account-copy small { color:var(--muted); font-size:11px; }
.naseja-signup .account-change { margin-right:auto; white-space:nowrap; font-size:11px; }
.naseja-signup .signup-field { margin-bottom:15px; }
.naseja-signup .signup-field label { display:block; font-size:12px; font-weight:800; margin-bottom:6px; color:var(--ink); }
.naseja-signup .signup-input-wrap { position:relative; }
.naseja-signup .signup-field input { display:block; width:100%; height:49px; border:1px solid #dcdbea; border-radius:11px; background:#fff; color:var(--ink); padding:0 14px; font:600 13px 'Cairo',sans-serif; outline:none; transition:border-color .15s,box-shadow .15s; }
.naseja-signup .signup-field input::placeholder { color:#9693a8; opacity:1; }
.naseja-signup .signup-field input:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(89,75,225,.13); }
.naseja-signup .signup-field input[aria-invalid="true"] { border-color:#bd435e; }
.naseja-signup .signup-input-wrap:has(.signup-eye) input { padding-left:52px; }
.naseja-signup .signup-eye { position:absolute; top:3px; left:3px; width:44px; height:43px; border:0; border-radius:9px; background:transparent; color:#514c78; cursor:pointer; font:700 11px 'Cairo',sans-serif; }
.naseja-signup .signup-eye:hover,.naseja-signup .signup-eye:focus-visible { background:#f0eeff; }
.naseja-signup .signup-error { color:#a6324d; font-size:11px; font-weight:700; margin-top:5px; }
.naseja-signup .signup-submit { width:100%; min-height:51px; margin-top:6px; padding:10px 18px; display:flex; justify-content:center; align-items:center; gap:12px; border:0; border-radius:11px; background:#5749d9; color:white; font:900 14px 'Cairo',sans-serif; cursor:pointer; box-shadow:0 8px 18px rgba(79,65,193,.18); }
.naseja-signup .signup-submit:hover { background:#4435bc; }
.naseja-signup .signup-submit:focus-visible,.naseja-signup a:focus-visible { outline:3px solid #978bfd; outline-offset:3px; }
.naseja-signup .signup-login { text-align:center; color:var(--muted); margin:17px 0 0; font-size:12px; }
.naseja-signup .signup-terms { text-align:center; color:#77748a; border-top:1px solid var(--line); padding-top:16px; margin:20px 0 0; font-size:11px; line-height:2; }
@media(max-width:800px) { .naseja-signup { padding:18px 12px; } .naseja-signup .signup-shell { grid-template-columns:1fr; max-width:520px; } .naseja-signup .signup-aside { display:none; } .naseja-signup .signup-main { padding:26px 23px 28px; } .naseja-signup .signup-mobile-brand { display:flex; align-items:center; gap:8px; width:max-content; margin:0 0 23px; font-size:17px; font-weight:900; color:#3e36a9; direction:ltr; } .naseja-signup .signup-mobile-brand span { width:32px; height:32px; display:grid; place-items:center; border-radius:9px; color:#fff; background:#5749d9; font-size:19px; } }
@media(max-width:380px) { .naseja-signup .signup-main { padding:23px 17px; } .naseja-signup h1 { font-size:25px; } }
@media(prefers-reduced-motion:reduce) { .naseja-signup .signup-field input { transition:none; } }

.naseja-login .signup-aside { min-height:590px; }
.naseja-login .signup-main { display:flex; flex-direction:column; justify-content:center; }
.naseja-login .login-options { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin:3px 0 17px; font-size:12px; }
.naseja-login .remember-me { display:inline-flex; gap:8px; align-items:center; cursor:pointer; font-weight:700; color:var(--muted); }
.naseja-login .remember-me input { width:17px; height:17px; accent-color:#5749d9; }
@media(max-width:800px) { .naseja-login .signup-main { min-height:500px; } }
</style>

<main class="naseja-signup naseja-login" dir="rtl">
    <div class="signup-shell">
        <aside class="signup-aside" aria-label="التعريف بنسيجة">
            <div class="signup-brand"><span class="signup-mark">N</span><span>NASEJA</span></div>
            <div class="signup-aside-body">
                <span class="signup-eyebrow">✦ أهلًا بعودتك</span>
                <h2>أكمل رحلتك<br>من حيث بدأت.</h2>
                <p>ادخل إلى حسابك، واستكشف أصحاب المهارات والخدمات، وتابع ما يهمك في نسيجة.</p>
            </div>
            <div class="signup-perks">
                <div class="signup-perk"><span class="perk-symbol">✦</span><span>مجتمع للمهارات والخدمات</span></div>
                <div class="signup-perk"><span class="perk-symbol">↗</span><span>كل ما يهمك في مكان واحد</span></div>
            </div>
        </aside>

        <section class="signup-main" aria-labelledby="login-title">
            <div class="signup-mobile-brand"><span>N</span>NASEJA</div>
            <p class="signup-kicker">مرحبًا بعودتك إلى نسيجة</p>
            <h1 id="login-title">تسجيل الدخول</h1>
            <p class="signup-intro">أدخل بريدك الإلكتروني وكلمة المرور للمتابعة.</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="signup-field">
                    <label for="email">البريد الإلكتروني</label>
                    <div class="signup-input-wrap"><input id="email" name="email" type="email" dir="ltr" value="{{ old('email') }}" placeholder="example@email.com" autocomplete="email" required @error('email') aria-invalid="true" aria-describedby="email-error" @enderror></div>
                    @error('email')<div class="signup-error" id="email-error" role="alert">{{ $message }}</div>@enderror
                </div>
                <div class="signup-field">
                    <label for="password">كلمة المرور</label>
                    <div class="signup-input-wrap"><input id="password" name="password" type="password" placeholder="أدخل كلمة المرور" autocomplete="current-password" required @error('password') aria-invalid="true" aria-describedby="password-error" @enderror><button class="signup-eye" type="button" aria-label="إظهار كلمة المرور" aria-pressed="false">إظهار</button></div>
                    @error('password')<div class="signup-error" id="password-error" role="alert">{{ $message }}</div>@enderror
                </div>

                <div class="login-options">
                    <label class="remember-me"><input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}><span>تذكرني</span></label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}">نسيت كلمة المرور؟</a>
                    @endif
                </div>
                <button class="signup-submit" type="submit">تسجيل الدخول <span aria-hidden="true">←</span></button>
            </form>
            <p class="signup-login">ليس لديك حساب؟ <a href="{{ route('register') }}">إنشاء حساب</a></p>
        </section>
    </div>
</main>
@endsection

@section('scripts')
<script>
(function() {
    var button = document.querySelector('.naseja-login .signup-eye');
    var input = document.getElementById('password');
    if (!button || !input) return;
    button.addEventListener('click', function() {
        var visible = input.type === 'password';
        input.type = visible ? 'text' : 'password';
        button.textContent = visible ? 'إخفاء' : 'إظهار';
        button.setAttribute('aria-pressed', visible ? 'true' : 'false');
        button.setAttribute('aria-label', visible ? 'إخفاء كلمة المرور' : 'إظهار كلمة المرور');
    });
})();
</script>
@endsection
