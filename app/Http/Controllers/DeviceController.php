<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Kreait\Firebase\Factory;


class DeviceController extends Controller
{
    //

    public function getDevices()
    {
        try {
            $devices = Device::orderByDesc('created_at')->get();
            return response()->json($devices, 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong in device.get',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function getDevicesByUser()
    {
        try {
            $id = Auth::user()->id;
            $devices = Device::where('user_id', $id)->get();
            return response()->json($devices, 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong in device.getDevicesByUser',
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function store(Request $request)
    {
        try {
            $token = Str::random(10);
            $device = Device::create([
                'name' => $request->input('name'),
                'user_id' => Auth::user()->id,
                'device' => $token
            ]);

            $factory = (new Factory())->withDatabaseUri('https://pots-smart-default-rtdb.firebaseio.com');
            $database = $factory->createDatabase();
            $database->getReference('/' . $token . '/sensor')->set([
                "bom" => 0,
                "den" => 0,
                "auto" => 0,
                "doamdat" => 0,
                "doamkhongkhi" => 0,
                "nhietdo" => 0,
                "status_bom" => 0,
                "status_den" => 0,
                "status_auto" => 0,
                "nhiet_do_den_min" => 0,
                "nhiet_do_den_max" => 0,
                "nhiet_do_bom_min" => 0,
                "nhiet_do_bom_max" => 0,
                "do_am_dat_den_min" => 0,
                "do_am_dat_den_max" => 0,
                "do_am_dat_bom_min" => 0,
                "do_am_dat_bom_max" => 0,
                "do_am_khong_khi_den_min" => 0,
                "do_am_khong_khi_den_max" => 0,
                "do_am_khong_khi_bom_min" => 0,
                "do_am_khong_khi_bom_max" => 0,
            ]);
            return response()->json(['user' => $device], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in device.store'
            ]);
        }
    }



    public function destroy(int $id)
    {
        try {
            $token = Device::where('id', $id)->first();
            Device::where('id', $id)->where('user_id', Auth::user()->id)->delete();
            $factory = (new Factory())->withDatabaseUri('https://pots-smart-default-rtdb.firebaseio.com');
            $database = $factory->createDatabase();
            $database->getReference('/' . $token->device)->remove();
            return response()->json('Timer deleted', 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in device.destroy',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function edit($id,Request $request)
    {
        try {
            $user = Auth::user()->id;
            $device = Device::where('id',$id)->where('user_id',$user)->first();
            $device->name = $request->input('name');
            $device->save();
            return response()->json(['status'=>true], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong in device.edit',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
