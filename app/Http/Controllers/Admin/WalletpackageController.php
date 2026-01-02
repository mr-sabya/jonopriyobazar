<?php

namespace App\Http\Controllers\Admin;

use App\Models\Walletpackage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletpackageController extends Controller
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
            return datatables()->of(Walletpackage::latest()->get())
            ->addColumn('action', function ($package) {
                $button = '<button type="button" name="edit" id="' . $package->id . '" class="edit btn btn-primary btn-sm">Edit</button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="' . $package->id . '" class="delete btn btn-danger btn-sm">Delete</button>';
                return $button;
            })
            ->rawColumns(['action',])
            ->addIndexColumn()
            ->make(true);
        }
        return view('backend.walletpackage.index');
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
            'amount' => 'required',
            'validate' => 'required',
        ]);

        if ($validator->fails())
        {
            $errors = array(
                'amount'=>$validator->errors()->first('amount'),
                'validate'=>$validator->errors()->first('validate'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }

        $package = new Walletpackage;
        $package->amount = $request->amount;
        $package->validate = $request->validate;
        $package->save();

        return response()->json(['success' => 'New Package is added successfully']);
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
        $package = Walletpackage::findOrFail(intval($id));
        return response()->json(['package' => $package]);
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
        $package = Walletpackage::where('id', $request->hidden_id)->firstOrFail();

        $validator = \Validator::make($request->all(), [
            'amount' => 'required',
            'validate' => 'required',
        ]);

        if ($validator->fails())
        {
            $errors = array(
                'amount'=>$validator->errors()->first('amount'),
                'validate'=>$validator->errors()->first('validate'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }

        $package->amount = $request->amount;
        $package->validate = $request->validate;
        $package->save();

        return response()->json(['success' => 'Package has been updated successfully']);
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
