<?php

namespace LiddleDev\LiddleForum\Controllers\Admin;

use Validator;
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
        $adminObject = new Admin();

        $userClass = config('liddleforum.user.model');
        $userObject = new $userClass();

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:' . $userObject->getTable() . ',' . $userObject->getKeyName() . '|unique:' . $adminObject->getTable() . ',user_id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('liddleforum.admin.admins.index')
                ->withErrors($validator, 'liddleforum')
                ->withInput();
        }

        $admin = Admin::create([
            'user_id' => $request->input('user_id'),
        ]);

        $request->session()->flash('liddleforum_success', $admin->user->{config('liddleforum.user.name_column')} . ' is now an admin.');
        return redirect()->route('liddleforum.admin.admins.index');
    }

    public function deleteAdmin(Request $request, $admin_id)
    {
        if ( ! $admin = $this->fetchAdmin($admin_id)) {
            abort(404);
        }

        $admin->delete();

        $request->session()->flash('liddleforum_success', 'Admin privileges have been revoked');
        return redirect()->route('liddleforum.admin.admins.index');
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