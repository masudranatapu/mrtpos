<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\BackendRequest\SupplierRequest;
use App\Http\Resources\Backend\SupplierResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Supplier;
use App\Models\InitialDue;

class SupplierController extends Controller
{
    //
    public function index()
    {
        return view('backend.supplier.index');
    }

    public function supplierList(Request $request)
    {
        try {
            $sppliers = Supplier::query()
                // ->where()
                ->with([
                    'supplierInitialDue' => fn ($q) => $q->select('id', 'business_id', 'supplier_id', 'amount')->get(),
                ])
                ->when($request->status, fn ($q) => $q->where('status', $request->status))
                ->get();
            return SupplierResource::collection($sppliers);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
    public function store(SupplierRequest $request)
    {
        try {
            DB::beginTransaction();
            $supplier = new Supplier();
            $supplier->business_id = 1;
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->supplier_business_name = $request->supplier_business_name;
            $supplier->phone = $request->phone;
            $supplier->gender = $request->gender;
            $supplier->date_of_birth = $request->date_of_birth;
            $supplier->date = $request->date ? $request->date : date('Y-m-d');
            $supplier->area_id = $request->area_id;
            $supplier->zip_code = $request->zip_code;
            $supplier->address = $request->address;
            $supplier->note = $request->note;
            $supplier->status = 'Active';

            if ($request->hasFile("image")) {
                $image_url = imageUploader($request->file('image'), 'supplier', $supplier->image);
                $supplier->image = $image_url;
            }

            $supplier->save();

            if ($request->due && $request->due > 0) {
                $due = new InitialDue();
                $due->business_id = 1;
                $due->supplier_id = $supplier->id;
                $due->date = $request->date ? $request->date : date('Y-m-d');
                $due->amount = $request->due;
                $due->save();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Supplier successfully Created',
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
            $sppliers = Supplier::query()
                // ->where()
                ->findOrFail($id);
            return new SupplierResource($sppliers);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
    public function update(SupplierRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $supplier = Supplier::query()
                // ->where()
                ->findOrFail($id);
            $supplier->business_id = 1;
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->supplier_business_name = $request->supplier_business_name;
            $supplier->phone = $request->phone;
            $supplier->gender = $request->gender;
            $supplier->date_of_birth = $request->date_of_birth;
            $supplier->date = $request->date ? $request->date : date('Y-m-d');
            $supplier->area_id = $request->area_id;
            $supplier->zip_code = $request->zip_code;
            $supplier->address = $request->address;
            $supplier->note = $request->note;

            if ($request->hasFile("image")) {
                $image_url = imageUploader($request->file('image'), 'supplier', $supplier->image);
                $supplier->image = $image_url;
            }

            $supplier->save();

            if ($request->due && $request->due > 0) {
                $due = InitialDue::query()
                    // ->where()
                    ->where('supplier_id', $supplier->id)
                    ->first();
                $due->business_id = 1;
                $due->supplier_id = $supplier->id;
                $due->date = $request->date ? $request->date : date('Y-m-d');
                $due->amount = $request->due;
                $due->save();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Supplier successfully Updated',
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
            $supplier = Supplier::query()
                // ->where()
                ->findOrFail($id);
            return new SupplierResource($supplier);
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
            $supplier = Supplier::query()
                // ->where()
                ->findOrFail($id);
            $supplier->status = $request->status;
            $supplier->save();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => "Supplier $supplier->status Successfully Done",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $supplier = Supplier::query()
                // ->where()
                // ->withCount()
                ->findOrFail($id);

            if ($supplier->image) {
                fileUnlink($supplier->image);
            }

            $supplier->delete();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => "Supplier Successfully Deleted",
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
