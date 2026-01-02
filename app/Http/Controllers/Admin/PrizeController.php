<?php

namespace App\Http\Controllers\Admin;

use App\Models\Prize;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrizeController extends Controller
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
        if(request()->ajax()) {
            return datatables()->of(Prize::latest()->get())
            ->addColumn('prize_image', function ($prize) {
                return '<img src="/upload/images/'.$prize->prize.'">';
            })
            ->addColumn('action', function ($prize) {
                $button = '<a href="'.route('admin.prize.edit', $prize->id).'" class="btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-edit"></i></a>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="' . $prize->id . '" class="delete btn btn-table waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></button>';
                return $button;
            })
            ->rawColumns(['prize_image', 'action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('backend.prize.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.prize.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'point' => 'required|integer',
            'prize' => 'required|image|mimes:jpeg,jpg,gif,png|max:2048',
        ]);


        $prize = new Prize;
        $prize->title = $request->title;
        $prize->point = $request->point;
        if ($request->hasFile('prize')) {
            $file = $request->file('prize');
            $extension = $file->getClientOriginalName();
            $filename = time().'-prize-'.$extension;
            $file->move('upload/images/', $filename);
            $prize->prize = $filename;
        }

        $prize->save();

        return redirect()->route('admin.prize.index')->with('success', 'New prize is added successfully');
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
        $prize = Prize::findOrFail(intval($id));
        return view('backend.prize.edit', compact('prize'));
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
        $request->validate([
            'title' => 'required|string|max:255',
            'point' => 'required|integer',
            'prize' => 'nullable|image|mimes:jpeg,jpg,gif,png|max:2048',
        ]);


        $prize = Prize::findOrFail(intval($id));
        $prize->title = $request->title;
        $prize->point = $request->point;
        if ($request->hasFile('prize')) {
            $file = $request->file('prize');
            $extension = $file->getClientOriginalName();
            $filename = time().'-prize-'.$extension;
            $file->move('upload/images/', $filename);
            $prize->prize = $filename;
        }

        $prize->save();

        return redirect()->route('admin.prize.index')->with('success', 'Prize has benn updated successfully');
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
