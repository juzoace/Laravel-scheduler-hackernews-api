<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Models\Author;
use App\Models\Story;
use Illuminate\Support\Facades\Log;

class FetchHackernewsAuthors implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $storyId;
    protected $username;

    public function __construct($storyId, $username)
    {
        $this->storyId = $storyId;
        $this->username = $username;
    }

    public function handle()
    {
        try {
            // Fetch author details from the Hackernews API using the provided username
            $response = Http::get("https://hacker-news.firebaseio.com/v0/user/{$this->username}.json");

            if ($response->successful()) {
                $authorData = $response->json();

                // Prepare the data for saving/updating
                $authorAttributes = [
                    'karma' => $authorData['karma'] ?? null,
                    'about' => $authorData['about'] ?? null,
                    'username' => $this->username,
                ];

                // Save or update the author's details
                $author = Author::updateOrCreate(['username' => $this->username], $authorAttributes);

                // Update the story's author_id with the fetched author's ID
                $story = Story::find($this->storyId);
                if ($story) {
                    $story->author_id = $author->id;
                    $story->save();
                }
            }
        } catch (\Exception $e) {
            Log::error('Error fetching and storing Hackernews author: ' . $e->getMessage());
        }
    }
}
