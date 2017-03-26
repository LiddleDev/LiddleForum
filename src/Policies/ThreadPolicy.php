<?php

namespace LiddleDev\LiddleForum\Policies;

use Illuminate\Database\Eloquent\Model;
use LiddleDev\LiddleForum\Helpers\UserHelper;
use LiddleDev\LiddleForum\Models\Thread;

class ThreadPolicy
{
    public function before($user, $ability)
    {
        // Fall through to policy for following to check if notifications are disabled
        if ('follow' === $ability) {
            return null;
        }

        // We can't check for moderators here because we don't have the thread object to pull the category from
        if (UserHelper::isAdmin($user)) {
            return true;
        }
    }

    /**
     * Used to determine whether the user can perform any displayable actions on the thread
     * @param Model $user
     * @param Thread $thread
     * @return bool
     */
    final public function update(Model $user, Thread $thread)
    {
        return $this->edit($user, $thread)
            || $this->delete($user, $thread)
            || $this->sticky($user, $thread)
            || $this->lock($user, $thread)
            || $this->follow($user, $thread)
        ;
    }

    public function create(Model $user)
    {
        return $user !== null;
    }
    
    public function edit(Model $user, Thread $thread)
    {
        if (UserHelper::isModerator($user, $thread->category)) {
            return true;
        }

        if ($thread->locked) {
            return false;
        }
        return $user->getKey() === $thread->user_id;
    }

    public function delete(Model $user, Thread $thread)
    {
        if (UserHelper::isModerator($user, $thread->category)) {
            return true;
        }

        return $user->getKey() === $thread->user_id;
    }

    public function reply(Model $user, Thread $thread)
    {
        if (UserHelper::isModerator($user, $thread->category)) {
            return true;
        }

        return ! $thread->locked;
    }

    public function sticky(Model $user, Thread $thread)
    {
        if (UserHelper::isModerator($user, $thread->category)) {
            return true;
        }

        return false;
    }

    public function lock(Model $user, Thread $thread)
    {
        if (UserHelper::isModerator($user, $thread->category)) {
            return true;
        }

        return false;
    }

    public function follow(Model $user, Thread $thread)
    {
        return config('liddleforum.notifications.followed_thread_received_reply.enabled', false) && \Auth::check();
    }
}