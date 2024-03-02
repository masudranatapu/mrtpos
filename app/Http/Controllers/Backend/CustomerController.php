<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BackendRequest\CustomerRequest;
use App\Http\Resources\Backend\CustomerResource;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;

class CustomerController extends Controller
{
    //
    public function index()
    {
        return view('backend.customer.index');    
    }

    public function customerList(Request $request)
    {
        try {
            $customer = Customer::get();
            return CustomerResource::collection($customer);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
    
    public function store(CustomerRequest $request)
    {
        try {
            DB::beginTransaction();
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->gender = $request->gender;
            $customer->member_ship_id = $request->member_ship_id;
            $customer->date_of_birth = $request->date_of_birth;
            $customer->due = $request->due;
            $customer->customer_group_id = $request->customer_group_id;
            $customer->date = $request->date ? $request->date : date('Y-m-d');
            $customer->area = $request->area;
            $customer->country = $request->country;
            $customer->zip_code = $request->zip_code;
            $customer->address = $request->address;
            $customer->note = $request->note;
            $customer->status = 'Active';

            if($request->hasFile("image")) {
                $image_url = imageUploader($request->file('image'), 'customer', $customer->image);
                $customer->image = $image_url;
            }

            $customer->save();

            DB::commit();
            
            return response()->json([
                'status' => true,
                'message' => 'User successfully updated',
            ]);

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }    
    }
}
