<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ReportController extends Controller
{
    public function store(Request $request, User $user)
    {
        $reporterId = auth()->id();

        if ($reporterId !== null && (int) $reporterId === (int) $user->id) {
            return back()->with('report_error', 'لا يمكنك الإبلاغ عن حسابك الشخصي.');
        }

        $validated = $request->validateWithBag('report', [
            'reason' => [
                'required',
                'string',
                'in:inappropriate_content,misleading_information,impersonation,fraud_or_abuse,other',
            ],
            'description' => ['nullable', 'string', 'max:2000', 'required_if:reason,other'],
        ], [
            'reason.required' => 'اختَر سبب البلاغ.',
            'reason.in' => 'سبب البلاغ غير صالح.',
            'description.required_if' => 'اكتب تفاصيل مختصرة عندما تختار «سبب آخر».',
            'description.max' => 'تفاصيل البلاغ يجب ألا تتجاوز 2000 حرف.',
        ]);

        if ($reporterId !== null) {
            $hasPendingReport = Report::query()
                ->where('reporter_id', $reporterId)
                ->where('reported_user_id', $user->id)
                ->where('status', 'pending')
                ->exists();
        } else {
            // Guests have no user ID; a session key stops duplicate pending submissions.
            $hasPendingReport = in_array(
                (int) $user->id,
                (array) $request->session()->get('guest_reported_users', []),
                true
            );
        }

        if ($hasPendingReport) {
            return back()->with('report_info', 'لديك بلاغ سابق عن هذا الحساب ما زال قيد المراجعة.');
        }

        // Rate limit applies across sessions from the same IP as well.
        $rateKey = 'report:user:' . ($reporterId !== null
            ? 'account:' . $reporterId
            : 'guest:' . hash('sha256', (string) $request->ip()));

        if (RateLimiter::tooManyAttempts($rateKey, $reporterId === null ? 3 : 10)) {
            return back()->with('report_error', 'تم إرسال عدة بلاغات مؤخرًا. حاول لاحقًا.');
        }

        $reasonLabels = [
            'inappropriate_content' => 'محتوى غير مناسب',
            'misleading_information' => 'معلومات مضللة أو غير صحيحة',
            'impersonation' => 'انتحال شخصية',
            'fraud_or_abuse' => 'احتيال أو إساءة',
            'other' => 'سبب آخر',
        ];

        Report::forceCreate([
            'reporter_id' => $reporterId,
            'reported_user_id' => $user->id,
            'type' => 'user',
            'reason' => $reasonLabels[$validated['reason']],
            'description' => $validated['description'] ?? null,
            'status' => 'pending',
            'admin_note' => null,
            'resolved_at' => null,
        ]);

        RateLimiter::hit($rateKey, 3600);

        if ($reporterId === null) {
            $reported = (array) $request->session()->get('guest_reported_users', []);
            $reported[] = (int) $user->id;
            $request->session()->put('guest_reported_users', array_values(array_unique($reported)));
        }

        return back()->with('report_success', 'تم استلام بلاغك بنجاح وسيتم مراجعته من إدارة NASEJA.');
    }
}
