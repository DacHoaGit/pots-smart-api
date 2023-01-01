<?php

namespace App\Http\Controllers;

use App\Enums\StatusTimerEnum;
use App\Http\Requests\TimerRequest;
use App\Models\Timer;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class TimerController extends Controller
{

    public function getTimers(){
        try {
            $getTimers = Timer::orderByDesc('created_at')->get();
            return response()->json($getTimers, 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong in PostController.store',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function changeStatus($id){
        try {
            $user = Auth::user()->id;
            $getTimer = Timer::where('id',$id)->where('user_id',$user)->first();
            $getTimer->status = !$getTimer->status;
            $getTimer->save();
            return response()->json(['status'=>true], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong in PostController.store',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy(int $id){
        try {
            
            Timer::where('id',$id)->where('user_id',Auth::user()->id)->delete();
            
            return response()->json('Timer deleted', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in TimerController.destroy',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function store(TimerRequest $request){
        try {
            $day_of_week = "";
            $timer = new Timer();
            $timer->user_id = Auth::user()->id;

            $timer->status = StatusTimerEnum::BAT_HEN_GIO;
            
            $timer->den = ($request->get('den') == 'true' ) ? 1 : 0;
            $timer->bom = ($request->get('bom') == 'true' )? 1 : 0;
            $timer->auto = ($request->get('auto') == 'true') ? 1 : 0;

            $timer->time_start = $request->time_start;
            $timer->time_end = $request->time_end;

            if($request->date != 'null')
                $timer->date = $request->date;

            if($request->sunday == 'true'){
                $day_of_week .= "1";
            }
            if($request->monday == 'true'){
                $day_of_week .= "2";
            }
            if($request->tuesday == 'true'){
                $day_of_week .= "3";
            }
            if($request->wednesday == 'true'){
                $day_of_week .= "4";
            }
            if($request->thursday == 'true'){
                $day_of_week .= "5";
            }
            if($request->friday == 'true'){
                $day_of_week .= "6";
            }
            if($request->saturday == 'true'){
                $day_of_week .= "7";
            }

            $timer->day_of_weeks = $day_of_week;

            $timer->check = false;
            $timer->save();

            return response()->json('New suggestion created', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in PostController.store',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
