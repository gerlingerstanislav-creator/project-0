<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Models\StartupIdea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

    public function update(Request $request, StartupIdea $startupIdea): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $startupIdea->update($validated);

        return response()->json([
            'idea' => $startupIdea->fresh(),
        ]);
    }
}
