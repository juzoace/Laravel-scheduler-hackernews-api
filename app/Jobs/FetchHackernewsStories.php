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
            // Fetch stories from the Hackernews API
            $response = Http::get('https://hacker-news.firebaseio.com/v0/topstories.json');

            if ($response->successful()) {
                $storyIds = $response->json();

                // Limit the number of stories fetched
                $storyIds = array_slice($storyIds, 0, $this->limit);

                foreach ($storyIds as $storyId) {
                    // Fetch story details from the Hackernews API using the provided storyId
                    $storyResponse = Http::get("https://hacker-news.firebaseio.com/v0/item/{$storyId}.json");

                    if ($storyResponse->successful()) {
                        $storyData = $storyResponse->json();

                        $category = $this->determineCategory($storyData['title'] ?? '');

                        // Check if the story already exists in the database
                        $existingStory = Story::find($storyData['id']);

                        if ($existingStory) {
                            // Update the existing story with the new data
                            $existingStory->update([
                                'title' => $storyData['title'],
                                'url' => $storyData['url'],
                                'score' => $storyData['score'],
                                'time' => date('Y-m-d H:i:s', $storyData['time']),
                                'category_id' => $category->id,
                            ]);
                        } else {
                            // Save the story to the database
                            Story::create([
                                'id' => $storyData['id'],
                                'title' => $storyData['title'],
                                'url' => $storyData['url'],
                                'score' => $storyData['score'],
                                'time' => date('Y-m-d H:i:s', $storyData['time']),
                                'category_id' => $category->id,
                            ]);
                        }

                        // Dispatch the FetchHackernewsComments job for the story's comments
                        if (isset($storyData['kids'])) {
                            FetchHackernewsComments::dispatch($storyData['id'], $storyData['kids']);
                        }

                        // Assuming the author information is under 'by' in the storyData array
                        if (isset($storyData['by'])) {
                            FetchHackernewsAuthors::dispatch($storyData['id'], $storyData['by']);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Error fetching and storing Hackernews stories and comments: ' . $e->getMessage());
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
