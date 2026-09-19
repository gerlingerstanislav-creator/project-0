<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Models\StartupIdea;
use Illuminate\View\View;

class Tool1Controller extends Controller
{
    public function __invoke(): View
    {
        $ideas = StartupIdea::query()
            ->orderBy('id')
            ->get();

        return view('tools.tool1', compact('ideas'));
    }
}
