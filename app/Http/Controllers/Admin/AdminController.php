<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authUser = Admin::find(Auth::user()->id);
        // Permission check using standard Laravel Auth
        if (!$authUser->can('admin.admins.index')) {
            abort(403, 'Unauthorized action.');
        }
        return view('backend.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authuser = Admin::find(Auth::user()->id);
        if (!$authuser->can('admin.admins.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('backend.user.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $authuser = Admin::find(Auth::user()->id);
        if (!$authuser->can('admin.admins.edit')) {
            abort(403, 'Unauthorized action.');
        }
        $user = Admin::findOrFail(intval($id));
        return view('backend.user.edit', compact('user'));
    }
}