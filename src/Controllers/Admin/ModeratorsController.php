<?php

namespace LiddleDev\LiddleForum\Controllers\Admin;

use Illuminate\Http\Request;
use LiddleDev\LiddleForum\Models\Category;
use LiddleDev\LiddleForum\Models\Moderator;

class ModeratorsController
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

    }

    public function deleteModerator(Request $request, $moderator_id)
    {
        if ( ! $moderator = $this->fetchModerator($moderator_id)) {
            abort(404);
        }

        $moderator->delete();

        $request->session()->flash('liddleforum_success', 'Moderator privileges have been revoked');
        return redirect()->route('liddleforum.admin.moderators');
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