<?php

namespace LiddleDev\LiddleForum\Models;

class Thread extends LiddleForumModel
{
    protected $table = 'threads';

    protected $fillable = ['title', 'category_id', 'user_id', 'slug'];

    public function author()
    {
        return $this->belongsTo(config('liddleforum.user.model'), 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'thread_id');
    }

    public function followers()
    {
        return $this->hasMany(ThreadFollower::class, 'thread_id');
    }

    /**
     * @return Post
     */
    public function getOriginalPost()
    {
        return $this->posts()->orderBy('created_at', 'ASC')->first();
    }

    /**
     * @return Post
     */
    public function getMostRecentPost()
    {
        return $this->posts()->orderBy('created_at', 'DESC')->first();
    }
}
