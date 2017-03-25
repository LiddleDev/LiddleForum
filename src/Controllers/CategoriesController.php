<?php

namespace LiddleDev\LiddleForum\Controllers;

use Illuminate\Routing\Controller;
use LiddleDev\LiddleForum\Models\Category;

class CategoriesController extends Controller
{
    public function getCategories()
    {
        $categories = Category::get();

        return view('liddleforum::categories.all', [
            'categories' => $categories,
        ]);
    }

    public function getCategory($category)
    {
        if ( ! $category = $this->fetchCategory($category)) {
            abort(404);
        }

        // TODO this is ordering by thread created_at instead of most recent post created_at
        $threads = $category->threads()
            ->orderBy('stickied', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->paginate(config('liddleforum.paginate.threads', 15));

        return view('liddleforum::categories.view', [
            'category' => $category,
            'threads' => $threads,
        ]);
    }

    /**
     * @param $category
     * @return Category|null
     */
    protected function fetchCategory($category)
    {
        return Category::where('slug', '=', $category)->first();
    }
}