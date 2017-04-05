<?php

namespace LiddleDev\LiddleForum\Controllers\Admin;

use Illuminate\Http\Request;

class HomeController
{
    public function getIndex()
    {
        return view('liddleforum::admin.index', []);
    }

}