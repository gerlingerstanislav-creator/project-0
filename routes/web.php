<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\PushSubscriptionController;
use App\Http\Controllers\Tools\ManagerCheatSheetsController;
use App\Http\Controllers\Tools\Tool1Controller;
use App\Http\Controllers\Tools\Tool2Controller;
use App\Http\Controllers\Tools\Tool3Controller;
use App\Http\Controllers\Tools\WeatherController;
use App\Http\Middleware\EnsureUserCanEditStartupIdeas;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::get('/', fn () => redirect()->route('tools.tool1'))->name('home');

Route::get('/tool-1', Tool1Controller::class)->name('tools.tool1');
Route::get('/tool-2', Tool2Controller::class)->name('tools.tool2');
Route::get('/tool-3', Tool3Controller::class)->name('tools.tool3');
Route::get('/manager-cheat-sheets', ManagerCheatSheetsController::class)->name('tools.manager-cheat-sheets');
Route::get('/ski-resort', WeatherController::class)->name('tools.ski-resort');

Route::middleware('auth')->group(function () {
    Route::post('/push/subscriptions', [PushSubscriptionController::class, 'store'])
        ->name('push.subscriptions.store');

    Route::delete('/push/subscriptions', [PushSubscriptionController::class, 'destroy'])
        ->name('push.subscriptions.destroy');

    Route::patch('/tool-1/ideas/{startupIdea}', [Tool1Controller::class, 'update'])
        ->middleware(EnsureUserCanEditStartupIdeas::class)
        ->name('tools.tool1.update');

    Route::post('/logout', LogoutController::class)->name('logout');
});
