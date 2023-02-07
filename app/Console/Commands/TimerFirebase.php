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
                    $database->getReference('/'.$each->device->device.'/sensor')->update([
                        "bom" => $each->bom ? 1 : 2,
                        "den" => $each->den ? 1 : 2,
                        "auto" => $each->auto ? 1 : 2,
                    ]);
                }
                if ($time_current >= $each->time_start && $time_current <= $each->time_end  && Str::contains($each->day_of_weeks, (Carbon::now()->dayOfWeek) + 1)) {
                    $database->getReference('/'.$each->device->device.'/sensor')->update([
                        "bom" => $each->bom ? 1 : 2,
                        "den" => $each->den ? 1 : 2,
                        "auto" => $each->auto ? 1 : 2,
                    ]);
                    $each->check = 1;
                }
                if ($time_current >= $each->time_end && $each->check == 1  && Str::contains($each->day_of_weeks, (Carbon::now()->dayOfWeek) + 1)) {
                    $database->getReference('/'.$each->device->device.'/sensor')->update([
                        "bom" => 0 ? 1 : 2,
                        "den" => 0 ? 1 : 2,
                        "auto" => 0 ? 1 : 2,
                    ]);
                    $each->check = 0;
                }
            }
            if ($time_current >= $each->time_end && $date_current >= $date && $each->date ) {
                $database->getReference('/'.$each->device->device.'/sensor')->update([
                    "bom" => 2,
                    "den" => 2,
                    "auto" => 2,
                ]);
                $each->delete();
                continue;
            }
        }
    }
}
