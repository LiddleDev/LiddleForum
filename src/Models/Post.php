<?php

namespace LiddleDev\LiddleForum\Models;

class Post extends LiddleForumModel
{
    protected $table = 'posts';

    protected $fillable = ['thread_id', 'user_id', 'body'];

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id');
    }

    public function user()
    {
        return $this->belongsTo(config('liddleforum.user.model'), 'user_id');
    }
}
