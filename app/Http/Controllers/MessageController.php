<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\ServiceOrder;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(): View
    {
        $user = $this->authenticatedUser();

        $conversations = Conversation::query()
            ->whereHas('participants', fn ($query) => $query->where('users.id', $user->id))
            ->with([
                'participants.profile',
                'serviceOrder.service',
                'latestMessage.sender',
            ])
            ->withCount([
                'messages as unread_count' => function ($query) use ($user) {
                    $query->whereNull('read_at')->where('sender_id', '!=', $user->id);
                },
            ])
            ->latest('updated_at')
            ->get();

        return view('layouts.frontend.user.messages.index', compact('user', 'conversations'));
    }

    public function start(ServiceOrder $serviceOrder): RedirectResponse
    {
        $user = $this->authenticatedUser();
        $this->ensureUserBelongsToOrder($serviceOrder, $user);

        abort_unless(
            in_array($serviceOrder->status, ['accepted', 'in_progress', 'completed'], true),
            403,
            'تبدأ المحادثة بعد قبول الطلب.'
        );

        $conversation = Conversation::firstOrCreate(['service_order_id' => $serviceOrder->id]);
        $now = now();

        DB::table('conversation_participants')->insertOrIgnore([
            [
                'conversation_id' => $conversation->id,
                'user_id' => $serviceOrder->customer_id,
                'joined_at' => $now,
                'created_at' => $now,
            ],
            [
                'conversation_id' => $conversation->id,
                'user_id' => $serviceOrder->provider_id,
                'joined_at' => $now,
                'created_at' => $now,
            ],
        ]);

        $conversation->touch();

        return redirect()->route('messages.show', $conversation);
    }

    public function show(Conversation $conversation): View
    {
        $user = $this->authenticatedUser();
        $this->ensureParticipant($conversation, $user);

        Message::query()
            ->where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $conversation->load([
            'participants.profile',
            'serviceOrder.service',
            'serviceOrder.customer.profile',
            'serviceOrder.provider.profile',
            'messages' => fn ($query) => $query->with('sender.profile')->oldest(),
        ]);

        $otherParticipant = $conversation->participants
            ->first(fn ($participant) => $participant->id !== $user->id);

        return view(
            'layouts.frontend.user.messages.show',
            compact('user', 'conversation', 'otherParticipant')
        );
    }

    public function store(Request $request, Conversation $conversation): RedirectResponse
    {
        $user = $this->authenticatedUser();
        $this->ensureParticipant($conversation, $user);

        $validated = $request->validate(
            ['message' => ['required', 'string', 'min:1', 'max:3000']],
            [
                'message.required' => 'اكتب الرسالة أولًا.',
                'message.max' => 'الرسالة طويلة جدًا.',
            ]
        );

        // تحقق من النص بعد حذف الفراغات حتى لا تحفظ رسالة فارغة.
        $messageText = trim($validated['message']);
        if ($messageText === '') {
            return back()->withErrors(['message' => 'اكتب الرسالة أولًا.']);
        }

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'message' => $messageText,
        ]);

        $conversation->touch();

        return redirect()->route('messages.show', $conversation)
            ->with('message_sent', 'تم إرسال الرسالة.');
    }

    private function authenticatedUser(): User
    {
        /** @var User $user */
        $user = auth()->user();
        abort_unless($user, 401);

        return $user;
    }

    private function ensureUserBelongsToOrder(ServiceOrder $serviceOrder, User $user): void
    {
        abort_unless(
            in_array($user->id, [$serviceOrder->customer_id, $serviceOrder->provider_id], true),
            403,
            'هذا الطلب لا يخص حسابك.'
        );
    }

    private function ensureParticipant(Conversation $conversation, User $user): void
    {
        abort_unless(
            $conversation->participants()->where('users.id', $user->id)->exists(),
            403,
            'لا يمكنك فتح هذه المحادثة.'
        );
    }
}
