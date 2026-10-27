<?php

use App\Http\Controllers\SkillRushScoreController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/skill-rush/score', [SkillRushScoreController::class, 'show'])->name('game.score.show');
    Route::post('/skill-rush/score', [SkillRushScoreController::class, 'store'])->name('game.score.store');
});
