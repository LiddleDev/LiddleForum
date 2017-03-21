<?php

namespace LiddleDev\LiddleForum\Helpers;

use LiddleDev\LiddleForum\Models\Thread;

class ThreadHelper
{
    protected static $reservedSlugs = [
        'create',
    ];

    public static function generateSlug($title)
    {
        if ( ! $title) {
            return null;
        }

        $slug = null;
        $attempt = 0;

        do {
            $slug = str_slug($title) . ($attempt > 0 ? $attempt : '');
            $attempt++;
        } while (self::doesSlugExist($slug));

        return $slug;
    }

    protected static function doesSlugExist($slug)
    {
        if (in_array($slug, self::$reservedSlugs)) {
            return true;
        }

        return (bool)(Thread::where('slug', '=', $slug)->first());
    }
}
