<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cupon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CuponController extends Controller
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
            return datatables()->of(Cupon::latest()->get())

            ->addColumn('expire_on', function ($cupon) {
                $data = date('d-m-Y', strtotime($cupon->expire_date));
                return $data;
            })
            ->addColumn('action', function ($cupon) {
                $button = '<button type="button" name="edit" id="' . $cupon->id . '" class="edit btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-edit"></i></button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="' . $cupon->id . '" class="delete btn btn-table waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></button>';
                return $button;
            })
            ->rawColumns(['expire_on', 'action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('backend.cupon.index');
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
            'code' => 'required|max:255|unique:cupons',
            'expire_date' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->fails())
        {
            $errors = array(
                'code'=>$validator->errors()->first('code'),
                'expire_date'=>$validator->errors()->first('expire_date'),
                'amount'=>$validator->errors()->first('amount'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }

        $cupon = new Cupon;
        $cupon->code = $request->code;
        $cupon->amount = $request->amount;
        $cupon->limit = $request->limit;
        $cupon->expire_date = $request->expire_date;
        $cupon->save();

        return response()->json(['success' => 'New cupon is added successfully']);
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
        $cupon = Cupon::findOrFail(intval($id));
        return response()->json(['cupon' => $cupon]);
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
        $cupon = Cupon::where('id', $request->hidden_id)->firstOrFail();

        if($cupon->code == $request->code){
            $validator = \Validator::make($request->all(), [
                'code' => 'required|max:255',
                'expire_date' => 'required',
                'amount' => 'required',
            ]);
        }else{
            $validator = \Validator::make($request->all(), [
                'code' => 'required|max:255|unique:cupons',
                'expire_date' => 'required',
                'amount' => 'required',
            ]);
        }
        

        if ($validator->fails())
        {
            $errors = array(
                'code'=>$validator->errors()->first('code'),
                'expire_date'=>$validator->errors()->first('expire_date'),
                'amount'=>$validator->errors()->first('amount'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }

        $cupon->code = $request->code;
        $cupon->amount = $request->amount;
        $cupon->limit = $request->limit;
        $cupon->expire_date = $request->expire_date;
        $cupon->save();

        return response()->json(['success' => 'Cupon has been updated successfully']);
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
