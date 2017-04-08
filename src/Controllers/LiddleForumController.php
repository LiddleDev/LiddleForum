<?php

namespace LiddleDev\LiddleForum\Controllers;

use LiddleDev\LiddleForum\Models\Category;

class LiddleForumController extends LiddleForumBaseController
{
    public function getIndex()
    {
        $categories = Category::whereNull('parent_id')->orderBY('order', 'ASC')->get();

        return view('liddleforum::index', [
            'categories' => $categories,
        ]);
    }
}