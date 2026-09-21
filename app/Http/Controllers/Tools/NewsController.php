<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Services\NewsAggregatorService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    public function __invoke(Request $request, NewsAggregatorService $aggregator): Response
    {
        $feed = $aggregator->getFeed();

        return Inertia::render('News', [
            'articles' => $feed['articles'],
            'sources' => $feed['sources'],
            'updatedAt' => $feed['updated_at'],
            'selectedCategories' => $request->array('categories'),
            'minImportance' => (float) $request->input('importance', 0.45),
        ]);
    }
}
