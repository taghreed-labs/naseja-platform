<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * عرض جميع الخدمات.
     */
    public function index(Request $request)
    {
        $search = trim(
            $request->input('search', '')
        );

        $status = trim(
            $request->input('status', '')
        );

        $categoryId = $request->input(
            'category_id'
        );


        /*
        |--------------------------------------------------------------------------
        | Query الخدمات
        |--------------------------------------------------------------------------
        */

        $servicesQuery = Service::query()
            ->with([
                'user.profile',
                'category',
            ]);


        /*
        |--------------------------------------------------------------------------
        | فلترة المحذوف
        |--------------------------------------------------------------------------
        */

        if ($status === 'deleted') {

            $servicesQuery->onlyTrashed();
        }


        /*
        |--------------------------------------------------------------------------
        | البحث
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $servicesQuery->where(
                function ($query) use ($search) {

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
                        )

                        ->orWhereHas(
                            'user',
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
            $status === 'active' ||
            $status === 'inactive'
        ) {

            $servicesQuery->where(
                'status',
                $status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | فلترة حسب التصنيف
        |--------------------------------------------------------------------------
        */

        if ($categoryId) {

            $servicesQuery->where(
                'category_id',
                $categoryId
            );
        }


        /*
        |--------------------------------------------------------------------------
        | جلب الخدمات
        |--------------------------------------------------------------------------
        */

        $services = $servicesQuery
            ->latest()
            ->paginate(15)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | التصنيفات
        |--------------------------------------------------------------------------
        */

        $categories = Category::query()
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name_ar')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | الإحصائيات
        |--------------------------------------------------------------------------
        */

        $totalServices = Service::count();


        $activeServices = Service::where(
            'status',
            'active'
        )->count();


        $inactiveServices = Service::where(
            'status',
            'inactive'
        )->count();


        $deletedServices = Service::onlyTrashed()
            ->count();


        return view(
            'admin.services.index',
            compact(
                'services',
                'categories',
                'search',
                'status',
                'categoryId',
                'totalServices',
                'activeServices',
                'inactiveServices',
                'deletedServices'
            )
        );
    }


    /**
     * تفعيل الخدمة.
     */
    public function activate(Service $service)
    {
        $service->status = 'active';

        $service->save();


        return back()->with(
            'success',
            'تم تفعيل الخدمة بنجاح.'
        );
    }


    /**
     * تعطيل الخدمة.
     */
    public function deactivate(Service $service)
    {
        $service->status = 'inactive';

        $service->save();


        return back()->with(
            'success',
            'تم تعطيل الخدمة بنجاح.'
        );
    }


    /**
     * حذف الخدمة حذفًا ناعمًا.
     */
    public function destroy(Service $service)
    {
        $service->delete();


        return back()->with(
            'success',
            'تم حذف الخدمة بنجاح.'
        );
    }


    /**
     * استعادة خدمة محذوفة.
     */
    public function restore(int $service)
    {
        $serviceModel = Service::onlyTrashed()
            ->findOrFail($service);


        $serviceModel->restore();


        return back()->with(
            'success',
            'تمت استعادة الخدمة بنجاح.'
        );
    }
}