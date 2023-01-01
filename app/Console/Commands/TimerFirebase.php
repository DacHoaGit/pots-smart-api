<?php

namespace App\Console\Commands;

use App\Models\timer;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Kreait\Firebase\Factory;
use Illuminate\Support\Str;

class TimerFirebase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'firebase:TimerFirebase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Timer update firebase';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $factory = (new Factory())->withDatabaseUri('https://pots-smart-default-rtdb.firebaseio.com');
        $database = $factory->createDatabase();
        $timers = timer::get();

        foreach ($timers as $each) {
            $date_current = Carbon::now()->format('Y-m-d');
            $time_current = Carbon::now()->format('H:i:s');
            $date = date('Y-m-d', strtotime($each->date));
            if($each->status == 1){
                if ($time_current >= $each->time_start && $time_current <= $each->time_end && $date_current == $date) {
                    $database->getReference('/'.$each->user->token_pots.'/status')->set([
                        "bom" => $each->bom,
                        "den" => $each->den,
                        "auto" => $each->auto,
                    ]);
                }
                if ($time_current >= $each->time_start && $time_current <= $each->time_end  && Str::contains($each->day_of_weeks, (Carbon::now()->dayOfWeek) + 1)) {
                    $database->getReference('/'.$each->user->token_pots.'/status')->set([
                        "bom" => $each->bom,
                        "den" => $each->den,
                        "auto" => $each->auto,
                    ]);
                    $each->check = 1;
                }
                if ($time_current >= $each->time_end && $each->check == 1  && Str::contains($each->day_of_weeks, (Carbon::now()->dayOfWeek) + 1)) {
                    $database->getReference('/'.$each->user->token_pots.'/status')->set([
                        "bom" => 0,
                        "den" => 0,
                        "auto" => 0,
                    ]);
                    $each->check = 0;
                }
            }
            if ($time_current >= $each->time_end && $date_current >= $date && $each->date ) {
                $database->getReference('/'.$each->user->token_pots.'/status')->set([
                    "bom" => 0,
                    "den" => 0,
                    "auto" => 0,
                ]);
                $each->delete();
                continue;
            }
        }
    }
    
}
