<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class Tool2Controller extends Controller
{
    public function __invoke(): View
    {
        return view('tools.tool2');
    }
}
