@extends('layouts.frontend.user')

@section('title', 'طلباتي | NASEJA')

@section('content')
@php
    $statusLabels = [
        'pending' => 'قيد الانتظار',
        'accepted' => 'مقبول',
        'rejected' => 'مرفوض',
        'in_progress' => 'قيد التنفيذ',
        'completed' => 'مكتمل',
        'cancelled' => 'ملغي',
    ];
@endphp

<style>
.naseja-orders{max-width:1100px;margin:0 auto;padding:26px 16px 70px;font-family:'Tajawal',sans-serif}
.naseja-orders-head{display:flex;align-items:end;justify-content:space-between;gap:14px;margin-bottom:20px}
.naseja-orders-head h1{margin:0 0 6px;font-size:28px;font-weight:900;color:#211f37}
.naseja-orders-head p{margin:0;color:#8a8da0;font-size:11px}
.naseja-orders-list{display:grid;gap:14px}
.naseja-order-row{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:18px;padding:19px;border:1px solid rgba(115,87,255,.11);border-radius:22px;background:#fff;box-shadow:0 12px 32px rgba(58,45,122,.065)}
.naseja-order-row h2{margin:0 0 7px;font-size:16px;font-weight:900;color:#27243d}
.naseja-order-row p{margin:0;color:#85899c;font-size:10.5px;line-height:1.8}
.naseja-order-info{display:flex;flex-wrap:wrap;gap:7px;margin-top:12px}
.naseja-order-pill{padding:7px 10px;border-radius:10px;background:#f5f2ff;color:#6750d5;font-size:9.5px;font-weight:900}
.naseja-order-status{align-self:start;white-space:nowrap;padding:8px 11px;border-radius:999px;background:#fff6df;color:#aa7719;font-size:10px;font-weight:900}
.naseja-orders-empty{padding:34px;border:1px dashed rgba(115,87,255,.25);border-radius:22px;text-align:center;color:#9295a7;background:rgba(115,87,255,.04)}
.naseja-orders-success{margin-bottom:16px;padding:13px 15px;border:1px solid rgba(33,201,149,.20);border-radius:15px;background:#edfff8;color:#148662;font-size:11px;font-weight:900}
.naseja-order-actions{display:flex;flex-wrap:wrap;gap:8px;margin-top:13px}
.naseja-order-actions form{margin:0}
.naseja-order-message-btn{min-height:38px;padding:0 14px;border:0;border-radius:11px;background:linear-gradient(135deg,#7357ff,#3487ff);color:#fff;font-family:inherit;font-size:10px;font-weight:900;cursor:pointer}
@media(max-width:650px){.naseja-order-row{grid-template-columns:1fr}.naseja-orders-head{align-items:start;flex-direction:column}}
html[data-theme="dark"] .naseja-order-row{background:#211f31;border-color:rgba(157,137,255,.15)}
html[data-theme="dark"] .naseja-orders-head h1,
html[data-theme="dark"] .naseja-order-row h2{color:#f3f1f8}
</style>

<div class="naseja-orders" dir="rtl">
    <div class="naseja-orders-head">
        <div>
            <h1>طلباتي</h1>
            <p>كل طلبات الخدمات التي أرسلتها من حسابك.</p>
        </div>

        <a href="{{ route('explore') }}" class="public-profile-action-btn" style="width:auto;padding:0 18px;text-decoration:none">
            استكشاف أصحاب المهارات
        </a>
    </div>

    @if(session('order_success'))
        <div class="naseja-orders-success">{{ session('order_success') }}</div>
    @endif

    @if($orders->count())
        <div class="naseja-orders-list">
            @foreach($orders as $order)
                <article class="naseja-order-row">
                    <div>
                        <h2>{{ $order->service?->title_ar ?? $order->service?->title_en ?? 'خدمة' }}</h2>
                        <p>{{ $order->requirements }}</p>

                        <div class="naseja-order-info">
                            <span class="naseja-order-pill">صاحب المهارة: {{ $order->provider?->name ?? '—' }}</span>

                            @if($order->price_snapshot !== null)
                                <span class="naseja-order-pill">
                                    {{ $order->price_type_snapshot ?? 'السعر' }}
                                    {{ number_format((float) $order->price_snapshot, 0) }}
                                    ريال
                                </span>
                            @endif

                            @if($order->preferred_deadline)
                                <span class="naseja-order-pill">
                                    التسليم المفضل: {{ $order->preferred_deadline->format('Y/m/d') }}
                                </span>
                            @endif

                            <span class="naseja-order-pill">
                                {{ $order->created_at->format('Y/m/d H:i') }}
                            </span>
                        </div>

                        @if(in_array($order->status, ['accepted', 'in_progress', 'completed'], true))
                            <div class="naseja-order-actions">
                                <form method="POST" action="{{ route('messages.start', $order) }}">
                                    @csrf
                                    <button type="submit" class="naseja-order-message-btn">
                                        مراسلة صاحب المهارة
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <span class="naseja-order-status">
                        {{ $statusLabels[$order->status] ?? $order->status }}
                    </span>
                </article>
            @endforeach
        </div>
    @else
        <div class="naseja-orders-empty">
            لا توجد لديك طلبات خدمات حتى الآن.
        </div>
    @endif
</div>
@endsection
