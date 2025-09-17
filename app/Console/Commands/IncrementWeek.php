<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class IncrementWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:increment-week';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
      //
      $cur = config('app.current_week');
      $cur++;
      Setting::updateOrCreate(
        ['key' => 'current_week'],
        ['value' => $cur]
      );

      Cache::forget('settings.current_week');

      $message = "Week is now set to " . $cur;
      $this->info($message);
      Log::info($message);      
    }
}
