<?php

namespace App\Http\Controllers;
use Kreait\Firebase\Factory;
use App\Models\timer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\FirebaseService;
use Illuminate\Support\Str;
use Kreait\Laravel\Firebase\Facades\Firebase;

class TestController extends Controller
{
    //
    public function test(){
        

        // dd(Carbon::now()->dayOfWeek);
        $timers = timer::where('status',1)->get();
        foreach($timers as $each){
            $id = $each->user->id;
            $date_current = Carbon::now()->format('Y-m-d');
            $time_current = Carbon::now()->format('H:i:s');
            $date = date('Y-m-d',strtotime($each->date));
            dd($each->check = 1);
            dd(Str::contains("1", (Carbon::now()->dayOfWeek)+1));
            dd($each->user->id);
        }
    }
}
