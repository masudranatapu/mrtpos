<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BackendRequest\CustomerRequest;
use App\Http\Resources\BackendResource\CustomerResource;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\InitialDue;
use Illuminate\Support\Facades\Auth;

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
            $customer = Customer::query()
                ->where('business_id', Auth::user()->business_id)
                ->with([
                    'customerInitialDue' => fn ($q) => $q->select('id', 'business_id', 'customer_id', 'amount')->get(),
                ])
                ->when($request->status, fn ($q) => $q->where('status', $request->status))
                ->orderBy('sorting_number', $request->sort_order)
                ->paginate($request->per_page ?? 10);
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
            $customer->business_id = Auth::user()->business_id;
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->gender = $request->gender;
            $customer->member_ship_id = $request->member_ship_id;
            $customer->date_of_birth = $request->date_of_birth;
            $customer->customer_group_id = $request->customer_group_id;
            $customer->date = $request->date ? $request->date : date('Y-m-d');
            $customer->area_id = $request->area_id;
            $customer->zip_code = $request->zip_code;
            $customer->address = $request->address;
            $customer->note = $request->note;
            $customer->sorting_number = $request->sorting_number ? $request->sorting_number : 1;
            $customer->status = 'Active';

            if ($request->hasFile("image")) {
                $image_url = imageUploader($request->file('image'), 'customer', $customer->image);
                $customer->image = $image_url;
            }

            $customer->save();

            if ($request->due && $request->due > 0) {
                $due = new InitialDue();
                $due->business_id = 1;
                $due->customer_id = $customer->id;
                $due->date = $request->date ? $request->date : date('Y-m-d');
                $due->amount = $request->due;
                $due->save();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'User successfully Created',
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }


    public function edit($id)
    {
        try {
            $customer = Customer::query()
                // ->where()
                ->findOrFail($id);
            return new CustomerResource($customer);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function update(CustomerRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $customer = Customer::query()
                ->where('business_id', Auth::user()->business_id)
                ->findOrFail($id);
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->gender = $request->gender;
            $customer->member_ship_id = $request->member_ship_id;
            $customer->date_of_birth = $request->date_of_birth;
            $customer->customer_group_id = $request->customer_group_id;
            $customer->date = $request->date ? $request->date : date('Y-m-d');
            $customer->area_id = $request->area_id;
            $customer->zip_code = $request->zip_code;
            $customer->address = $request->address;
            $customer->note = $request->note;
            $customer->sorting_number = $request->sorting_number ? $request->sorting_number : 1;
            $customer->status = 'Active';

            if ($request->hasFile("image")) {
                $image_url = imageUploader($request->file('image'), 'customer', $customer->image);
                $customer->image = $image_url;
            }

            $customer->save();

            if ($request->due && $request->due > 0) {
                $due = InitialDue::query()
                    ->where('business_id', Auth::user()->business_id)
                    ->where('customer_id', $customer->id)
                    ->first();
                $due->business_id = 1;
                $due->date = $request->date ? $request->date : date('Y-m-d');
                $due->amount = $request->due;
                $due->save();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Customer successfully updated',
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function view($id)
    {
        try {
            $customer = Customer::query()
                ->where('business_id', Auth::user()->business_id)
                ->findOrFail($id);
            return new CustomerResource($customer);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function changeStatus($id)
    {
        try {
            DB::beginTransaction();
            $request = request();
            $customer = Customer::query()
                ->where('business_id', Auth::user()->business_id)
                ->findOrFail($id);
            $customer->status = $request->status;
            $customer->save();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => "Customer $customer->status Successfully Done",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            DB::beginTransaction();
            $ids = explode(',', $request->ids);
            foreach ($ids as $id) {
                $deleteData = $this->destroy($id);
                if ($deleteData != true) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => 'Customer Some Issue. You Can not continue This Action',
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => "Customer Successfully Deleted",
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }


    public function destroy($id)
    {
        $customer = Customer::query()
            ->where('business_id', Auth::user()->business_id)
            ->findOrFail($id);

        if ($customer->image) {
            fileUnlink($customer->image);
        }

        $customer->delete();
        return true;
    }
}
