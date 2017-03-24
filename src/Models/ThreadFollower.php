<?php

namespace LiddleDev\LiddleForum\Models;

class ThreadFollower extends LiddleForumModel
{
    protected $table = 'thread_followers';

    public $timestamps = false;

    protected $fillable = ['thread_id', 'user_id'];

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id');
    }

    public function user()
    {
        return $this->belongsTo(config('liddleforum.user.model'), 'user_id');
    }
}
