<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class Tool3Controller extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Tool3');
    }
}
