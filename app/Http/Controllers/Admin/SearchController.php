<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PortfolioItem;
use App\Models\Report;
use App\Models\Service;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * البحث الشامل داخل لوحة الإدارة.
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->input('q', ''));

        $users = collect();
        $categories = collect();
        $skills = collect();
        $services = collect();
        $portfolioItems = collect();
        $reports = collect();

        if ($q !== '') {

            $users = User::query()
                ->whereDoesntHave('roles', function ($roleQuery) {
                    $roleQuery->where('slug', 'admin');
                })
                ->where(function ($query) use ($q) {
                    $query
                        ->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('phone', 'like', "%{$q}%");
                })
                ->latest()
                ->take(5)
                ->get();


            $categories = Category::query()
                ->where(function ($query) use ($q) {
                    $query
                        ->where('name_ar', 'like', "%{$q}%")
                        ->orWhere('name_en', 'like', "%{$q}%")
                        ->orWhere('slug', 'like', "%{$q}%");
                })
                ->orderBy('sort_order')
                ->take(5)
                ->get();


            $skills = Skill::query()
                ->with('category')
                ->where(function ($query) use ($q) {
                    $query
                        ->where('name_ar', 'like', "%{$q}%")
                        ->orWhere('name_en', 'like', "%{$q}%")
                        ->orWhere('slug', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                })
                ->latest()
                ->take(5)
                ->get();


            $services = Service::query()
                ->with(['user', 'category'])
                ->where(function ($query) use ($q) {
                    $query
                        ->where('title_ar', 'like', "%{$q}%")
                        ->orWhere('title_en', 'like', "%{$q}%")
                        ->orWhere('description_ar', 'like', "%{$q}%")
                        ->orWhere('description_en', 'like', "%{$q}%")
                        ->orWhereHas('user', function ($userQuery) use ($q) {
                            $userQuery
                                ->where('name', 'like', "%{$q}%")
                                ->orWhere('email', 'like', "%{$q}%");
                        });
                })
                ->latest()
                ->take(5)
                ->get();


            $portfolioItems = PortfolioItem::query()
                ->with('user')
                ->where(function ($query) use ($q) {
                    $query
                        ->where('title_ar', 'like', "%{$q}%")
                        ->orWhere('title_en', 'like', "%{$q}%")
                        ->orWhere('description_ar', 'like', "%{$q}%")
                        ->orWhere('description_en', 'like', "%{$q}%")
                        ->orWhereHas('user', function ($userQuery) use ($q) {
                            $userQuery
                                ->where('name', 'like', "%{$q}%")
                                ->orWhere('email', 'like', "%{$q}%");
                        });
                })
                ->latest()
                ->take(5)
                ->get();


            $reports = Report::query()
                ->with(['reporter', 'reportedUser'])
                ->where(function ($query) use ($q) {
                    $query
                        ->where('type', 'like', "%{$q}%")
                        ->orWhere('reason', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%")
                        ->orWhere('admin_note', 'like', "%{$q}%")
                        ->orWhereHas('reporter', function ($userQuery) use ($q) {
                            $userQuery
                                ->where('name', 'like', "%{$q}%")
                                ->orWhere('email', 'like', "%{$q}%");
                        })
                        ->orWhereHas('reportedUser', function ($userQuery) use ($q) {
                            $userQuery
                                ->where('name', 'like', "%{$q}%")
                                ->orWhere('email', 'like', "%{$q}%");
                        });
                })
                ->latest()
                ->take(5)
                ->get();
        }


        $resultsCount =
            $users->count()
            + $categories->count()
            + $skills->count()
            + $services->count()
            + $portfolioItems->count()
            + $reports->count();


        return view(
            'admin.search.index',
            compact(
                'q',
                'users',
                'categories',
                'skills',
                'services',
                'portfolioItems',
                'reports',
                'resultsCount'
            )
        );
    }
}
