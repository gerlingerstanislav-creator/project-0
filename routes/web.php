<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\PushSubscriptionController;
use App\Http\Controllers\Tools\ManagerCheatSheetsController;
use App\Http\Controllers\Tools\NewsController;
use App\Http\Controllers\Tools\SkiResortController;
use App\Http\Controllers\Tools\Tool1Controller;
use App\Http\Controllers\Tools\Tool2Controller;
use App\Http\Controllers\Tools\Tool3Controller;
use App\Http\Controllers\Tools\CronSchedulerController;
use App\Http\Middleware\EnsureUserCanAccessDesignSystem;
use App\Http\Middleware\EnsureUserCanEditStartupIdeas;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::get('/', fn () => Inertia::render('Home'))->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/tool-1', Tool1Controller::class)->name('tools.tool1');
    Route::get('/tool-2', Tool2Controller::class)->name('tools.tool2');
    Route::get('/tool-3', Tool3Controller::class)->name('tools.tool3');
    Route::get('/manager-cheat-sheets', ManagerCheatSheetsController::class)->name('tools.manager-cheat-sheets');
    Route::get('/ski-resort', SkiResortController::class)->name('tools.ski-resort');
    Route::get('/news', NewsController::class)->name('tools.news');
    Route::get('/cron-scheduler', CronSchedulerController::class)->name('tools.cron-scheduler');
    Route::put('/news/preferences', [NewsController::class, 'savePreferences'])->name('tools.news.preferences');
    Route::post('/news/feedback', [NewsController::class, 'feedback'])->name('tools.news.feedback');
    Route::delete('/news/feedback', [NewsController::class, 'removeFeedback'])->name('tools.news.feedback.remove');
    Route::get('/tests', fn () => Inertia::render('Tests'))->name('tests');
    Route::get('/design-system', fn () => Inertia::render('DesignSystem'))
        ->middleware(EnsureUserCanAccessDesignSystem::class)
        ->name('design-system');

    Route::get('/push/config', [PushSubscriptionController::class, 'config'])->name('push.config');
    Route::post('/push/subscriptions', [PushSubscriptionController::class, 'store'])->name('push.subscriptions.store');
    Route::post('/push/test', [PushSubscriptionController::class, 'test'])->name('push.test');
    Route::delete('/push/subscriptions', [PushSubscriptionController::class, 'destroy'])->name('push.subscriptions.destroy');

    Route::patch('/tool-1/ideas/{startupIdea}', [Tool1Controller::class, 'update'])
        ->middleware(EnsureUserCanEditStartupIdeas::class)
        ->name('tools.tool1.update');

    Route::post('/logout', LogoutController::class)->name('logout');
});
