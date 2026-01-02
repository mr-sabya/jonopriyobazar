<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
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
        if(!Auth::user()->can('admin.roles.index')){
            return redirect()->route('error.404');
        }
        $roles = Role::all();
        return view('backend.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('admin.roles.create')){
            return redirect()->route('error.404');
        }
        $all_permissions = Permission::all();
        $permission_groups = Admin::getpermissionGroups();
        return view('backend.role.create', compact('all_permissions', 'permission_groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('admin.roles.store')){
            return redirect()->route('error.404');
        }

         // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:roles'
        ]);

        // Process Data
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'admin',
        ]);

        // $role = DB::table('roles')->where('name', $request->name)->first();
        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'New Role is added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->can('admin.roles.edit')){
            return redirect()->route('error.404');
        }
        $role = Role::findById($id);
        $all_permissions = Permission::all();
        $permission_groups = Admin::getpermissionGroups();
        return view('backend.role.edit', compact('role', 'all_permissions', 'permission_groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!Auth::user()->can('admin.roles.update')){
            return redirect()->route('error.404');
        }


        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:roles,name,' . $id
        ]);

        $role = Role::findById($id);
        $role->name = $request->name;
        $role->save();

        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findById($id);
        if (!is_null($role)) {
            $role->delete();
        }
        return redirect()->route('admin.roles.index')->with('success', 'Role has been deleted successfully');
    }
}