<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SkillController extends Controller
{
    /**
     * عرض المهارات.
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
        | Query المهارات
        |--------------------------------------------------------------------------
        */

        $skillsQuery = Skill::query()
            ->with('category');


        /*
        |--------------------------------------------------------------------------
        | البحث
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $skillsQuery->where(
                function ($query) use ($search) {

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
                        )

                        ->orWhere(
                            'description',
                            'like',
                            "%{$search}%"
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

            $skillsQuery->where(
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

            $skillsQuery->where(
                'category_id',
                $categoryId
            );
        }


        /*
        |--------------------------------------------------------------------------
        | جلب المهارات
        |--------------------------------------------------------------------------
        */

        $skills = $skillsQuery
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

        $totalSkills = Skill::count();


        $activeSkills = Skill::where(
            'status',
            'active'
        )->count();


        $inactiveSkills = Skill::where(
            'status',
            'inactive'
        )->count();


        return view(
            'admin.skills.index',
            compact(
                'skills',
                'categories',
                'search',
                'status',
                'categoryId',
                'totalSkills',
                'activeSkills',
                'inactiveSkills'
            )
        );
    }


    /**
     * إضافة مهارة.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'name_ar' => [
                'required',
                'string',
                'max:255',
            ],

            'name_en' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:skills,slug',
            ],

            'description' => [
                'nullable',
                'string',
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

            $slug = Str::slug(
                $validated['name_en']
            );
        }


        /*
        |--------------------------------------------------------------------------
        | احتياط إذا لم يتم إنشاء Slug
        |--------------------------------------------------------------------------
        */

        if ($slug === '') {

            $slug =
                'skill-' .
                now()->format('YmdHis');
        }


        /*
        |--------------------------------------------------------------------------
        | التأكد من عدم تكراره
        |--------------------------------------------------------------------------
        */

        $originalSlug = $slug;

        $counter = 1;


        while (
            Skill::where(
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
        | إنشاء المهارة
        |--------------------------------------------------------------------------
        */

        Skill::create([
            'category_id' =>
                $validated['category_id'],

            'name_ar' =>
                $validated['name_ar'],

            'name_en' =>
                $validated['name_en'],

            'slug' =>
                $slug,

            'description' =>
                $validated['description'] ?? null,

            'status' =>
                $validated['status'],
        ]);


        return redirect()
            ->route('admin.skills.index')
            ->with(
                'success',
                'تم إضافة المهارة بنجاح.'
            );
    }


    /**
     * تحديث المهارة.
     */
    public function update(
        Request $request,
        Skill $skill
    ) {

        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'name_ar' => [
                'required',
                'string',
                'max:255',
            ],

            'name_en' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',

                Rule::unique(
                    'skills',
                    'slug'
                )->ignore($skill->id),
            ],

            'description' => [
                'nullable',
                'string',
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
        | تنسيق Slug
        |--------------------------------------------------------------------------
        */

        $slug = Str::slug(
            $validated['slug']
        );


        if ($slug === '') {

            $slug =
                $validated['slug'];
        }


        /*
        |--------------------------------------------------------------------------
        | تحديث المهارة
        |--------------------------------------------------------------------------
        */

        $skill->update([
            'category_id' =>
                $validated['category_id'],

            'name_ar' =>
                $validated['name_ar'],

            'name_en' =>
                $validated['name_en'],

            'slug' =>
                $slug,

            'description' =>
                $validated['description'] ?? null,

            'status' =>
                $validated['status'],
        ]);


        return back()->with(
            'success',
            'تم تحديث المهارة بنجاح.'
        );
    }


    /**
     * تفعيل المهارة.
     */
    public function activate(Skill $skill)
    {
        $skill->status = 'active';

        $skill->save();


        return back()->with(
            'success',
            'تم تفعيل المهارة بنجاح.'
        );
    }


    /**
     * تعطيل المهارة.
     */
    public function deactivate(Skill $skill)
    {
        $skill->status = 'inactive';

        $skill->save();


        return back()->with(
            'success',
            'تم تعطيل المهارة بنجاح.'
        );
    }


    /**
     * حذف المهارة.
     */
    public function destroy(Skill $skill)
    {
        /*
        |--------------------------------------------------------------------------
        | منع حذف مهارة مرتبطة بمستخدمين
        |--------------------------------------------------------------------------
        */

        if (
            $skill->userSkills()->exists()
        ) {

            return back()->with(
                'error',
                'لا يمكن حذف هذه المهارة لأنها مستخدمة من قبل أصحاب مهارات. يمكنك تعطيلها بدلًا من حذفها.'
            );
        }


        $skill->delete();


        return back()->with(
            'success',
            'تم حذف المهارة بنجاح.'
        );
    }
}