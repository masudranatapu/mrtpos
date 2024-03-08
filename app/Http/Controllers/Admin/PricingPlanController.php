<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest\PricingPlanRequest;
use App\Http\Resources\Admin\PricingPlanResource;
use App\Models\PricingPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PricingPlanController extends Controller
{
    //
    public function index()
    {
        return view("admin.pricing_plan.index");
    }

    public function pricingPlanList(Request $request)
    {
        try {
            $pricingPlans = PricingPlan::query()
                ->when($request->type, fn ($q) => $q->where('discount_type', $request->type))
                ->when($request->admin_id, fn ($q) => $q->where('admin_id', $request->admin_id))
                ->latest()
                ->get();
            return PricingPlanResource::collection($pricingPlans);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function store(PricingPlanRequest $request)
    {
        try {
            DB::beginTransaction();
            $pricingPlan = new PricingPlan();
            $pricingPlan->month = $request->month;
            $pricingPlan->discount_type = $request->discount_type;
            $pricingPlan->discount_value = $request->discount_value;
            $pricingPlan->admin_id = Auth::user()->id;
            $pricingPlan->save();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => "Pricing Plan successfully Created",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
    public function edit($id)
    {
        try {
            $pricingPlan = PricingPlan::query()
                ->findOrFail($id);
            return new PricingPlanResource($pricingPlan);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
    public function update(PricingPlanRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $pricingPlan = PricingPlan::query()
                ->findOrFail($id);
            $pricingPlan->month = $request->month;
            $pricingPlan->discount_type = $request->discount_type;
            $pricingPlan->discount_value = $request->discount_value;
            $pricingPlan->admin_id = Auth::user()->id;
            $pricingPlan->save();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => "Pricing Plan successfully Updated",
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
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
            $pricingPlan = PricingPlan::query()
                ->findOrFail($id);
            $pricingPlan->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => "Pricing Plan successfully Deleted",
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
