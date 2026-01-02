<?php

namespace App\Http\Controllers\Admin;

use App\Models\CancelReason;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CancelReasonController extends Controller
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
            return datatables()->of(CancelReason::latest()->get())
            ->addColumn('action', function ($reason) {
                $button = '<button type="button" name="edit" id="' . $reason->id . '" class="edit btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-edit"></i></button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="' . $reason->id . '" class="delete btn btn-table waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('backend.reason.index');
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
            'name' => 'required|string|max:255|unique:cancel_reasons',
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

        $reason = new CancelReason;
        $reason->name = $request->name;

        // return $district;
        $reason->save();
        return response()->json(['success' => 'Cancel Reason is successfully added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reason = CancelReason::findOrFail(intval($id));
        return response()->json(['reason' => $reason]);
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
        $reason = CancelReason::where('id', $request->hidden_id)->firstOrFail();

        if($reason->name == $request->name){
            $validator = \Validator::make($request->all(), [
                'name' => 'required|string|max:255',
            ]);
        }else{
            $validator = \Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:cancel_reasons',
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

        
        $reason->name = $request->name;

        // return $district;
        $reason->save();
        return response()->json(['success' => 'Cancel Reason has been updated successfully']);
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
