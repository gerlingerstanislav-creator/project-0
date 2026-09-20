<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Models\ManagerCheatSheet;
use Inertia\Inertia;
use Inertia\Response;

class ManagerCheatSheetsController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('ManagerCheatSheets', ['cheatSheets' => ManagerCheatSheet::query()->orderBy('id')->get()]);
    }
}
