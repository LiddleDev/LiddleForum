<?php

namespace LiddleDev\LiddleForum\Controllers\Admin;

use Illuminate\Http\Request;
use LiddleDev\LiddleForum\Models\Category;

class CategoriesController
{
    public function getCreate()
    {
        $categories = Category::orderBy('parent_id')->get();

        return view('liddleforum::admin.categories.create', [
            'categories' => $categories,
        ]);
    }

    public function postCreate()
    {

    }

    public function getEdit()
    {
        $categories = Category::orderBy('parent_id')->get();
        $baseCategories = Category::whereNull('parent_id')->get();

        return view('liddleforum::admin.categories.edit', [
            'categories' => $categories,
            'baseCategories' => $baseCategories,
        ]);
    }

    public function postEdit()
    {

    }

    public function getDelete()
    {
        $categories = Category::orderBy('parent_id')->get();

        return view('liddleforum::admin.categories.delete', [
            'categories' => $categories,
        ]);
    }

    public function deleteCategory()
    {

    }

}