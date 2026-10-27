<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * عرض لوحة تحكم المستخدم.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | لوحة العميل
        |--------------------------------------------------------------------------
        |
        | العميل لا يحتاج إحصائيات المهارات والخدمات والأعمال الخاصة
        | بصاحب المهارة. لذلك نرسل العميل إلى لوحة مستقلة مبنية على
        | الوظائف المتاحة فعليًا في المشروع حاليًا.
        |
        */

        $isCustomer = $user->roles()
            ->where('slug', 'customer')
            ->exists();

        if ($isCustomer) {
            return view(
                'layouts.frontend.user.customer-dashboard',
                compact('user')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | إحصائيات صاحب المهارة
        |--------------------------------------------------------------------------
        */

        $skillsCount = $user->userSkills()->count();
        $servicesCount = $user->services()->count();
        $portfolioCount = $user->portfolioItems()->count();

        /*
        |--------------------------------------------------------------------------
        | اكتمال الملف الشخصي
        |--------------------------------------------------------------------------
        */

        $profile = $user->profile;
        $profileCompletion = 0;

        if ($profile) {
            $completedFields = 0;
            $totalFields = 6;

            if (!empty($profile->avatar)) {
                $completedFields++;
            }

            if (
                !empty($profile->bio_ar) ||
                !empty($profile->bio_en)
            ) {
                $completedFields++;
            }

            if (!empty($profile->phone)) {
                $completedFields++;
            }

            if (!empty($profile->location)) {
                $completedFields++;
            }

            if (!empty($profile->date_of_birth)) {
                $completedFields++;
            }

            if (!empty($profile->gender)) {
                $completedFields++;
            }

            $profileCompletion = round(
                ($completedFields / $totalFields) * 100
            );
        }

        /*
        |--------------------------------------------------------------------------
        | البحث داخل الداشبورد
        |--------------------------------------------------------------------------
        */

        $search = trim($request->input('search', ''));

        $searchUsers = collect();
        $searchServices = collect();
        $searchPortfolioItems = collect();

        if ($search !== '') {
            /*
            |--------------------------------------------------------------------------
            | البحث عن المستخدمين
            |--------------------------------------------------------------------------
            */

            $searchUsers = User::query()
                ->with([
                    'profile',
                    'userSkills.skill',
                ])
                ->where('status', 'active')
                ->where('id', '!=', $user->id)
                ->where(function ($query) use ($search) {
                    $query
                        ->where(
                            'name',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhereHas(
                            'profile',
                            function ($profileQuery) use ($search) {
                                $profileQuery
                                    ->where(
                                        'bio_ar',
                                        'like',
                                        "%{$search}%"
                                    )
                                    ->orWhere(
                                        'bio_en',
                                        'like',
                                        "%{$search}%"
                                    )
                                    ->orWhere(
                                        'location',
                                        'like',
                                        "%{$search}%"
                                    );
                            }
                        )
                        ->orWhereHas(
                            'userSkills.skill',
                            function ($skillQuery) use ($search) {
                                $skillQuery
                                    ->where(
                                        'name_ar',
                                        'like',
                                        "%{$search}%"
                                    )
                                    ->orWhere(
                                        'name_en',
                                        'like',
                                        "%{$search}%"
                                    );
                            }
                        );
                })
                ->latest()
                ->take(6)
                ->get();

            /*
            |--------------------------------------------------------------------------
            | البحث عن الخدمات
            |--------------------------------------------------------------------------
            */

            $searchServices = Service::query()
                ->with([
                    'user.profile',
                    'category',
                ])
                ->where('status', 'active')
                ->where(function ($query) use ($search) {
                    $query
                        ->where(
                            'title_ar',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'title_en',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'description_ar',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'description_en',
                            'like',
                            "%{$search}%"
                        );
                })
                ->latest()
                ->take(6)
                ->get();

            /*
            |--------------------------------------------------------------------------
            | البحث عن الأعمال
            |--------------------------------------------------------------------------
            */

            $searchPortfolioItems = PortfolioItem::query()
                ->with([
                    'user.profile',
                    'images',
                ])
                ->where('status', 'active')
                ->where(function ($query) use ($search) {
                    $query
                        ->where(
                            'title_ar',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'title_en',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'description_ar',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'description_en',
                            'like',
                            "%{$search}%"
                        );
                })
                ->latest()
                ->take(6)
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | لوحة صاحب المهارة الحالية
        |--------------------------------------------------------------------------
        */

        return view(
            'layouts.frontend.user.dashboard',
            compact(
                'user',
                'skillsCount',
                'servicesCount',
                'portfolioCount',
                'profileCompletion',
                'search',
                'searchUsers',
                'searchServices',
                'searchPortfolioItems'
            )
        );
    }
}
