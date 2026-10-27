<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\UserSkill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserSkillController extends Controller
{
    /**
     * عرض مهارات المستخدم.
     *
     * المهارات المتاحة يتم تحديدها حسب
     * التصنيفات التي اختارها المستخدم في "خدماتي".
     */
    public function index(): View
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | مهارات المستخدم الحالية
        |--------------------------------------------------------------------------
        */

        $userSkills = $user->userSkills()
            ->with([
                'skill',
                'skill.category',
            ])
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | التصنيفات التي اختارها المستخدم في خدماته
        |--------------------------------------------------------------------------
        |
        | مثال:
        |
        | المستخدم لديه خدمة:
        | تطريز
        |
        | category_id = 2
        |
        | إذن نسمح له بمهارات category_id = 2 فقط.
        |
        */

        $categoryIds = $user->services()
            ->pluck('category_id')
            ->unique()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | المهارات المتاحة للمستخدم
        |--------------------------------------------------------------------------
        |
        | إذا لم يضف المستخدم أي خدمة:
        | لن تظهر له مهارات.
        |
        | إذا أضاف خدمة تطريز:
        | تظهر مهارات التطريز فقط.
        |
        | إذا أضاف تطريز + خياطة:
        | تظهر مهارات التطريز والخياطة.
        |
        */

        if ($categoryIds->isNotEmpty()) {

            $skills = Skill::where('status', 'active')
                ->whereIn('category_id', $categoryIds)
                ->with('category')
                ->orderBy('name_ar')
                ->get();

        } else {

            $skills = collect();

        }


        return view(
            'layouts.frontend.user.skills',
            compact(
                'userSkills',
                'skills',
                'categoryIds'
            )
        );
    }


    /**
     * إضافة مهارة للمستخدم.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([

            'skill_id' => [
                'required',
                'exists:skills,id',
            ],

            'level' => [
                'required',
                'string',
                'max:50',
            ],

            'years_experience' => [
                'nullable',
                'integer',
                'min:0',
                'max:100',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | التأكد أن المهارة تابعة لتصنيف موجود في خدمات المستخدم
        |--------------------------------------------------------------------------
        */

        $skill = Skill::findOrFail($validated['skill_id']);

        $hasCategory = $request->user()
            ->services()
            ->where('category_id', $skill->category_id)
            ->exists();


        if (!$hasCategory) {

            return back()
                ->withErrors([
                    'skill_id' =>
                        'هذه المهارة غير متاحة لأنك لم تضف خدمة من نفس المجال.',
                ])
                ->withInput();

        }


        /*
        |--------------------------------------------------------------------------
        | منع تكرار نفس المهارة
        |--------------------------------------------------------------------------
        */

        $exists = UserSkill::where('user_id', auth()->id())
            ->where('skill_id', $validated['skill_id'])
            ->exists();


        if ($exists) {

            return back()
                ->withErrors([
                    'skill_id' => 'هذه المهارة مضافة بالفعل.',
                ])
                ->withInput();

        }


        /*
        |--------------------------------------------------------------------------
        | إنشاء المهارة
        |--------------------------------------------------------------------------
        */

        UserSkill::create([

            'user_id' => auth()->id(),

            'skill_id' => $validated['skill_id'],

            'level' => $validated['level'],

            'years_experience' =>
                $validated['years_experience'] ?? null,

        ]);


        return back()->with(
            'success',
            'تمت إضافة المهارة بنجاح.'
        );
    }


    /**
     * عرض نموذج تعديل المهارة.
     */
    public function edit(UserSkill $userSkill): View
    {
        /*
        |--------------------------------------------------------------------------
        | التأكد أن المهارة تخص المستخدم الحالي
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $userSkill->user_id === auth()->id(),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | التصنيفات الموجودة في خدمات المستخدم
        |--------------------------------------------------------------------------
        */

        $categoryIds = auth()->user()
            ->services()
            ->pluck('category_id')
            ->unique()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | جلب المهارات التابعة لخدمات المستخدم فقط
        |--------------------------------------------------------------------------
        */

        $skills = Skill::where('status', 'active')
            ->whereIn('category_id', $categoryIds)
            ->with('category')
            ->orderBy('name_ar')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | جلب المهارة الحالية
        |--------------------------------------------------------------------------
        */

        $userSkill->load([
            'skill',
            'skill.category',
        ]);


        return view(
            'layouts.frontend.user.skills-edit',
            compact(
                'userSkill',
                'skills'
            )
        );
    }


    /**
     * حفظ تعديلات المهارة.
     */
    public function update(
        Request $request,
        UserSkill $userSkill
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | التأكد أن المهارة تخص المستخدم الحالي
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $userSkill->user_id === auth()->id(),
            403
        );


        $validated = $request->validate([

            'skill_id' => [
                'required',
                'exists:skills,id',
            ],

            'level' => [
                'required',
                'string',
                'max:50',
            ],

            'years_experience' => [
                'nullable',
                'integer',
                'min:0',
                'max:100',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | التأكد أن المهارة تابعة لتصنيف من خدمات المستخدم
        |--------------------------------------------------------------------------
        */

        $skill = Skill::findOrFail($validated['skill_id']);

        $hasCategory = $request->user()
            ->services()
            ->where('category_id', $skill->category_id)
            ->exists();


        if (!$hasCategory) {

            return back()
                ->withErrors([
                    'skill_id' =>
                        'هذه المهارة غير متاحة لأنك لم تضف خدمة من نفس المجال.',
                ])
                ->withInput();

        }


        /*
        |--------------------------------------------------------------------------
        | منع تكرار نفس المهارة
        |--------------------------------------------------------------------------
        */

        $exists = UserSkill::where('user_id', auth()->id())
            ->where('skill_id', $validated['skill_id'])
            ->where('id', '!=', $userSkill->id)
            ->exists();


        if ($exists) {

            return back()
                ->withErrors([
                    'skill_id' => 'هذه المهارة مضافة بالفعل.',
                ])
                ->withInput();

        }


        /*
        |--------------------------------------------------------------------------
        | تحديث المهارة
        |--------------------------------------------------------------------------
        */

        $userSkill->update([

            'skill_id' => $validated['skill_id'],

            'level' => $validated['level'],

            'years_experience' =>
                $validated['years_experience'] ?? null,

        ]);


        return redirect()
            ->route('skills.index')
            ->with(
                'success',
                'تم حفظ تغييرات المهارة بنجاح.'
            );
    }


    /**
     * حذف مهارة من المستخدم.
     */
    public function destroy(UserSkill $userSkill): RedirectResponse
    {
        abort_unless(
            $userSkill->user_id === auth()->id(),
            403
        );


        $userSkill->delete();


        return back()->with(
            'success',
            'تم حذف المهارة بنجاح.'
        );
    }
}