<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\StaffNotification;
use App\Models\MemberNotification;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        $gs = Setting::first();
        $viewShare['gs'] = $gs;
        view()->share($viewShare);
        view()->composer('webmaster.partials.topbar', function ($view) {
            $view->with([
                'notifications' => StaffNotification::where('status', 0)->orderBy('id','desc')->get()
            ]);
        });
        view()->composer('member.partials.topbar', function ($view) {
            $view->with([
                'membernotifications' => MemberNotification::take(3)->where('status', 0)->orderBy('id','desc')->get()
            ]);
        });

        Schema::defaultStringLength(191);
    } 
}
