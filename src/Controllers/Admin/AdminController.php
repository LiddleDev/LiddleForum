<?php

namespace LiddleDev\LiddleForum\Controllers\Admin;

use LiddleDev\LiddleForum\Models\Admin;
use LiddleDev\LiddleForum\Models\Category;
use LiddleDev\LiddleForum\Models\Moderator;

class AdminController
{
    public function getIndex()
    {
        $admins = Admin::with('user')->get();
        $moderators = Moderator::with('user')->with('category')->get();

        $categories = Category::orderBy('parent_id')->get();

        return view('liddleforum::admin.index', [
            'admins' => $admins,
            'moderators' => $moderators,
            'categories' => $categories,
        ]);
    }
}