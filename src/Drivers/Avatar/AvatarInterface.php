<?php

namespace LiddleDev\LiddleForum\Drivers\Avatar;

use Illuminate\Database\Eloquent\Model;

interface AvatarInterface
{
    const DEFAULT_URL = 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm&f=y';

    public function getUrl(Model $user);
}