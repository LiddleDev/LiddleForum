<?php

namespace LiddleDev\LiddleForum\Policies;

use Illuminate\Database\Eloquent\Model;
use LiddleDev\LiddleForum\Models\Post;

class PostPolicy
{
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
        if ($post->thread->locked) {
            return false;
        }
        return $user->getKey() === $post->user_id;
    }

    public function delete(Model $user, Post $post)
    {
        if ($post->thread->locked) {
            return false;
        }
        return $user->getKey() === $post->user_id;
    }
}