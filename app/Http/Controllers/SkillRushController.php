<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Skill;
use Illuminate\View\View;

class SkillRushController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->where('status', 'active')
            ->whereHas('skills', function ($query) {
                $query->where('status', 'active');
            })
            ->inRandomOrder()
            ->limit(4)
            ->get(['id', 'name_ar', 'name_en']);

        $categoryIds = $categories->pluck('id');

        $skills = Skill::query()
            ->where('status', 'active')
            ->whereIn('category_id', $categoryIds)
            ->inRandomOrder()
            ->limit(60)
            ->get(['id', 'category_id', 'name_ar', 'name_en']);

        $gameCategories = $categories->map(function ($category) {
            return [
                'id' => (int) $category->id,
                'name' => $category->name_ar ?: $category->name_en ?: 'مجال',
            ];
        })->values()->all();

        $gameSkills = $skills->map(function ($skill) {
            return [
                'id' => (int) $skill->id,
                'category_id' => (int) $skill->category_id,
                'name' => $skill->name_ar ?: $skill->name_en ?: 'مهارة',
            ];
        })->values()->all();

        return view('frontend.skill-rush', compact('gameCategories', 'gameSkills'));
    }
}
