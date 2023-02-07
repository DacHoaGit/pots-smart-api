<?php

namespace App\Http\Controllers;

use App\Enums\RoleUserEnum;
use App\Models\Video;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    //
    public function store(Request $request)
    {
        try {
            if(Auth::user()->role == RoleUserEnum::NOT_ADMIN){
                throw new Exception('Có lỗi xảy ra');
            }
            $video = Video::create([
                'title' => $request->input('title'),
                'link' => $request->input('link'),
            ]);
            return response()->json(['user' => $video], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in video.store'
            ]);
        }
    }

    public function getVideos()
    {
        try {
            if(Auth::user()->role == RoleUserEnum::NOT_ADMIN){
                throw new Exception('Có lỗi xảy ra');
            }
            $videos = Video::orderByDesc('created_at')->get();
            return response()->json($videos, 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong in device.get',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function edit($id,Request $request)
    {
        try {
            if(Auth::user()->role == RoleUserEnum::NOT_ADMIN){
                throw new Exception('Có lỗi xảy ra');
            }
            $video = Video::where('id',$id)->first();
            $video->title = $request->input('title');
            $video->link = $request->input('link');
            $video->save();
            return response()->json(['status'=>true], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong in video.edit',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            if(Auth::user()->role == RoleUserEnum::NOT_ADMIN){
                throw new Exception('Có lỗi xảy ra');
            }
            $video = Video::where('id', $id)->first();
            $video->delete();
            return response()->json('video deleted', 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in video.destroy',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
