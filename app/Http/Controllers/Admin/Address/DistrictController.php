<?php

namespace App\Http\Controllers\Admin\Address;

use Validator;
use App\Models\District;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DistrictController extends Controller
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
            return datatables()->of(District::latest()->get())
            ->addColumn('action', function ($district) {
                $button = '<button type="button" name="edit" id="' . $district->id . '" class="edit btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-edit"></i></button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="' . $district->id . '" class="delete btn btn-table waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('backend.address.district.index');
    }

    public function getDistrict()
    {
        $districts = District::orderBy('name', 'ASC')->get();

        $district = '';

        foreach ($districts as $data) {
            $district .= '<option value="'.$data->id.'">'.$data->name.'</option>';
        }

        return response()->json(['district' => $district]);
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
            'name' => 'required|string|max:255|unique:districts',
        ]);

        if ($validator->fails())
        {
            $errors = array(
                'name'=>$validator->errors()->first('name'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }

        $district = new District;
        $district->name = $request->name;

        // return $district;
        $district->save();
        return response()->json(['success' => 'district is successfully added']);
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
        $district = District::findOrFail(intval($id));
        return response()->json(['district' => $district]);
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
        $district = District::where('id', $request->hidden_id)->firstOrFail();

        if($district->name == $request->name){
            $validator = \Validator::make($request->all(), [
                'name' => 'required|string|max:255',
            ]);
        }else{
            $validator = \Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:districts',
            ]);
        }


        if ($validator->fails())
        {
            $errors = array(
                'name'=>$validator->errors()->first('name'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }
        
        $district->name = $request->name;

        // return $district;
        $district->save();
        return response()->json(['success' => 'District is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $district = District::with('thanas')->findOrFail(intval($id));

        if($district->thanas->count()>0){
            return response()->json(['error' => 'district is not deleted']);
        }else{
            $district->delete();
            return response()->json(['success' => 'district is delete']);
        }
    }
}
