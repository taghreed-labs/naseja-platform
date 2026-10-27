@extends('layouts.frontend.user')

@section('title', 'طلب خدمة | NASEJA')

@section('content')
<style>
.naseja-order-page{max-width:980px;margin:0 auto;padding:26px 16px 70px;font-family:'Tajawal',sans-serif}
.naseja-order-head{margin-bottom:18px}
.naseja-order-head h1{margin:0 0 7px;font-size:28px;font-weight:900;color:#211f37}
.naseja-order-head p{margin:0;color:#85899c;font-size:12px;line-height:1.8}
.naseja-order-grid{display:grid;grid-template-columns:minmax(0,1fr) 330px;gap:18px;align-items:start}
.naseja-order-card{border:1px solid rgba(115,87,255,.11);border-radius:24px;background:#fff;box-shadow:0 18px 50px rgba(58,45,122,.08);padding:22px}
.naseja-order-service{background:linear-gradient(145deg,#f8f5ff,#f2f9ff)}
.naseja-order-service h2{margin:0 0 10px;font-size:18px;font-weight:900;color:#24213a}
.naseja-order-service p{margin:0;color:#7e8295;font-size:11px;line-height:1.9}
.naseja-order-meta{display:flex;flex-wrap:wrap;gap:8px;margin-top:15px}
.naseja-order-chip{display:inline-flex;align-items:center;gap:6px;padding:8px 10px;border-radius:11px;background:#fff;color:#6652cf;font-size:10px;font-weight:900}
.naseja-order-label{display:block;margin:0 0 8px;color:#454156;font-size:12px;font-weight:900}
.naseja-order-field{margin-bottom:17px}
.naseja-order-field textarea,.naseja-order-field input{width:100%;border:1px solid #e7e3ef;border-radius:15px;background:#fcfbff;color:#302d43;font-family:inherit;font-size:12px;outline:none;padding:13px 14px}
.naseja-order-field textarea{min-height:180px;resize:vertical;line-height:1.9}
.naseja-order-field textarea:focus,.naseja-order-field input:focus{border-color:#8f79f1;box-shadow:0 0 0 4px rgba(115,87,255,.07)}
.naseja-order-errors{margin-bottom:16px;padding:12px 14px;border:1px solid #f1d1d8;border-radius:13px;background:#fff1f4;color:#bd4054;font-size:11px;line-height:1.8}
.naseja-order-actions{display:flex;gap:10px;justify-content:flex-end}
.naseja-order-submit,.naseja-order-back{min-height:44px;display:inline-flex;align-items:center;justify-content:center;border-radius:13px;padding:0 18px;font-family:inherit;font-size:11px;font-weight:900;text-decoration:none;cursor:pointer}
.naseja-order-submit{border:0;background:linear-gradient(135deg,#7357ff,#3487ff);color:#fff;box-shadow:0 12px 25px rgba(115,87,255,.22)}
.naseja-order-back{border:1px solid #e5e1ed;background:#fff;color:#6f6b7e}
.naseja-order-provider{margin-top:18px;padding-top:15px;border-top:1px solid rgba(115,87,255,.10);font-size:11px;color:#7f8292}
.naseja-order-provider strong{color:#3f3a58}
@media(max-width:850px){.naseja-order-grid{grid-template-columns:1fr}.naseja-order-summary{order:-1}}
html[data-theme="dark"] .naseja-order-card{background:#211f31;border-color:rgba(157,137,255,.16)}
html[data-theme="dark"] .naseja-order-head h1,
html[data-theme="dark"] .naseja-order-service h2,
html[data-theme="dark"] .naseja-order-label{color:#f3f1f8}
html[data-theme="dark"] .naseja-order-field textarea,
html[data-theme="dark"] .naseja-order-field input,
html[data-theme="dark"] .naseja-order-chip{background:#29273a;color:#e6e2ef;border-color:#3b384b}
</style>

<div class="naseja-order-page" dir="rtl">
    <div class="naseja-order-head">
        <h1>طلب خدمة</h1>
        <p>اكتب تفاصيل طلبك بوضوح، وسيظهر الطلب لصاحب المهارة داخل حسابه.</p>
    </div>

    <div class="naseja-order-grid">
        <div class="naseja-order-card">
            @if($errors->any())
                <div class="naseja-order-errors">
                    @foreach($errors->all() as $error)
                        <div>• {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('orders.store', $service) }}">
                @csrf

                <div class="naseja-order-field">
                    <label class="naseja-order-label" for="requirements">تفاصيل الطلب *</label>
                    <textarea
                        id="requirements"
                        name="requirements"
                        maxlength="3000"
                        required
                        placeholder="اشرح ما الذي تحتاجه، المواصفات المطلوبة، وأي تفاصيل مهمة..."
                    >{{ old('requirements') }}</textarea>
                </div>

                <div class="naseja-order-field">
                    <label class="naseja-order-label" for="preferred_deadline">موعد التسليم المفضل (اختياري)</label>
                    <input
                        id="preferred_deadline"
                        type="date"
                        name="preferred_deadline"
                        min="{{ now()->format('Y-m-d') }}"
                        value="{{ old('preferred_deadline') }}"
                    >
                </div>

                <div class="naseja-order-actions">
                    <a
                        href="{{ route('users.show', ['slug' => $service->user->profile->slug]) }}"
                        class="naseja-order-back"
                    >
                        رجوع
                    </a>

                    <button type="submit" class="naseja-order-submit">
                        إرسال الطلب
                    </button>
                </div>
            </form>
        </div>

        <aside class="naseja-order-card naseja-order-service naseja-order-summary">
            <h2>{{ $service->title_ar ?? $service->title_en }}</h2>

            @if($service->description_ar || $service->description_en)
                <p>{{ $service->description_ar ?? $service->description_en }}</p>
            @endif

            <div class="naseja-order-meta">
                @if($service->price_type === 'حسب الطلب')
                    <span class="naseja-order-chip">السعر حسب الطلب</span>
                @elseif($service->price !== null)
                    <span class="naseja-order-chip">
                        {{ $service->price_type === 'يبدأ من' ? 'يبدأ من' : 'السعر:' }}
                        {{ number_format((float) $service->price, 0) }}
                        ريال
                    </span>
                @endif

                @if($service->duration)
                    <span class="naseja-order-chip">{{ $service->duration }}</span>
                @endif
            </div>

            <div class="naseja-order-provider">
                صاحب المهارة:
                <strong>{{ $service->user->name }}</strong>
            </div>
        </aside>
    </div>
</div>
@endsection
