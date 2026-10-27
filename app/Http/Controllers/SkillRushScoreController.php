<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SkillRushScoreController extends Controller
{
    private function ensureCustomer(Request $request): void
    {
        abort_unless(
            $request->user() && $request->user()->roles()->where('slug', 'customer')->exists(),
            403,
            'حفظ النقاط متاح لحساب العميل فقط.'
        );
    }

    public function show(Request $request): JsonResponse
    {
        $this->ensureCustomer($request);
        $row = DB::table('skill_rush_scores')->where('user_id', $request->user()->id)->first();

        return response()->json([
            'best_score' => (int) ($row->best_score ?? 0),
            'last_score' => (int) ($row->last_score ?? 0),
            'rounds_played' => (int) ($row->rounds_played ?? 0),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->ensureCustomer($request);

        $data = $request->validate([
            'score' => ['required', 'integer', 'min:0', 'max:3000'],
        ]);

        $best = DB::transaction(function () use ($request, $data) {
            $userId = $request->user()->id;
            $now = now();
            DB::table('skill_rush_scores')->insertOrIgnore([
                'user_id' => $userId,
                'best_score' => 0,
                'last_score' => 0,
                'rounds_played' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $row = DB::table('skill_rush_scores')->where('user_id', $userId)->lockForUpdate()->first();
            $best = max((int) $row->best_score, (int) $data['score']);
            DB::table('skill_rush_scores')->where('user_id', $userId)->update([
                'last_score' => (int) $data['score'],
                'best_score' => $best,
                'rounds_played' => (int) $row->rounds_played + 1,
                'updated_at' => $now,
            ]);

            return $best;
        });

        return response()->json(['best_score' => $best, 'saved' => true]);
    }
}
