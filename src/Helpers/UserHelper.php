<?php

namespace LiddleDev\LiddleForum\Helpers;

use Illuminate\Database\Eloquent\Model;
use LiddleDev\LiddleForum\Models\Admin;
use LiddleDev\LiddleForum\Models\Category;
use LiddleDev\LiddleForum\Models\Moderator;

class UserHelper
{
    /**
     * @param Model $user
     * @return bool
     */
    public static function isAdmin(Model $user)
    {
        return (bool)Admin::where('user_id', '=', $user->getKey())->count();
    }

    /**
     * @param Model $user
     * @param Category|null $category
     * @return bool
     */
    public static function isModerator(Model $user, Category $category = null)
    {
        // A null category means global moderator privileges

        // Check if we have permission in any parent categories as well as this category
        $categoryIds = [];
        if ($category) {
            foreach ($category->getCategoryChain() as $parentCategory) {
                $categoryIds[] = $parentCategory->id;
            }
            $categoryIds[] = $category->id;
        }

        $category->getCategoryChain();

        return (bool)Moderator::where('user_id', '=', $user->getKey())
            ->where(function ($query) use ($categoryIds) {
                $query->whereNull('category_id');

                // Check for category level moderation too if we're just checking for moderators of that category
                if (count($categoryIds)) {
                    $query->orWhereIn('category_id', $categoryIds);

                }
            })
            ->count();
    }
}
