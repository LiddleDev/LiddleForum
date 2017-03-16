<?php

namespace LiddleDev\LiddleForum\Models;

use Illuminate\Database\Eloquent\Model;

class LiddleForumModel extends Model
{
    public function getTable()
    {
        return config('liddleforum.database_prefix') . parent::getTable();
    }
}
