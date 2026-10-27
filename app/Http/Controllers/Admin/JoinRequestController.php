<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class JoinRequestController extends Controller
{
    /**
     * عرض طلبات الانضمام المعلقة.
     */
    public function index()
    {
        $requests = User::where('approval_status', 'pending')
            ->latest()
            ->get();

        return view('admin.join-requests.index', compact('requests'));
    }


    /**
     * قبول المستخدم.
     */
    public function approve(User $user)
    {
        $user->approval_status = 'approved';
        $user->save();

        return back()->with(
            'success',
            'تم قبول طلب الانضمام بنجاح.'
        );
    }


    /**
     * رفض المستخدم.
     */
    public function reject(User $user)
    {
        $user->approval_status = 'rejected';
        $user->save();

        return back()->with(
            'success',
            'تم رفض طلب الانضمام.'
        );
    }
}