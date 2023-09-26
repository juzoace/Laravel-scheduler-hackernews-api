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

    public function __construct($storyId)
    {
        $this->storyId = $storyId;
    }

    public function handle()
    {
        try {
            // Fetch comments for the given story from the Hackernews API
            $response = Http::get("https://hacker-news.firebaseio.com/v0/item/{$this->storyId}.json");

            if ($response->successful()) {
                $storyData = $response->json();

                // Check if the story has associated comments
                if (isset($storyData['kids'])) {
                    $commentIds = $storyData['kids'];

                    foreach ($commentIds as $commentId) {
                        $this->fetchAndSaveComment($commentId);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Error fetching and storing Hackernews comments: ' . $e->getMessage());
        }
    }

    protected function fetchAndSaveComment($commentId, $parentId = null)
    {
        // Fetch comment details from the Hackernews API using the provided commentId
        $response = Http::get("https://hacker-news.firebaseio.com/v0/item/{$commentId}.json");

        if ($response->successful()) {
            $commentData = $response->json();

            // Convert Unix timestamp to datetime format for the 'time' attribute
            if (isset($commentData['time'])) {
                $commentData['time'] = date('Y-m-d H:i:s', $commentData['time']);
            }

            // Check if the comment already exists (based on ID) to avoid duplicates
            if (!Comment::where('id', $commentId)->exists()) {
                // If parentId is provided, set the parent ID in the comment data
                if ($parentId) {
                    $commentData['parent'] = $parentId;
                }

                // Create a new Comment model and insert the data into the database
                Comment::create($commentData);

                // Recursively fetch and save child comments
                if (isset($commentData['kids'])) {
                    foreach ($commentData['kids'] as $childCommentId) {
                        $this->fetchAndSaveComment($childCommentId, $commentId);
                    }
                }
            }
        }
    }
}
