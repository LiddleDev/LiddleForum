<?php

namespace LiddleDev\LiddleForum\Helpers;

use LiddleDev\LiddleForum\Models\Thread;

class ThreadHelper
{
    protected $reservedSlugs = [
        'create',
    ];

    public function generateSlug($title)
    {
        if ( ! $title) {
            return null;
        }

        $slug = null;
        $attempt = 0;

        do {
            $slug = str_slug($title) . ($attempt > 0 ? $attempt : '');
            $attempt++;
        } while ($this->doesSlugExist($slug));

        return $slug;
    }

    protected function doesSlugExist($slug)
    {
        if (in_array($slug, $this->reservedSlugs)) {
            return true;
        }

        return (bool)(Thread::where('slug', '=', $slug)->first());
    }
}
