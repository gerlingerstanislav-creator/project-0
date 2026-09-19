<?php

use App\Http\Controllers\Tools\Tool1Controller;
use App\Http\Controllers\Tools\Tool2Controller;
use App\Http\Controllers\Tools\Tool3Controller;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));

Route::get('/tool-1', Tool1Controller::class)->name('tools.tool1');
Route::patch('/tool-1/ideas/{startupIdea}', [Tool1Controller::class, 'update'])
    ->name('tools.tool1.update');

Route::get('/tool-2', Tool2Controller::class)->name('tools.tool2');
Route::get('/tool-3', Tool3Controller::class)->name('tools.tool3');
