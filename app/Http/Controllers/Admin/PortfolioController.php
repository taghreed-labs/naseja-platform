<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * عرض جميع الأعمال.
     */
    public function index(Request $request)
    {
        $search = trim(
            $request->input('search', '')
        );

        $status = trim(
            $request->input('status', '')
        );


        /*
        |--------------------------------------------------------------------------
        | Query الأعمال
        |--------------------------------------------------------------------------
        */

        $portfolioQuery = PortfolioItem::query()
            ->with([
                'user',
                'images',
            ])
            ->withCount('verifiedWorks');


        /*
        |--------------------------------------------------------------------------
        | عرض المحذوفات
        |--------------------------------------------------------------------------
        */

        if ($status === 'deleted') {
            $portfolioQuery->onlyTrashed();
        }


        /*
        |--------------------------------------------------------------------------
        | البحث
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $portfolioQuery->where(
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

            $portfolioQuery->where(
                'status',
                $status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | جلب الأعمال
        |--------------------------------------------------------------------------
        */

        $portfolioItems = $portfolioQuery
            ->latest()
            ->paginate(15)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | الإحصائيات
        |--------------------------------------------------------------------------
        */

        $totalPortfolioItems =
            PortfolioItem::count();


        $activePortfolioItems =
            PortfolioItem::where(
                'status',
                'active'
            )->count();


        $inactivePortfolioItems =
            PortfolioItem::where(
                'status',
                'inactive'
            )->count();


        $deletedPortfolioItems =
            PortfolioItem::onlyTrashed()
                ->count();


        return view(
            'admin.portfolio.index',
            compact(
                'portfolioItems',
                'search',
                'status',
                'totalPortfolioItems',
                'activePortfolioItems',
                'inactivePortfolioItems',
                'deletedPortfolioItems'
            )
        );
    }


    /**
     * تفعيل العمل.
     */
    public function activate(PortfolioItem $portfolioItem)
    {
        $portfolioItem->status = 'active';

        $portfolioItem->save();


        return back()->with(
            'success',
            'تم تفعيل العمل بنجاح.'
        );
    }


    /**
     * تعطيل العمل.
     */
    public function deactivate(PortfolioItem $portfolioItem)
    {
        $portfolioItem->status = 'inactive';

        $portfolioItem->save();


        return back()->with(
            'success',
            'تم تعطيل العمل بنجاح.'
        );
    }


    /**
     * حذف العمل حذفًا ناعمًا.
     */
    public function destroy(PortfolioItem $portfolioItem)
    {
        $portfolioItem->delete();


        return back()->with(
            'success',
            'تم حذف العمل بنجاح.'
        );
    }


    /**
     * استعادة عمل محذوف.
     */
    public function restore(int $portfolioItem)
    {
        $item = PortfolioItem::onlyTrashed()
            ->findOrFail($portfolioItem);


        $item->restore();


        return back()->with(
            'success',
            'تمت استعادة العمل بنجاح.'
        );
    }
}
