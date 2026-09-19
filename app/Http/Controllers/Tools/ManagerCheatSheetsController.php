<?php
namespace App\Http\Controllers\Tools;
use App\Http\Controllers\Controller;
use App\Models\ManagerCheatSheet;
use Illuminate\View\View;
class ManagerCheatSheetsController extends Controller { public function __invoke(): View { $cheatSheets=ManagerCheatSheet::query()->orderBy('id')->get(); return view('tools.manager-cheat-sheets',compact('cheatSheets')); } }
