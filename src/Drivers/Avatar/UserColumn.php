<?php

namespace LiddleDev\LiddleForum\Drivers\Avatar;

use Illuminate\Database\Eloquent\Model;

class UserColumn implements AvatarInterface
{
    public function getUrl(Model $user)
    {
        if ( ! $column = config('liddleforum.user.avatar.user_column.url_column')) {
            throw new \Exception('Can\'t find url_column in config');
        }

        if ( ! $url = $user->$column) {
            return config('liddleforum.user.avatar.default_url', self::DEFAULT_URL);
        }

        return $url;
    }
}