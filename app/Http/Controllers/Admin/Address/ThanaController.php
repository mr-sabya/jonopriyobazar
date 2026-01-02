<?php

namespace App\Http\Controllers\Admin\Address;

use App\Models\Thana;
use App\Models\District;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ThanaController extends Controller
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
        $districts = District::orderBy('name', 'ASC')->get();
        if (request()->ajax()) {
            return datatables()->of(Thana::latest()->get())
            ->addColumn('district', function ($thana) {
                $district = $thana->district['name'];
                return $district;
            })
            ->addColumn('action', function ($thana) {
               $button = '<button type="button" name="edit" id="' . $thana->id . '" class="edit btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-edit"></i></button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="' . $thana->id . '" class="delete btn btn-table waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></button>';
                return $button;
            })
            ->rawColumns(['district', 'action',])
            ->addIndexColumn()
            ->make(true);
        }

        return view('backend.address.thana.index', compact('districts'));
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
            'name' => 'required|max:255|unique:thanas',
            'district_id' => 'required'
        ]);

        if ($validator->fails())
        {
            $errors = array(
                'name'=>$validator->errors()->first('name'),
                'district_id'=>$validator->errors()->first('district_id'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }


        $thana = new Thana;
        $thana->name = $request->name;
        $thana->district_id = $request->district_id;

        // return $thana;
        $thana->save();
        return response()->json(['success' => 'thana is successfully added']);
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
        $thana = Thana::findOrFail(intval($id));

        $district = '';
        $districts = District::orderBy('name', 'ASC')->get();
        foreach ($districts as $data) {
            if($data->id == $thana->district_id){
                $district .= '<option value="'.$data->id.'" selected>'.$data->name.'</option>';
            }else{
                $district .= '<option value="'.$data->id.'">'.$data->name.'</option>';
            }
        }

        return response()->json([
            'district' => $district,
            'thana' => $thana
        ]);
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
        $thana = Thana::where('id', $request->hidden_id)->firstOrFail();

        if($thana->name == $request->name){
            $validator = \Validator::make($request->all(), [
                'name' => 'required|max:255',
                'district_id' => 'required'
            ]);
        }else{
            $validator = \Validator::make($request->all(), [
                'name' => 'required|max:255|unique:thanas',
                'district_id' => 'required'
            ]);
        }
        

        if ($validator->fails())
        {
            $errors = array(
                'name'=>$validator->errors()->first('name'),
                'district_id'=>$validator->errors()->first('district_id'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }


        $thana->name = $request->name;
        $thana->district_id = $request->district_id;

        // return $thana;
        $thana->save();
        return response()->json(['success' => 'A thana has been updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $thana = Thana::with('city')->findOrFail(intval($id));

        if($thana->city->count()>0){
            return response()->json(['error' => 'thana has not been deleted! Many cities are assigned']);
        }else{
            $thana->delete();
            return response()->json(['success' => 'thana has been successfully deleted']);
        }
    }
}
