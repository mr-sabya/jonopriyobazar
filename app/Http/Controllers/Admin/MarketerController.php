<?php

namespace App\Http\Controllers\Admin;

use App\Models\MarketerWithdraw;
use App\Models\MarketerPercentage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketerController extends Controller
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

	public function index()
	{
		$percentage = MarketerPercentage::all();
		$withdraw = MarketerWithdraw::all();
		return view('backend.percentage.marketer.index', compact('percentage', 'withdraw'));
	}

	public function fetchPercentage()
	{
		if (request()->ajax()) {
			return datatables()->of(MarketerPercentage::with('order')->latest()->get())
			->addColumn('order_date', function ($percentage) {
				$date = date('d-m-Y', strtotime($percentage->date));
				return $date;
			})
			->addColumn('order_invoice', function ($percentage) {
				$order = '<a href="#">#'.$percentage->order['invoice'].'</a>';
				return $order;
			})
			->rawColumns(['order_invoice','order_date', 'action'])
			->addIndexColumn()
			->make(true);
		}
	}

	public function fetchWithdraw()
	{
		//if (request()->ajax()) {
			return datatables()->of(MarketerWithdraw::latest()->get())
			->addColumn('withdraw_date', function ($withdraw) {
				$date = date('d-m-Y', strtotime($withdraw->date));
				return $date;
			})
			->addColumn('action', function ($withdraw) {

				$button = '<button type="button" name="delete" id="' . $withdraw->id . '" class="delete btn btn-table waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></button>';
				return $button;
			})
			->rawColumns(['withdraw_date', 'action'])
			->addIndexColumn()
			->make(true);
		//}
	}

	public function store(Request $request)
	{
		$validator = \Validator::make($request->all(), [
            'date' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->fails())
        {
            $errors = array(
                'date'=>$validator->errors()->first('date'),
                'amount'=>$validator->errors()->first('amount'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }

        $withdraw = new MarketerWithdraw;
        $withdraw->date = $request->date;
        $withdraw->amount = $request->amount;
        $withdraw->method = $request->method;
        $withdraw->save();

        $percentage = number_format((float)MarketerPercentage::sum('amount'), 2, '.', '');
		$withdraw = number_format((float)MarketerWithdraw::sum('amount'), 2, '.', '');
		$balance = number_format((float)$percentage - $withdraw, 2, '.', '');

        return response()->json([
        	'success' => 'Withdraw has been completed',
        	'percentage' => $percentage,
        	'withdraw' => $withdraw,
        	'balance' => $balance,
        ]);
	}

	public function destroy($id)
	{
		$withdraw = MarketerWithdraw::findOrFail(intval($id));
		$withdraw->delete();

		$percentage = number_format((float)MarketerPercentage::sum('amount'), 2, '.', '');
		$withdraw = number_format((float)MarketerWithdraw::sum('amount'), 2, '.', '');
		$balance = number_format((float)$percentage - $withdraw, 2, '.', '');

		return response()->json([
			'success' => 'Withdraw has been deleted! Developer Income has been refunded',
			'percentage' => $percentage,
        	'withdraw' => $withdraw,
        	'balance' => $balance,
		]);
	}
}
