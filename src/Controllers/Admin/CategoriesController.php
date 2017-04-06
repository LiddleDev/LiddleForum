<?php

namespace LiddleDev\LiddleForum\Controllers\Admin;

use Validator;
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

    public function postCreate(Request $request)
    {
        $categoryObject = new Category();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:' . $categoryObject->getTable() . ',slug',
            'order' => 'integer',
            // TODO can't do this because selecting the placeholder fails validation when I want to set parent id to null
            //'parent_id' => 'exists:' . $categoryObject->getTable() . ',id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('liddleforum.admin.categories.create')
                ->withErrors($validator, 'liddleforum')
                ->withInput();
        }

        // Check if parent category actually exists
        $parentId = $request->input('parent_id') ? $request->input('parent_id') : null;
        if ($parentId !== null && ! Category::where('id', '=', $parentId)->first()) {
            $request->session()->flash('liddleforum_error', 'Invalid parent category');
            return redirect()->route('liddleforum.admin.categories.create');
        }

        $category = Category::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'order' => $request->input('order'),
            'parent_id' => $parentId,
        ]);

        $request->session()->flash('liddleforum_success', 'Your category has been created');
        return redirect()->route('liddleforum.admin.categories.create');
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