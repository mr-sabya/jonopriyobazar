<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
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
        if(!Auth::user()->can('admin.permissions.index')){
            return redirect()->route('error.404');
        }

        if(request()->ajax())
        {
            return datatables()->of(Permission::orderBy('group_name', 'ASC')->get())
            ->addColumn('action', function($data){
                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        
        return view('backend.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('admin.permissions.store')){
            return redirect()->route('error.404');
        }

        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:permissions',
            'group_name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails())
        {
            $errors = array(
                'name'=>$validator->errors()->first('name'),
                'group_name'=>$validator->errors()->first('group_name'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }

        $permission = new Permission;
        
        $permission->name = $request->name;
        $permission->group_name = $request->group_name;
        $permission->guard_name = 'admin';
        $permission->save();

        return response()->json(['success' => 'Permissions are added']);
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
        if(!Auth::user()->can('admin.permissions.edit')){
            return redirect()->route('error.404');
        }

        $permission = Permission::findOrFail(intval($id));
        return response()->json(['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!Auth::user()->can('admin.permissions.update')){
            return redirect()->route('error.404');
        }

        $permission = Permission::where('id', $request->hidden_id)->first();

        if($request->name == $permission->name){
            $request->validate([
                'name' => 'required|string|max:255',
                'group_name' => 'required|string|max:255',
            ]);
        }else{
            $request->validate([
                'name' => 'required|string|max:255|unique:permissions',
                'group_name' => 'required|string|max:255',
            ]);
        }

        $permission->name = $request->name;
        $permission->group_name = $request->group_name;

        $permission->save();

        return response()->json(['success' => 'Permission has been updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
