<?php

namespace LiddleDev\LiddleForum\Models;

class Admin extends LiddleForumModel
{
    protected $table = 'admins';

    public $timestamps = false;

    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(config('liddleforum.user.model'), 'user_id');
    }
}
