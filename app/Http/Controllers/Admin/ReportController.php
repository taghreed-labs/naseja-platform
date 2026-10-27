<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * عرض جميع البلاغات.
     */
    public function index(Request $request)
    {
        $search = trim(
            $request->input('search', '')
        );

        $status = trim(
            $request->input('status', '')
        );

        $type = trim(
            $request->input('type', '')
        );


        /*
        |--------------------------------------------------------------------------
        | Query البلاغات
        |--------------------------------------------------------------------------
        */

        $reportsQuery = Report::query()
            ->with([
                'reporter',
                'reportedUser',
            ]);


        /*
        |--------------------------------------------------------------------------
        | البحث
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $reportsQuery->where(
                function ($query) use ($search) {

                    $query
                        ->where(
                            'reason',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'description',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'admin_note',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhereHas(
                            'reporter',
                            function ($userQuery) use ($search) {

                                $userQuery
                                    ->where(
                                        'name',
                                        'like',
                                        "%{$search}%"
                                    )

                                    ->orWhere(
                                        'email',
                                        'like',
                                        "%{$search}%"
                                    );
                            }
                        )

                        ->orWhereHas(
                            'reportedUser',
                            function ($userQuery) use ($search) {

                                $userQuery
                                    ->where(
                                        'name',
                                        'like',
                                        "%{$search}%"
                                    )

                                    ->orWhere(
                                        'email',
                                        'like',
                                        "%{$search}%"
                                    );
                            }
                        );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | فلترة الحالة
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $status,
                ['pending', 'resolved', 'dismissed'],
                true
            )
        ) {

            $reportsQuery->where(
                'status',
                $status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | فلترة النوع
        |--------------------------------------------------------------------------
        */

        if ($type !== '') {

            $reportsQuery->where(
                'type',
                $type
            );
        }


        /*
        |--------------------------------------------------------------------------
        | جلب البلاغات
        |--------------------------------------------------------------------------
        */

        $reports = $reportsQuery
            ->latest()
            ->paginate(15)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | أنواع البلاغات الموجودة فعليًا
        |--------------------------------------------------------------------------
        */

        $reportTypes = Report::query()
            ->whereNotNull('type')
            ->where('type', '!=', '')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');


        /*
        |--------------------------------------------------------------------------
        | الإحصائيات
        |--------------------------------------------------------------------------
        */

        $totalReports = Report::count();

        $pendingReports = Report::where(
            'status',
            'pending'
        )->count();

        $resolvedReports = Report::where(
            'status',
            'resolved'
        )->count();

        $dismissedReports = Report::where(
            'status',
            'dismissed'
        )->count();


        return view(
            'admin.reports.index',
            compact(
                'reports',
                'reportTypes',
                'search',
                'status',
                'type',
                'totalReports',
                'pendingReports',
                'resolvedReports',
                'dismissedReports'
            )
        );
    }


    /**
     * اعتبار البلاغ محلولًا.
     */
    public function resolve(
        Request $request,
        Report $report
    ) {
        $validated = $request->validate([
            'admin_note' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);


        $report->update([
            'status' => 'resolved',
            'admin_note' => $validated['admin_note'] ?? null,
            'resolved_at' => now(),
        ]);


        return redirect()
            ->route('admin.reports.index')
            ->with(
                'success',
                'تم إغلاق البلاغ باعتباره محلولًا.'
            );
    }


    /**
     * استبعاد البلاغ.
     */
    public function dismiss(
        Request $request,
        Report $report
    ) {
        $validated = $request->validate([
            'admin_note' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);


        $report->update([
            'status' => 'dismissed',
            'admin_note' => $validated['admin_note'] ?? null,
            'resolved_at' => now(),
        ]);


        return redirect()
            ->route('admin.reports.index')
            ->with(
                'success',
                'تم استبعاد البلاغ.'
            );
    }


    /**
     * إعادة فتح البلاغ للمراجعة.
     */
    public function reopen(Report $report)
    {
        $report->update([
            'status' => 'pending',
            'resolved_at' => null,
        ]);


        return redirect()
            ->route('admin.reports.index')
            ->with(
                'success',
                'تمت إعادة فتح البلاغ للمراجعة.'
            );
    }
}
