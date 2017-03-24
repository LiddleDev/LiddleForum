<?php

namespace LiddleDev\LiddleForum\Models;

class Moderator extends LiddleForumModel
{
    protected $table = 'moderators';

    public $timestamps = false;

    protected $fillable = ['user_id', 'category_id'];

    public function user()
    {
        return $this->belongsTo(config('liddleforum.user.model'), 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
