<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * عرض التصنيفات.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $status = trim($request->input('status', ''));


        $categoriesQuery = Category::query()
            ->whereNull('parent_id');


        /*
        |--------------------------------------------------------------------------
        | البحث
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $categoriesQuery->where(function ($query) use ($search) {

                $query
                    ->where(
                        'name_ar',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'name_en',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'slug',
                        'like',
                        "%{$search}%"
                    );
            });
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

            $categoriesQuery->where(
                'status',
                $status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | التصنيفات
        |--------------------------------------------------------------------------
        */

        $categories = $categoriesQuery
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | الإحصائيات
        |--------------------------------------------------------------------------
        */

        $totalCategories = Category::query()
            ->whereNull('parent_id')
            ->count();


        $activeCategories = Category::query()
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->count();


        $inactiveCategories = Category::query()
            ->whereNull('parent_id')
            ->where('status', 'inactive')
            ->count();


        return view(
            'admin.categories.index',
            compact(
                'categories',
                'search',
                'status',
                'totalCategories',
                'activeCategories',
                'inactiveCategories'
            )
        );
    }


    /**
     * إضافة تصنيف جديد.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => [
                'required',
                'string',
                'max:150',
            ],

            'name_en' => [
                'nullable',
                'string',
                'max:150',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:150',
                'unique:categories,slug',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | إنشاء Slug
        |--------------------------------------------------------------------------
        */

        $slug = trim(
            $validated['slug'] ?? ''
        );


        if ($slug === '') {

            $source =
                trim($validated['name_en'] ?? '');


            if ($source !== '') {

                $slug = Str::slug($source);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | إذا لم ينتج Slug صالح
        |--------------------------------------------------------------------------
        */

        if ($slug === '') {

            $slug =
                'category-' .
                now()->format('YmdHis');
        }


        /*
        |--------------------------------------------------------------------------
        | التأكد من عدم تكرار Slug المولد
        |--------------------------------------------------------------------------
        */

        $originalSlug = $slug;

        $counter = 1;


        while (
            Category::where(
                'slug',
                $slug
            )->exists()
        ) {

            $slug =
                $originalSlug .
                '-' .
                $counter;

            $counter++;
        }


        /*
        |--------------------------------------------------------------------------
        | إنشاء التصنيف
        |--------------------------------------------------------------------------
        */

        $category = new Category();

        $category->name_ar =
            $validated['name_ar'];

        $category->name_en =
            $validated['name_en'] ?? null;

        $category->slug =
            $slug;

        $category->parent_id =
            null;

        $category->sort_order =
            $validated['sort_order'] ?? 0;

        $category->status =
            $validated['status'];

        $category->save();


        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'تم إضافة التصنيف بنجاح.'
            );
    }


    /**
     * تعديل التصنيف.
     */
    public function update(
        Request $request,
        Category $category
    ) {

        $validated = $request->validate([
            'name_ar' => [
                'required',
                'string',
                'max:150',
            ],

            'name_en' => [
                'nullable',
                'string',
                'max:150',
            ],

            'slug' => [
                'required',
                'string',
                'max:150',

                Rule::unique(
                    'categories',
                    'slug'
                )->ignore($category->id),
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],
        ]);


        $category->name_ar =
            $validated['name_ar'];

        $category->name_en =
            $validated['name_en'] ?? null;

        $category->slug =
            Str::slug(
                $validated['slug']
            );


        /*
        |--------------------------------------------------------------------------
        | لو كتب Slug غير قابل للتحويل
        |--------------------------------------------------------------------------
        */

        if ($category->slug === '') {

            $category->slug =
                $validated['slug'];
        }


        $category->sort_order =
            $validated['sort_order'] ?? 0;

        $category->status =
            $validated['status'];

        $category->save();


        return back()->with(
            'success',
            'تم تحديث التصنيف بنجاح.'
        );
    }


    /**
     * تفعيل التصنيف.
     */
    public function activate(Category $category)
    {
        $category->status = 'active';

        $category->save();


        return back()->with(
            'success',
            'تم تفعيل التصنيف بنجاح.'
        );
    }


    /**
     * تعطيل التصنيف.
     */
    public function deactivate(Category $category)
    {
        $category->status = 'inactive';

        $category->save();


        return back()->with(
            'success',
            'تم تعطيل التصنيف بنجاح.'
        );
    }


    /**
     * حذف التصنيف.
     */
    public function destroy(Category $category)
    {
        /*
        |--------------------------------------------------------------------------
        | منع الحذف إذا كان التصنيف مستخدمًا في المهارات
        |--------------------------------------------------------------------------
        */

        $hasSkills = DB::table('skills')
            ->where(
                'category_id',
                $category->id
            )
            ->exists();


        /*
        |--------------------------------------------------------------------------
        | منع الحذف إذا كان التصنيف مستخدمًا في الخدمات
        |--------------------------------------------------------------------------
        */

        $hasServices = DB::table('services')
            ->where(
                'category_id',
                $category->id
            )
            ->exists();


        /*
        |--------------------------------------------------------------------------
        | منع حذف تصنيف لديه تصنيفات فرعية
        |--------------------------------------------------------------------------
        */

        $hasChildren = Category::query()
            ->where(
                'parent_id',
                $category->id
            )
            ->exists();


        if (
            $hasSkills ||
            $hasServices ||
            $hasChildren
        ) {

            return back()->with(
                'error',
                'لا يمكن حذف هذا التصنيف لأنه مرتبط ببيانات داخل المنصة. يمكنك تعطيله بدلًا من حذفه.'
            );
        }


        $category->delete();


        return back()->with(
            'success',
            'تم حذف التصنيف بنجاح.'
        );
    }
}