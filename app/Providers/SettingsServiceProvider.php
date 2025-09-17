<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('settings')) {
            // Get the current week setting
            $currentWeek = Cache::rememberForever('settings.current_week', function () {
                return Setting::find('current_week')?->value;
            });

            // Make the setting available globally in the config
            if ($currentWeek) {
                config(['app.current_week' => $currentWeek]);
            }

            $currentLeader = Cache::rememberForever('settings.current_leader', function(){
              return Setting::find('current_leader')?->value;
            });

            if ($currentLeader){
              config(['app.current_week' => $currentLeader]);
            }

        }
    }
}
