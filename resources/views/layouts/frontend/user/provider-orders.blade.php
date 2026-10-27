@extends('layouts.frontend.user')

@section('title', 'طلبات الخدمات الواردة | NASEJA')

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
.naseja-provider-orders{max-width:1100px;margin:0 auto;padding:26px 16px 70px;font-family:'Tajawal',sans-serif}
.naseja-provider-orders h1{margin:0 0 6px;color:#211f37;font-size:28px;font-weight:900}
.naseja-provider-orders .lead{margin:0 0 20px;color:#8a8da0;font-size:11px}
.naseja-provider-order-list{display:grid;gap:14px}
.naseja-provider-order{padding:20px;border:1px solid rgba(115,87,255,.11);border-radius:22px;background:#fff;box-shadow:0 12px 32px rgba(58,45,122,.065)}
.naseja-provider-order-top{display:flex;align-items:start;justify-content:space-between;gap:14px}
.naseja-provider-order h2{margin:0 0 7px;color:#27243d;font-size:16px;font-weight:900}
.naseja-provider-order p{margin:0;color:#74788c;font-size:11px;line-height:1.9}
.naseja-provider-order-meta{display:flex;flex-wrap:wrap;gap:7px;margin-top:13px}
.naseja-provider-order-meta span{padding:7px 10px;border-radius:10px;background:#f5f2ff;color:#6750d5;font-size:9.5px;font-weight:900}
.naseja-provider-order-status{white-space:nowrap;padding:8px 11px;border-radius:999px;background:#fff6df;color:#aa7719;font-size:10px;font-weight:900}
.naseja-provider-empty{padding:34px;border:1px dashed rgba(115,87,255,.25);border-radius:22px;text-align:center;color:#9295a7;background:rgba(115,87,255,.04)}
.naseja-provider-order-actions{display:flex;flex-wrap:wrap;gap:8px;margin-top:15px;padding-top:14px;border-top:1px solid rgba(115,87,255,.09)}
.naseja-provider-order-actions form{margin:0}
.naseja-provider-order-btn{min-height:38px;display:inline-flex;align-items:center;justify-content:center;padding:0 14px;border:0;border-radius:11px;font-family:inherit;font-size:10px;font-weight:900;cursor:pointer;transition:.2s ease}
.naseja-provider-order-btn:hover{transform:translateY(-1px)}
.naseja-provider-order-btn.accept{background:linear-gradient(135deg,#21c995,#20b8d6);color:#fff}
.naseja-provider-order-btn.reject{background:#fff1f4;color:#c94b60;border:1px solid #f2d2d9}
.naseja-provider-order-btn.start{background:linear-gradient(135deg,#7357ff,#3487ff);color:#fff}
.naseja-provider-order-btn.complete{background:linear-gradient(135deg,#15956f,#21c995);color:#fff}
.naseja-provider-order-btn.message{background:linear-gradient(135deg,#7357ff,#3487ff);color:#fff}
.naseja-provider-order-flash{margin:0 0 16px;padding:12px 14px;border:1px solid rgba(33,201,149,.20);border-radius:13px;background:#edfff8;color:#148662;font-size:11px;font-weight:900}
@media(max-width:650px){.naseja-provider-order-top{flex-direction:column}}
html[data-theme="dark"] .naseja-provider-order{background:#211f31;border-color:rgba(157,137,255,.15)}
html[data-theme="dark"] .naseja-provider-orders h1,
html[data-theme="dark"] .naseja-provider-order h2{color:#f3f1f8}
</style>

<div class="naseja-provider-orders" dir="rtl">
    <h1>طلبات الخدمات الواردة</h1>
    <p class="lead">الطلبات التي أرسلها العملاء إلى خدماتك.</p>

    @if(session('order_status_success'))
        <div class="naseja-provider-order-flash">
            {{ session('order_status_success') }}
        </div>
    @endif

    @if($orders->count())
        <div class="naseja-provider-order-list">
            @foreach($orders as $order)
                <article class="naseja-provider-order">
                    <div class="naseja-provider-order-top">
                        <div>
                            <h2>{{ $order->service?->title_ar ?? $order->service?->title_en ?? 'خدمة' }}</h2>
                            <p>{{ $order->requirements }}</p>
                        </div>

                        <span class="naseja-provider-order-status">
                            {{ $statusLabels[$order->status] ?? $order->status }}
                        </span>
                    </div>

                    <div class="naseja-provider-order-meta">
                        <span>العميل: {{ $order->customer?->name ?? '—' }}</span>

                        @if($order->price_snapshot !== null)
                            <span>
                                {{ $order->price_type_snapshot ?? 'السعر' }}
                                {{ number_format((float) $order->price_snapshot, 0) }}
                                ريال
                            </span>
                        @endif

                        @if($order->preferred_deadline)
                            <span>التسليم المفضل: {{ $order->preferred_deadline->format('Y/m/d') }}</span>
                        @endif

                        <span>{{ $order->created_at->format('Y/m/d H:i') }}</span>
                    </div>

                    <div class="naseja-provider-order-actions">
                        @if($order->status === 'pending')
                            <form method="POST" action="{{ route('provider.orders.accept', $order) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="naseja-provider-order-btn accept">
                                    قبول الطلب
                                </button>
                            </form>

                            <form method="POST" action="{{ route('provider.orders.reject', $order) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="naseja-provider-order-btn reject">
                                    رفض الطلب
                                </button>
                            </form>
                        @elseif($order->status === 'accepted')
                            <form method="POST" action="{{ route('provider.orders.start', $order) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="naseja-provider-order-btn start">
                                    بدء التنفيذ
                                </button>
                            </form>
                        @elseif($order->status === 'in_progress')
                            <form method="POST" action="{{ route('provider.orders.complete', $order) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="naseja-provider-order-btn complete">
                                    تم الإنجاز
                                </button>
                            </form>
                        @endif

                        @if(in_array($order->status, ['accepted', 'in_progress', 'completed'], true))
                            <form method="POST" action="{{ route('messages.start', $order) }}">
                                @csrf
                                <button type="submit" class="naseja-provider-order-btn message">
                                    مراسلة العميل
                                </button>
                            </form>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="naseja-provider-empty">
            لا توجد طلبات خدمات واردة حتى الآن.
        </div>
    @endif
</div>
@endsection
