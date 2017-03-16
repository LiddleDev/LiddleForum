<?php

namespace LiddleDev\LiddleForum\Controllers;

use Illuminate\Routing\Controller;
use LiddleDev\LiddleForum\Models\Category;

class LiddleForumController extends Controller
{
    public function getIndex()
    {
        $categories = Category::whereNull('parent_id')->orderBY('order', 'ASC')->get();

        return view('liddleforum::index', [
            'categories' => $categories,
        ]);
    }
}