<?php

namespace LiddleDev\LiddleForum\Controllers\Admin;

use Illuminate\Http\Request;
use LiddleDev\LiddleForum\Models\Admin;
use LiddleDev\LiddleForum\Models\Category;

class AdminsController
{
    public function getIndex()
    {
        $admins = Admin::with('user')->get();

        $categories = Category::orderBy('parent_id')->get();

        return view('liddleforum::admin.admins', [
            'admins' => $admins,
            'categories' => $categories,
        ]);
    }

    public function postCreate(Request $request)
    {

    }

    public function deleteAdmin(Request $request, $admin_id)
    {
        if ( ! $admin = $this->fetchAdmin($admin_id)) {
            abort(404);
        }

        $admin->delete();

        $request->session()->flash('liddleforum_success', 'Admin privileges have been revoked');
        return redirect()->route('liddleforum.admin.admins');
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