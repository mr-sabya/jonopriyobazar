<?php

namespace App\Http\Controllers\Admin\Address;

use App\Models\City;
use App\Models\Thana;
use App\Models\District;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CityController extends Controller
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
            return datatables()->of(City::latest()->get())
            ->addColumn('thana', function ($city) {
                $thana = $city->thana['name'];
                return $thana;
            })
            ->addColumn('action', function ($city) {
                $button = '<button type="button" name="edit" id="' . $city->id . '" class="edit btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-edit"></i></button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="' . $city->id . '" class="delete btn btn-table waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></button>';
                return $button;
            })
            ->rawColumns(['thana', 'action',])
            ->addIndexColumn()
            ->make(true);
        }

        return view('backend.address.city.index', compact('districts'));
    }


    public function getThana($id)
    {
        $thanas = Thana::where('district_id', $id)->get();
        $data = '';
        foreach ($thanas as $thana) {
            $data .= '<option value="'.$thana->id.'">'.$thana->name.'</option>';
        }

        return response()->json(['thana' => $data]);
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
            'name' => 'required|max:255|unique:cities',
            'district_id' => 'required',
            'thana_id' => 'required',
        ]);

        if ($validator->fails())
        {
            $errors = array(
                'name'=>$validator->errors()->first('name'),
                'district_id'=>$validator->errors()->first('district_id'),
                'thana_id'=>$validator->errors()->first('thana_id'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }

        $city = new City();
        $city->thana_id = $request->thana_id;
        $city->name = $request->name;
        $city->delivery_charge = $request->delivery_charge;
        $city->save();

        return response()->json(['success' => 'A city is successfully added']);
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
        $city = City::with('thana')->findOrFail(intval($id));

        $thanas = Thana::where('district_id', $city->thana['district_id'])->get();

        $thana = '';

        foreach ($thanas as $data) {
            if($city->thana_id == $data->id){
                $thana .= '<option value="'.$data->id.'" selected>'.$data->name.'</option>';
            }else{
                $thana .= '<option value="'.$data->id.'">'.$data->name.'</option>';

            }
        }

        $districts = District::orderBy('name', 'ASC')->get();

        $district = '';

        foreach ($districts as $data) {
            if($data->id == $city->thana['district_id']){
                $district .= '<option value="'.$data->id.'" selected>'.$data->name.'</option>';
            }else{
                $district .= '<option value="'.$data->id.'">'.$data->name.'</option>';
            }
        }

        return response()->json([
            'city' => $city,
            'district' => $district,
            'thana' => $thana,
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
        $city = City::where('id', $request->hidden_id)->firstOrFail();

        if($city->name == $request->name){
            $validator = \Validator::make($request->all(), [
                'name' => 'required|max:255',
                'district_id' => 'required',
                'thana_id' => 'required',
            ]);
        }else{
            $validator = \Validator::make($request->all(), [
                'name' => 'required|max:255|unique:cities',
                'district_id' => 'required',
                'thana_id' => 'required',
            ]);
        }
        

        if ($validator->fails())
        {
            $errors = array(
                'name'=>$validator->errors()->first('name'),
                'district_id'=>$validator->errors()->first('district_id'),
                'thana_id'=>$validator->errors()->first('thana_id'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }

        $city->thana_id = $request->thana_id;
        $city->name = $request->name;
        $city->delivery_charge = $request->delivery_charge;
        $city->save();

        return response()->json(['success' => 'City has been updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::findOrFail(intval($id));

        $city->delete();
        return response()->json(['success' => 'City has been delete successfully']);
    }
}
