<?php

namespace App\Http\Controllers;

use App\Enums\StatusShareEnum;
use App\Models\Share;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShareController extends Controller
{
    public function store(Request $request)
    {
        try {

            $user = User::where('email', $request->input('email'))->first();

            if (!$user) {
                return response()->json([
                    'error' => 'Invalid email'
                ]);
            }
            $share = Share::create([
                'device_id' => $request->input('id'),
                'user_id' =>$user->id,
                'status' => StatusShareEnum::NOT_CONFIRM,
            ]);
            return response()->json(['share' => $share], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in share.store'
            ]);
        }
    }

    public function getSharesByUser()
    {
        try {
            $id = Auth::user()->id;
            $shares = Share::with(['user','device'])->whereHas('device',function($query) use ($id){
                $query->where('user_id', $id);
            })->get();
            return response()->json($shares, 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong in share.getSharesByUser',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function getSharedList()
    {
        try {
            $shares = Share::with(['user','device.user'])->where('user_id',Auth::user()->id)->get();
            return response()->json($shares, 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong in share.getSharedList',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function getSharedComfirmList()
    {
        try {
            $shares = Share::with(['user','device.user'])->where('user_id',Auth::user()->id)->where('status',StatusShareEnum::IS_CONFIRM)->get();
            return response()->json($shares, 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong in share.getSharedList',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function changeStatus($id){
        try {
            $share = Share::where('id',$id)->where('user_id',Auth::user()->id)->first();
            $share->status = StatusShareEnum::IS_CONFIRM;
            $share->save();
            return response()->json(['status'=>true], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong in share.changeStatus',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    
    public function destroy(int $id)
    {
        try {

            Share::WhereHas('device',function($query) {
                $query->where('user_id',Auth::user()->id);
            })->orWhere('user_id',Auth::user()->id)->where('id',$id)->delete();

    
            return response()->json('Share deleted', 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in share.destroy',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
