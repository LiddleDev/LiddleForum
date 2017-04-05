<?php

namespace LiddleDev\LiddleForum\Controllers\Admin;

use Illuminate\Http\Request;
use LiddleDev\LiddleForum\Models\Admin;
use LiddleDev\LiddleForum\Models\Category;
use LiddleDev\LiddleForum\Models\Moderator;

class HomeController
{
    public function getIndex()
    {
        $admins = Admin::with('user')->get();
        $moderators = Moderator::with('user')->with('category')->get();

        $categories = Category::orderBy('parent_id')->get();

        $baseCategories = Category::whereNull('parent_id')->get();

        return view('liddleforum::admin.index', [
            'admins' => $admins,
            'moderators' => $moderators,
            'categories' => $categories,
            'baseCategories' => $baseCategories,
        ]);
    }

    public function deleteAdmin(Request $request, $admin_id)
    {
        if ( ! $admin = $this->fetchAdmin($admin_id)) {
            abort(404);
        }

        $admin->delete();

        $request->session()->flash('liddleforum_success', 'Admin privileges have been revoked');
        return redirect()->route('liddleforum.admin.index');
    }

    public function postCreateAdmin(Request $request)
    {

    }

    public function deleteModerator(Request $request, $moderator_id)
    {
        if ( ! $moderator = $this->fetchModerator($moderator_id)) {
            abort(404);
        }

        $moderator->delete();

        $request->session()->flash('liddleforum_success', 'Moderator privileges have been revoked');
        return redirect()->route('liddleforum.admin.index');
    }

    public function postCreateModerator(Request $request)
    {

    }

    /**
     * @param $moderator_id
     * @return Moderator|null
     */
    protected function fetchModerator($moderator_id)
    {
        return Moderator::where('id', '=', $moderator_id)->first();
    }

    /**
     * @param $admin_id
     * @return Admin|null
     */
    protected function fetchAdmin($admin_id)
    {
        return Admin::where('id', '=', $admin_id)->first();
    }

}