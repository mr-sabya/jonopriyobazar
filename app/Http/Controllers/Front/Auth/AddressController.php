<?php

namespace App\Http\Controllers\Front\Auth;

use Auth;
use App\Models\City;
use App\Models\Thana;
use App\Models\Address;
use App\Models\District;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $addresses = Address::where('user_id', Auth::user()->id)->get();
        return view('front.profile.pages.address.index', compact('addresses'));
    }

    public function create()
    {
        $districts = District::orderBy('name', 'ASC')->get();
        return view('front.profile.pages.address.create', compact('districts'));
    }

    public function showForm()
    {
        $districts = District::orderBy('name', 'ASC')->get();
        return view('front.address.create', compact('districts'));
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
            'phone' => 'required',
            'street' => 'required|max:255',
            'district_id' => 'required',
            'thana_id' => 'required',
            'city_id' => 'required',
            'post_code' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails())
        {
            $errors = array(
                'name'=>$validator->errors()->first('name'),
                'phone'=>$validator->errors()->first('phone'),
                'street'=>$validator->errors()->first('street'),
                'district_id'=>$validator->errors()->first('district_id'),
                'thana_id'=>$validator->errors()->first('thana_id'),
                'city_id'=>$validator->errors()->first('city_id'),
                'post_code'=>$validator->errors()->first('post_code'),
                'type'=>$validator->errors()->first('type'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }

        

        $address = new Address;

        $address->user_id = Auth::user()->id;
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->street = $request->street;
        $address->district_id = $request->district_id;
        $address->thana_id = $request->thana_id;
        $address->city_id = $request->city_id;
        $address->post_code = $request->post_code;
        $address->type = $request->type;

        $address->save();

        // return redirect()->route('user.address.index')->with('success', 'New address is added successfully');
        return response()->json(['route' => route('user.address.index')]);
    }

    public function addAddress(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required',
            'street' => 'required|max:255',
            'district_id' => 'required',
            'thana_id' => 'required',
            'city_id' => 'required',
            'post_code' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails())
        {
            $errors = array(
                'name'=>$validator->errors()->first('name'),
                'phone'=>$validator->errors()->first('phone'),
                'street'=>$validator->errors()->first('street'),
                'district_id'=>$validator->errors()->first('district_id'),
                'thana_id'=>$validator->errors()->first('thana_id'),
                'city_id'=>$validator->errors()->first('city_id'),
                'post_code'=>$validator->errors()->first('post_code'),
                'type'=>$validator->errors()->first('type'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }

        

        $address = new Address;

        $address->user_id = Auth::user()->id;
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->street = $request->street;
        $address->district_id = $request->district_id;
        $address->thana_id = $request->thana_id;
        $address->city_id = $request->city_id;
        $address->post_code = $request->post_code;
        $address->type = $request->type;
        $address->is_shipping = 1;
        $address->is_billing = 1;

        $address->save();

        // return redirect()->route('user.address.index')->with('success', 'New address is added successfully');
        return response()->json(['route' => route('checkout.index')]);
    }

    public function edit($id)
    {
        $address = Address::findOrFail(intval($id));
        $districts = District::orderBy('name', 'ASC')->get();
        return view('front.profile.pages.address.edit', compact('address', 'districts'));
    }

    public function update(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required',
            'street' => 'required|max:255',
            'district_id' => 'required',
            'thana_id' => 'required',
            'city_id' => 'required',
            'post_code' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails())
        {
            $errors = array(
                'name'=>$validator->errors()->first('name'),
                'phone'=>$validator->errors()->first('phone'),
                'street'=>$validator->errors()->first('street'),
                'district_id'=>$validator->errors()->first('district_id'),
                'thana_id'=>$validator->errors()->first('thana_id'),
                'city_id'=>$validator->errors()->first('city_id'),
                'post_code'=>$validator->errors()->first('post_code'),
                'type'=>$validator->errors()->first('type'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }

        

        $address = Address::where('id', $request->id)->firstOrFail();

        $address->user_id = Auth::user()->id;
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->street = $request->street;
        $address->district_id = $request->district_id;
        $address->thana_id = $request->thana_id;
        $address->city_id = $request->city_id;
        $address->post_code = $request->post_code;
        $address->type = $request->type;

        $address->save();

        // return redirect()->route('user.address.index')->with('success', 'New address is added successfully');
        return response()->json(['route' => route('user.address.index')]);
    }

    public function setBilling($id)
    {
        $address = Address::findOrFail(intval($id));
        $addresses = Address::where('user_id', Auth::user()->id)->get();

        if($address->is_billing == 1){
            return response()->json(['error' => 'You can not deactive your default address']);
        }else{
            foreach ($addresses as $data) {
                $data->is_billing = 0;
                $data->save();
            }

            $address->is_billing = 1;
            $address->save();

            return response()->json(['success' => 'Default billing addres is added']);
        }
    }

    public function setShipping($id)
    {
        $address = Address::findOrFail(intval($id));
        $addresses = Address::where('user_id', Auth::user()->id)->get();

        if($address->is_shipping == 1){
            return response()->json(['error' => 'You can not deactive your default address']);
        }else{
            foreach ($addresses as $data) {
                $data->is_shipping = 0;
                $data->save();
            }

            $address->is_shipping = 1;
            $address->save();
            return response()->json(['success' => 'Default shipping addres is added']);
        }
        

        
    }
}
