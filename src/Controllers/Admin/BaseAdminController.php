<?php

namespace LiddleDev\LiddleForum\Controllers\Admin;

use Illuminate\Http\Request;
use LiddleDev\LiddleForum\Controllers\LiddleForumBaseController;
use LiddleDev\LiddleForum\Helpers\UserHelper;

class BaseAdminController extends LiddleForumBaseController
{
    public function __construct()
    {
        $this->middleware(function ($request, $next)
        {
            if ( UserHelper::isAdmin(\Auth::user())) {
                $request->session()->flash('liddleforum_error', 'You do not have administrative privileges');
                return redirect()->route('liddleforum.index');
            }

            return $next($request);
        });
    }
}