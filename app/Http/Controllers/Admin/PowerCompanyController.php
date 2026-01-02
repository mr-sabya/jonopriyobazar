<?php

namespace App\Http\Controllers\Admin;

use App\Models\PowerCompany;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PowerCompanyController extends Controller
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
        if (request()->ajax()) {
            return datatables()->of(PowerCompany::latest()->get())

            ->addColumn('company_image', function ($power) {
                $url = "/upload/images/".$power->logo;
                return '<img src="'.$url.'">';
            })
            ->addColumn('action', function ($power) {
                $button = '<a href="'.route('admin.power.edit', $power->id).'" name="edit" id="' . $power->id . '" class="edit btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-edit"></i></a>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="' . $power->id . '" class="delete btn btn-table waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></button>';
                return $button;
            })
            ->rawColumns(['company_image', 'action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('backend.power.index');
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
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:255',
            'type' => 'required',
            'logo' => 'required|image|mimes:jpeg,jpg,gif,png|max:2048',
        ]);

        if ($validator->fails())
        {
            $errors = array(
                'name'=>$validator->errors()->first('name'),
                'logo'=>$validator->errors()->first('logo'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }

        $power = new PowerCompany;
        $power->name = $request->name;
        $power->type = $request->type;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalName();
            $filename = time().'-power-company-'.$extension;
            $file->move('upload/images/', $filename);
            $power->logo = $filename;
        }
        $power->save();

        return response()->json(['success' => 'New Power Distribution Company is added']);
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
        $power = PowerCompany::findOrFail(intval($id));
        return view('backend.power.edit', compact('power'));
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
        $power = PowerCompany::where('id', $request->id)->firstOrFail();

        
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:255',
            'type' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,jpg,gif,png|max:2048',
        ]);
        


        if ($validator->fails())
        {
            $errors = array(
                'name'=>$validator->errors()->first('name'),
                'logo'=>$validator->errors()->first('logo'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }


        $power->name = $request->name;
        $power->type = $request->type;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalName();
            $filename = time().'-power-company-'.$extension;
            $file->move('upload/images/', $filename);
            $power->logo = $filename;
        }
        $power->save();

        return response()->json([
            'route' => route('admin.power.index'),
        ]);
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
