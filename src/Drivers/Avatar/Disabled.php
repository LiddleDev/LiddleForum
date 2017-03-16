<?php

namespace LiddleDev\LiddleForum\Drivers\Avatar;

use Illuminate\Database\Eloquent\Model;

class Disabled implements AvatarInterface
{
    public function getUrl(Model $user)
    {
        return config('liddleforum.user.avatar.default_url', self::DEFAULT_URL);
    }
}