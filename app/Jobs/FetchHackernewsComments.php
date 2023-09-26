<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;

class FetchHackernewsComments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $storyId;
    protected $kids;

    public function __construct($storyId, $kids)
    {
        $this->storyId = $storyId;
        $this->kids = $kids;
    }

    public function handle()
    {
        try {
            // Iterate over the kids (comment IDs) and fetch each comment
            foreach ($this->kids as $commentId) {
                $this->fetchAndSaveComment($commentId);
            }
        } catch (\Exception $e) {
            Log::error('Error fetching and storing Hackernews comments: ' . $e->getMessage());
        }
    }

    protected function fetchAndSaveComment($commentId)
    {
        // Fetch comment details from the Hackernews API using the provided commentId
        $response = Http::get("https://hacker-news.firebaseio.com/v0/item/{$commentId}.json");

        if ($response->successful()) {
            $commentData = $response->json();

            // Convert Unix timestamp to datetime format for the 'time' attribute
            if (isset($commentData['time'])) {
                $commentData['time'] = date('Y-m-d H:i:s', $commentData['time']);
            }

            // Associate the comment with the storyId
            $commentData['story_id'] = $this->storyId;

            // Create a new Comment model and insert the data into the database
            Comment::create($commentData);
        } else {
            Log::error("Failed to fetch comment with ID: {$commentId}. Response: {$response->body()}");
        }
    }
}
