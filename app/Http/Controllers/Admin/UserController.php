<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * عرض جميع المستخدمين.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $status = $request->input('status');

        $approvalStatus = $request->input('approval_status');


        $usersQuery = User::query()
            ->with([
                'profile',
                'roles',
            ])
            ->whereDoesntHave(
                'roles',
                function ($query) {
                    $query->where('slug', 'admin');
                }
            );


        /*
        |--------------------------------------------------------------------------
        | البحث
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $usersQuery->where(
                function ($query) use ($search) {

                    $query
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


        /*
        |--------------------------------------------------------------------------
        | فلترة حالة الحساب
        |--------------------------------------------------------------------------
        */

        if (
            $status === 'active' ||
            $status === 'inactive'
        ) {

            $usersQuery->where(
                'status',
                $status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | فلترة حالة الاعتماد
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $approvalStatus,
                [
                    'pending',
                    'approved',
                    'rejected',
                ],
                true
            )
        ) {

            $usersQuery->where(
                'approval_status',
                $approvalStatus
            );
        }


        /*
        |--------------------------------------------------------------------------
        | المستخدمون
        |--------------------------------------------------------------------------
        */

        $users = $usersQuery
            ->latest()
            ->paginate(15)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | الإحصائيات
        |--------------------------------------------------------------------------
        */

        $baseUsersQuery = fn () =>
            User::query()
                ->whereDoesntHave(
                    'roles',
                    function ($query) {
                        $query->where('slug', 'admin');
                    }
                );


        $totalUsers = $baseUsersQuery()->count();

        $activeUsers = $baseUsersQuery()
            ->where('status', 'active')
            ->count();

        $inactiveUsers = $baseUsersQuery()
            ->where('status', 'inactive')
            ->count();


        return view(
            'admin.users.index',
            compact(
                'users',
                'search',
                'status',
                'approvalStatus',
                'totalUsers',
                'activeUsers',
                'inactiveUsers'
            )
        );
    }


    /**
     * تفعيل المستخدم.
     */
    public function activate(User $user)
    {
        $this->ensureUserIsNotAdmin($user);

        /*
        |--------------------------------------------------------------------------
        | تحديث صريح في قاعدة البيانات
        |--------------------------------------------------------------------------
        |
        | نستخدم update على السجل نفسه ثم نرجع إلى صفحة المستخدمين
        | بدون الاحتفاظ بفلتر "المعطل" حتى يظهر للمشرف أن الحساب
        | عاد فعلًا إلى حالة "نشط".
        |
        */

        User::query()
            ->whereKey($user->getKey())
            ->update([
                'status' => 'active',
                'updated_at' => now(),
            ]);


        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'تم تفعيل حساب المستخدم بنجاح.'
            );
    }


    /**
     * تعطيل المستخدم.
     */
    public function deactivate(User $user)
    {
        $this->ensureUserIsNotAdmin($user);

        User::query()
            ->whereKey($user->getKey())
            ->update([
                'status' => 'inactive',
                'updated_at' => now(),
            ]);


        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'تم تعطيل حساب المستخدم بنجاح.'
            );
    }


    /**
     * حذف المستخدم حذفًا آمنًا.
     */
    public function destroy(User $user)
    {
        $this->ensureUserIsNotAdmin($user);

        $user->delete();


        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'تم حذف المستخدم بنجاح.'
            );
    }


    /**
     * منع أي عملية على حساب Admin.
     */
    private function ensureUserIsNotAdmin(User $user): void
    {
        $isAdmin = $user
            ->roles()
            ->where(
                'slug',
                'admin'
            )
            ->exists();


        if ($isAdmin) {

            abort(
                403,
                'لا يمكن تنفيذ هذه العملية على حساب مدير النظام.'
            );
        }
    }
}
