<?php

namespace LiddleDev\LiddleForum\Controllers\Admin;

use Illuminate\Http\Request;

class HomeController
{
    public function getIndex()
    {
        return redirect()->route('liddleforum.admin.admins.index');
    }

}