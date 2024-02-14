<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserBackendController extends Controller
{
    //
    public function index()
    {
        return view("backend.user.profile");
    }
    public function info()
    {
        try {
            $user = User::where("id", Auth::user()->id)->first();
            return response()->json($user);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage());
        }
    }

    public function passwordUpdate(PasswordUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $user = User::where("id", Auth::user()->id)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                $user->password = Hash::make($request->password);
                $user->save();
            }

            DB::commit();
            return response()->json([
                'status' => false,
                'message' => 'Password successfully updated',
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
