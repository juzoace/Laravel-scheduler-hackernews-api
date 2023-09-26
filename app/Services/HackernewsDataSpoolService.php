<?php
namespace App\Services;

use App\Jobs\FetchHackernewsStories;

class HackernewsDataSpoolService
{
    public function spoolData()
    {
        // Fetch up to 100 stories
        FetchHackernewsStories::dispatch(100);
    }
}
