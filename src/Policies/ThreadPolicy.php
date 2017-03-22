<?php

namespace LiddleDev\LiddleForum\Policies;

use Illuminate\Database\Eloquent\Model;
use LiddleDev\LiddleForum\Models\Thread;

class ThreadPolicy
{
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
        ;
    }

    public function edit(Model $user, Thread $thread)
    {
        if ($thread->locked) {
            return false;
        }
        return $user->getKey() === $thread->user_id;
    }

    public function delete(Model $user, Thread $thread)
    {
        return $user->getKey() === $thread->user_id;
    }

    public function reply(Model $user, Thread $thread)
    {
        return ! $thread->locked;
    }

    public function sticky(Model $user, Thread $thread)
    {
        // TODO check if admin/moderator
        return true;
    }

    public function lock(Model $user, Thread $thread)
    {
        // TODO check if admin/moderator
        return true;
    }
}