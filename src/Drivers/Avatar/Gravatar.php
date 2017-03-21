<?php

namespace LiddleDev\LiddleForum\Drivers\Avatar;

use Illuminate\Database\Eloquent\Model;

class Gravatar implements AvatarInterface
{
    const IMAGE_URL = 'https://www.gravatar.com/avatar/%s?d=%s';

    public function getUrl(Model $user)
    {
        if ( ! $column = config('liddleforum.user.avatar.drivers.gravatar.email_column')) {
            throw new \Exception('Can\'t find gravatar email_column in config');
        }

        if ( ! $email = $user->$column) {
            return config('liddleforum.user.avatar.default_url', self::DEFAULT_URL);
        }

        $hash = md5(strtolower(trim($email)));

        $default = config('liddleforum.user.avatar.drivers.gravatar.default', 'mm');

        return sprintf(self::IMAGE_URL, $hash, $default);
    }
}