<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Models\NewsFeedback;
use App\Models\NewsPreference;
use App\Services\NewsAggregatorService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    public function __invoke(Request $request, NewsAggregatorService $aggregator): Response
    {
        $feedback = NewsFeedback::query()
            ->where('user_id', $request->user()->id)
            ->get(['scope', 'target_key', 'action']);

        $preference = NewsPreference::query()
            ->where('user_id', $request->user()->id)
            ->first();

        return Inertia::render('News', [
            'articles' => $aggregator->getFeed($request->user()),
            'sources' => $aggregator->sources(),
            'updatedAt' => now()->toIso8601String(),
            'selectedCategories' => $preference?->categories ?? ['Для тебя'],
            'minImportance' => $preference?->min_importance ?? 0.45,
            'feedback' => $feedback->map(fn (NewsFeedback $item) => [
                'scope' => $item->scope,
                'targetKey' => $item->target_key,
                'action' => $item->action,
            ])->values()->all(),
        ]);
    }

    public function savePreferences(Request $request)
    {
        $data = $request->validate([
            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => ['string', 'max:40'],
            'min_importance' => ['required', 'numeric', 'between:0.45,0.85'],
        ]);

        $categories = array_values(array_unique($data['categories']));

        if (in_array('Для тебя', $categories, true)) {
            $categories = ['Для тебя'];
        }

        NewsPreference::updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                'categories' => $categories,
                'min_importance' => (float) $data['min_importance'],
            ],
        );

        return back();
    }

    public function feedback(Request $request)
    {
        $data = $request->validate([
            'scope' => ['required', 'in:article,source'],
            'target_key' => ['required', 'string', 'max:64'],
            'action' => ['required', 'in:more,less,hide'],
            'categories' => ['array'],
            'categories.*' => ['string', 'max:40'],
            'sources' => ['array'],
            'sources.*' => ['string', 'max:120'],
        ]);

        if ($data['scope'] === 'article' && $data['action'] === 'hide') {
            abort(422, 'Скрытие статьи использует действие less.');
        }

        NewsFeedback::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'scope' => $data['scope'],
                'target_key' => $data['target_key'],
            ],
            [
                'action' => $data['action'],
                'categories' => array_values($data['categories'] ?? []),
                'sources' => array_values($data['sources'] ?? []),
            ],
        );

        return back();
    }

    public function removeFeedback(Request $request)
    {
        $data = $request->validate([
            'scope' => ['required', 'in:article,source'],
            'target_key' => ['required', 'string', 'max:64'],
        ]);

        NewsFeedback::query()
            ->where('user_id', $request->user()->id)
            ->where('scope', $data['scope'])
            ->where('target_key', $data['target_key'])
            ->delete();

        return back();
    }
}
