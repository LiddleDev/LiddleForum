<?php

namespace LiddleDev\LiddleForum\Policies;

use Illuminate\Database\Eloquent\Model;
use LiddleDev\LiddleForum\Helpers\UserHelper;
use LiddleDev\LiddleForum\Models\Post;

class PostPolicy
{
    public function before($user, $ability)
    {
        // Fall through to policy for deleting since we don't even want admins to delete the first post of a thread
        if ('delete' === $ability) {
            return null;
        }

        // We can't check for moderators here because we don't have the post object to pull the category from
        if (UserHelper::isAdmin($user)) {
            return true;
        }
    }

    /**
     * Used to determine whether the user can perform any displayable actions on the post
     * @param Model $user
     * @param Post $post
     * @return bool
     */
    final public function update(Model $user, Post $post)
    {
        return $this->edit($user, $post) || $this->delete($user, $post);
    }

    public function edit(Model $user, Post $post)
    {
        if (UserHelper::isModerator($user, $post->thread->category)) {
            return true;
        }

        if ($post->thread->locked) {
            return false;
        }
        return $user->getKey() === $post->user_id;
    }

    public function delete(Model $user, Post $post)
    {
        // Don't let users delete the original post of a thread. Instead, they should delete the whole thread
        if ($post->thread->getOriginalPost()->id === $post->id) {
            return false;
        }

        if (UserHelper::isAdmin($user)) {
            return true;
        }

        if (UserHelper::isModerator($user, $post->thread->category)) {
            return true;
        }

        if ($user->getKey() !== $post->user_id) {
            return false;
        }

        if ($post->thread->locked) {
            return false;
        }

        return true;
    }
}