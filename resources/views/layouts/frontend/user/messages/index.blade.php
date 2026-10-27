@extends('layouts.frontend.user')

@section('title', 'الرسائل | NASEJA')

@section('content')
<style>
.naseja-messages{max-width:1050px;margin:0 auto;padding:26px 16px 70px;font-family:'Cairo',sans-serif}
.naseja-messages-head{margin-bottom:18px}
.naseja-messages-head h1{margin:0 0 6px;font-size:28px;font-weight:900;color:#211f37}
.naseja-messages-head p{margin:0;color:#8b8da0;font-size:11px}
.naseja-conversation-list{display:grid;gap:12px}
.naseja-conversation-card{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:14px;align-items:center;padding:17px 18px;background:#fff;border:1px solid rgba(115,87,255,.11);border-radius:20px;box-shadow:0 11px 30px rgba(58,45,122,.055);text-decoration:none;color:inherit;transition:.2s ease}
.naseja-conversation-card:hover{transform:translateY(-1px);border-color:rgba(115,87,255,.25)}
.naseja-conversation-name{margin:0 0 5px;color:#29253e;font-size:14px;font-weight:900}
.naseja-conversation-service{margin-bottom:7px;color:#7158d8;font-size:10px;font-weight:900}
.naseja-conversation-preview{margin:0;color:#828596;font-size:10.5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:650px}
.naseja-conversation-side{text-align:left;display:grid;gap:7px;justify-items:end}
.naseja-conversation-time{color:#9a9ca9;font-size:9px;font-weight:700}
.naseja-unread{min-width:25px;height:25px;padding:0 7px;display:inline-flex;align-items:center;justify-content:center;border-radius:999px;background:#7357ff;color:#fff;font-size:9px;font-weight:900}
.naseja-messages-empty{padding:36px 20px;text-align:center;border:1px dashed rgba(115,87,255,.25);border-radius:22px;background:rgba(115,87,255,.04);color:#8e91a2;font-size:11px}
html[data-theme="dark"] .naseja-conversation-card{background:#211f31;border-color:rgba(157,137,255,.15)}
html[data-theme="dark"] .naseja-messages-head h1,
html[data-theme="dark"] .naseja-conversation-name{color:#f3f1f8}
@media(max-width:650px){.naseja-conversation-card{grid-template-columns:1fr}.naseja-conversation-side{text-align:right;justify-items:start}}
</style>

<div class="naseja-messages" dir="rtl">
    <div class="naseja-messages-head">
        <h1>الرسائل</h1>
        <p>محادثاتك المرتبطة بطلبات الخدمات المقبولة.</p>
    </div>

    @if($conversations->count())
        <div class="naseja-conversation-list">
            @foreach($conversations as $conversation)
                @php
                    $other = $conversation->participants
                        ->first(fn($participant) => $participant->id !== $user->id);

                    $order = $conversation->serviceOrder;
                    $serviceTitle = $order?->service?->title_ar
                        ?? $order?->service?->title_en
                        ?? 'محادثة';
                    $last = $conversation->latestMessage;
                @endphp

                <a
                    href="{{ route('messages.show', $conversation) }}"
                    class="naseja-conversation-card"
                >
                    <div>
                        <div class="naseja-conversation-name">
                            {{ $other?->name ?? 'مستخدم NASEJA' }}
                        </div>

                        <div class="naseja-conversation-service">
                            طلب: {{ $serviceTitle }}
                            @if($order)
                                · #{{ $order->id }}
                            @endif
                        </div>

                        <p class="naseja-conversation-preview">
                            @if($last)
                                {{ $last->sender_id === $user->id ? 'أنت: ' : '' }}{{ $last->message }}
                            @else
                                لم تبدأ الرسائل بعد.
                            @endif
                        </p>
                    </div>

                    <div class="naseja-conversation-side">
                        <span class="naseja-conversation-time">
                            {{ ($last?->created_at ?? $conversation->updated_at)?->format('Y/m/d H:i') }}
                        </span>

                        @if($conversation->unread_count > 0)
                            <span class="naseja-unread">
                                {{ $conversation->unread_count }}
                            </span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="naseja-messages-empty">
            لا توجد محادثات حتى الآن. بعد قبول طلب خدمة سيظهر زر المراسلة للطرفين.
        </div>
    @endif
</div>
@endsection
