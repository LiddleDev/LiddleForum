<?php

namespace LiddleDev\LiddleForum\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use LiddleDev\LiddleForum\Models\Category;
use LiddleDev\LiddleForum\Models\Moderator;

class ModeratorsController extends BaseAdminController
{
    public function getIndex()
    {
        $moderators = Moderator::with('user')->with('category')->get();

        $categories = Category::orderBy('parent_id')->get();

        return view('liddleforum::admin.moderators', [
            'moderators' => $moderators,
            'categories' => $categories,
        ]);
    }

    public function postCreate(Request $request)
    {
        $userClass = config('liddleforum.user.model');
        $userObject = new $userClass();

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:' . $userObject->getTable() . ',' . $userObject->getKeyName(),
        ]);

        if ($validator->fails()) {
            return redirect()->route('liddleforum.admin.moderators.index')
                ->withErrors($validator, 'liddleforum')
                ->withInput();
        }

        $userId = $request->input('user_id');

        // Check if user/category pair already exists
        $categoryId = $request->input('category_id') ? $request->input('category_id') : null;
        if ($categoryId) {
            if ( ! $category = Category::where('id', '=', $categoryId)->first()) {
                $request->session()->flash('liddleforum_error', 'Invalid category');
                return redirect()->route('liddleforum.admin.moderators.index');
            }

            if (Moderator::where('user_id', '=', $userId)->where('category_id', '=', $categoryId)->first()) {
                $request->session()->flash('liddleforum_error', 'User is already a moderator of category: ' . $category->name);
                return redirect()->route('liddleforum.admin.moderators.index');
            }
        } else {
            if (Moderator::where('user_id', '=', $userId)->whereNull('category_id')->first()) {
                $request->session()->flash('liddleforum_error', 'User is already a global moderator');
                return redirect()->route('liddleforum.admin.moderators.index');
            }
        }

        $moderator = Moderator::create([
            'user_id' => $userId,
            'category_id' => $categoryId,
        ]);

        $request->session()->flash('liddleforum_success', $moderator->user->{config('liddleforum.user.name_column')} . ' is now a moderator.');
        return redirect()->route('liddleforum.admin.moderators.index');
    }

    public function deleteModerator(Request $request, $moderator_id)
    {
        if ( ! $moderator = $this->fetchModerator($moderator_id)) {
            abort(404);
        }

        $moderator->delete();

        $request->session()->flash('liddleforum_success', 'Moderator privileges have been revoked');
        return redirect()->route('liddleforum.admin.moderators.index');
    }

    /**
     * @param $moderator_id
     * @return Moderator|null
     */
    protected function fetchModerator($moderator_id)
    {
        return Moderator::where('id', '=', $moderator_id)->first();
    }

}