<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Skill;
use Illuminate\View\View;

class GameController extends Controller
{
    public function index(): View
    {
        $activeCategories = Category::query()
            ->where('status', 'active')
            ->get(['id', 'name_ar', 'name_en']);

        $playableCategories = $activeCategories
            ->filter(function ($category) {
                return Skill::query()
                    ->where('status', 'active')
                    ->where('category_id', $category->id)
                    ->exists();
            })
            ->shuffle()
            ->take(4)
            ->values();

        $categoryIds = $playableCategories->pluck('id');

        $skills = Skill::query()
            ->where('status', 'active')
            ->whereIn('category_id', $categoryIds)
            ->inRandomOrder()
            ->limit(40)
            ->get(['id', 'category_id', 'name_ar', 'name_en']);

        $gameCategories = $playableCategories
            ->map(function ($category) {
                return [
                    'id' => (int) $category->id,
                    'name' => $category->name_ar ?: $category->name_en ?: 'مجال',
                ];
            })
            ->values()
            ->all();

        $gameSkills = $skills
            ->map(function ($skill) {
                return [
                    'id' => (int) $skill->id,
                    'category_id' => (int) $skill->category_id,
                    'name' => $skill->name_ar ?: $skill->name_en ?: 'مهارة',
                ];
            })
            ->values()
            ->all();

        return view('frontend.game', compact('gameCategories', 'gameSkills'));
    }
}
