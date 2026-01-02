<?php

namespace App\Http\Controllers\Admin;

use App\Models\DeliveryStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliverStatusController extends Controller
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
            return datatables()->of(DeliveryStatus::latest()->get())
            ->addColumn('action', function ($status) {
                $button = '<button type="button" name="edit" id="' . $status->id . '" class="edit btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-edit"></i></button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="' . $status->id . '" class="delete btn btn-table waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('backend.deliverystatus.index');
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
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:delivery_statuses',
        ]);

        if ($validator->fails())
        {
            $errors = array(
                'name'=>$validator->errors()->first('name'),
                'slug'=>$validator->errors()->first('slug'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }

        $status = new DeliveryStatus;
        $status->name = $request->name;
        $status->slug = $request->slug;
        $status->save();

        return response()->json(['success' => 'New Status is added successfully']);
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
        $status = DeliveryStatus::findOrFail(intval($id));
        return response()->json(['status' => $status]);
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
        $status = DeliveryStatus::where('id', $request->hidden_id)->firstOrFail();

        if($request->name == $status->name){
            $validator = \Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ]);
        }else{
            $validator = \Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:delivery_statuses',
            ]);
        }

        
        if ($validator->fails())
        {
            $errors = array(
                'name'=>$validator->errors()->first('name'),
                'slug'=>$validator->errors()->first('slug'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }

        
        $status->name = $request->name;
        $status->slug = $request->slug;
        $status->save();

        return response()->json(['success' => 'Status has been updated successfully']);
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
