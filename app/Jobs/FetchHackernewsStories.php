<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Models\Story;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class FetchHackernewsStories implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $limit;

    public function __construct($limit)
    {
        $this->limit = $limit;
    }

    public function handle()
    {
        try {
            $response = Http::get('https://hacker-news.firebaseio.com/v0/topstories.json');

            if ($response->successful()) {
                $storyIds = $response->json();
                $storyIds = array_slice($storyIds, 0, $this->limit);

                foreach ($storyIds as $storyId) {
                    $storyResponse = Http::get("https://hacker-news.firebaseio.com/v0/item/{$storyId}.json");

                    if ($storyResponse->successful()) {
                        $storyData = $storyResponse->json();
                        $storyUrl = $storyData['url'] ?? "https://news.ycombinator.com/item?id={$storyData['id']}";

                        DB::transaction(function () use ($storyData, $storyUrl) {
                            $category = $this->determineCategory($storyData['title'] ?? '');

                            Story::updateOrCreate(
                                ['id' => $storyData['id']],
                                [
                                    'title' => $storyData['title'],
                                    'url' => $storyUrl,
                                    'score' => $storyData['score'],
                                    'time' => date('Y-m-d H:i:s', $storyData['time']),
                                    'category_id' => $category->id,
                                ]
                            );

                            if (isset($storyData['kids'])) {
                                FetchHackernewsComments::dispatch($storyData['id'], $storyData['kids']);
                            }

                            if (isset($storyData['by'])) {
                                FetchHackernewsAuthors::dispatch($storyData['id'], $storyData['by']);
                            }
                        });
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Error in FetchHackernewsStories at Story ID ' . ($storyData['id'] ?? 'Unknown') . ': ' . $e->getMessage());
        }
    }

    private function determineCategory($title)
    {
        if (str_contains($title, 'tech')) {
            return Category::firstOrCreate(['name' => 'Tech']);
        } elseif (str_contains($title, 'science')) {
            return Category::firstOrCreate(['name' => 'Science']);
        } else {
            return Category::firstOrCreate(['name' => 'General']);
        }
    }
}
