@extends('layouts.frontend.user')

@section('title', 'المحادثة | NASEJA')

@section('content')
@php
    $order = $conversation->serviceOrder;
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
.naseja-chat{max-width:980px;margin:0 auto;padding:24px 16px 65px;font-family:'Cairo',sans-serif}
.naseja-chat-top{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:14px}
.naseja-chat-back{display:inline-flex;align-items:center;gap:7px;color:#6750d5;text-decoration:none;font-size:10px;font-weight:900}
.naseja-chat-title h1{margin:0 0 4px;font-size:22px;font-weight:900;color:#24213b}
.naseja-chat-title p{margin:0;color:#8b8e9f;font-size:10px}
.naseja-order-context{margin-bottom:14px;padding:13px 15px;border:1px solid rgba(115,87,255,.12);border-radius:16px;background:#f8f6ff;color:#5f55a4;font-size:10px;font-weight:800;line-height:1.8}
.naseja-chat-box{background:#fff;border:1px solid rgba(115,87,255,.11);border-radius:24px;box-shadow:0 14px 36px rgba(58,45,122,.06);overflow:hidden}
.naseja-chat-messages{min-height:380px;max-height:58vh;overflow-y:auto;padding:20px;display:flex;flex-direction:column;gap:10px;background:linear-gradient(180deg,#fbfaff,#fff)}
.naseja-bubble-row{display:flex}
.naseja-bubble-row.mine{justify-content:flex-start}
.naseja-bubble-row.theirs{justify-content:flex-end}
.naseja-bubble{max-width:min(75%,620px);padding:11px 13px;border-radius:16px;font-size:11px;line-height:1.9;word-break:break-word}
.naseja-bubble-row.mine .naseja-bubble{background:linear-gradient(135deg,#7357ff,#5e72ff);color:#fff;border-bottom-left-radius:5px}
.naseja-bubble-row.theirs .naseja-bubble{background:#f0eef7;color:#363246;border-bottom-right-radius:5px}
.naseja-bubble-meta{display:block;margin-top:5px;opacity:.72;font-size:8px;font-weight:700}
.naseja-chat-empty{margin:auto;color:#999bad;font-size:10px}
.naseja-chat-form{padding:14px;border-top:1px solid rgba(115,87,255,.09);background:#fff}
.naseja-chat-form-row{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:9px;align-items:end}
.naseja-chat-form textarea{width:100%;min-height:54px;max-height:150px;resize:vertical;border:1px solid #e1deef;border-radius:14px;padding:11px 12px;font-family:inherit;font-size:11px;outline:none;background:#fff;color:#2d2a3f}
.naseja-chat-form textarea:focus{border-color:#8d79ef;box-shadow:0 0 0 3px rgba(115,87,255,.08)}
.naseja-send-btn{height:44px;padding:0 18px;border:0;border-radius:13px;background:linear-gradient(135deg,#7357ff,#3487ff);color:#fff;font-family:inherit;font-size:10px;font-weight:900;cursor:pointer}
.naseja-chat-error{margin-bottom:8px;color:#c94b60;font-size:9.5px;font-weight:800}
html[data-theme="dark"] .naseja-chat-box,
html[data-theme="dark"] .naseja-chat-form{background:#211f31;border-color:rgba(157,137,255,.15)}
html[data-theme="dark"] .naseja-chat-messages{background:#1d1b2b}
html[data-theme="dark"] .naseja-chat-title h1{color:#f3f1f8}
html[data-theme="dark"] .naseja-chat-form textarea{background:#282638;color:#f4f2f8;border-color:#39364c}
@media(max-width:650px){.naseja-chat-top{align-items:flex-start;flex-direction:column}.naseja-chat-form-row{grid-template-columns:1fr}.naseja-send-btn{width:100%}.naseja-bubble{max-width:88%}}
</style>

<div class="naseja-chat" dir="rtl">
    <div class="naseja-chat-top">
        <div class="naseja-chat-title">
            <h1>{{ $otherParticipant?->name ?? 'محادثة NASEJA' }}</h1>
            <p>تواصل مباشر حول طلب الخدمة.</p>
        </div>

        <a href="{{ route('messages.index') }}" class="naseja-chat-back">
            العودة للرسائل
        </a>
    </div>

    @if($order)
        <div class="naseja-order-context">
            طلب #{{ $order->id }}:
            {{ $order->service?->title_ar ?? $order->service?->title_en ?? 'خدمة' }}
            · الحالة: {{ $statusLabels[$order->status] ?? $order->status }}
        </div>
    @endif

    <div class="naseja-chat-box">
        <div class="naseja-chat-messages" id="nasejaChatMessages">
            @forelse($conversation->messages as $message)
                <div class="naseja-bubble-row {{ $message->sender_id === $user->id ? 'mine' : 'theirs' }}">
                    <div class="naseja-bubble">
                        {{ $message->message }}

                        <span class="naseja-bubble-meta">
                            {{ $message->created_at->format('Y/m/d H:i') }}
                            @if($message->sender_id === $user->id && $message->read_at)
                                · تمت القراءة
                            @endif
                        </span>
                    </div>
                </div>
            @empty
                <div class="naseja-chat-empty">
                    ابدأ المحادثة برسالة حول تفاصيل الطلب.
                </div>
            @endforelse
        </div>

        <form
            method="POST"
            action="{{ route('messages.store', $conversation) }}"
            class="naseja-chat-form"
        >
            @csrf

            @error('message')
                <div class="naseja-chat-error">{{ $message }}</div>
            @enderror

            <div class="naseja-chat-form-row">
                <textarea
                    name="message"
                    maxlength="3000"
                    required
                    placeholder="اكتب رسالتك..."
                >{{ old('message') }}</textarea>

                <button type="submit" class="naseja-send-btn">
                    إرسال
                </button>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    var box = document.getElementById('nasejaChatMessages');
    if (box) {
        box.scrollTop = box.scrollHeight;
    }
})();
</script>
@endsection
