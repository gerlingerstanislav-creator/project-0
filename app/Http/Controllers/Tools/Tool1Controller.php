<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Models\StartupIdea;
use App\Http\Middleware\EnsureUserCanEditStartupIdeas;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class Tool1Controller extends Controller
{
    public function __invoke(): Response
    {
        $ideas = StartupIdea::query()
            ->orderBy('id')
            ->get();

        return Inertia::render('Tool1', [
            'ideas' => $ideas,
            'canEditIdeas' => auth()->user()?->canEditIdeas() ?? false,
        ]);
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
