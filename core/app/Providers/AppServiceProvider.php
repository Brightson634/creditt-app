<?php

namespace App\Providers;

use \Carbon\Carbon;
use App\Models\Setting;
use App\Models\StaffNotification;
use App\Models\MemberNotification;
use App\Services\CoaService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Modules\Accounting\Services\ActivityService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ActivityService::class, function ($app) {
            return new ActivityService();
        });
        $this->app->singleton(CoaService::class, function ($app) {
            return new CoaService();
        });
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
        //Blade directive to format number into required format.
        // Blade::directive('num_format', function ($expression) {
        // return "number_format($expression, session('business.currency_precision', 2),
        // session('currency')['decimal_separator'], session('currency')['thousand_separator'])";
        // });

        //Blade directive to format quantity values into required format.
        // Blade::directive('format_quantity', function ($expression) {
        // return "number_format($expression, session('business.quantity_precision', 2),
        // session('currency')['decimal_separator'], session('currency')['thousand_separator'])";
        // });

        //Blade directive to return appropiate class according to transaction status
        Blade::directive('transaction_status', function ($status) {
        return "<?php if($status == 'ordered'){
                echo 'bg-aqua';
            }elseif($status == 'pending'){
                echo 'bg-red';
            }elseif ($status == 'received') {
                echo 'bg-light-green';
            }?>";
        });

        //Blade directive to return appropiate class according to transaction status
        Blade::directive('payment_status', function ($status) {
        return "<?php if($status == 'partial'){
                echo 'bg-aqua';
            }elseif($status == 'due'){
                echo 'bg-yellow';
            }elseif ($status == 'paid') {
                echo 'bg-light-green';
            }elseif ($status == 'overdue') {
                echo 'bg-red';
            }elseif ($status == 'partial-overdue') {
                echo 'bg-red';
            }?>";
        });

        //Blade directive to display help text.


        //Blade directive to convert.
        //Blade directive to convert.
        // Blade::directive('format_date', function ($date) {
        // if (! empty($date)) {
        // return "\\Carbon\\Carbon::createFromTimestamp(strtotime($date))->format(session('business.date_format'))";
        // } else {
        // return null;
        // }
        // });

        //Blade directive to convert.
        Blade::directive('format_time', function ($date) {
        if (! empty($date)) {
        $time_format = 'h:i A';
        if (session('business.time_format') == 24) {
        $time_format = 'H:i';
        }

        return "\Carbon::createFromTimestamp(strtotime($date))->format('$time_format')";
        } else {
        return null;
        }
        });

        Blade::directive('format_datetime', function ($date) {
        if (! empty($date)) {
        $time_format = 'h:i A';
        if (session('business.time_format') == 24) {
        $time_format = 'H:i';
        }

        return "\Carbon\carbon::createFromTimestamp(strtotime($date))->format(session('business.date_format') . ' ' .
        '$time_format')";
        } else {
        return null;
        }
        });

        //Blade directive to format currency.
        Blade::directive('format_currency', function ($number) {
        return '<?php
            $formated_number = "";
            if (session("business.currency_symbol_placement") == "before") {
                $formated_number .= session("currency")["symbol"] . " ";
            }
            $formated_number .= number_format((float) '.$number.', session("business.currency_precision", 2) , session("currency")["decimal_separator"], session("currency")["thousand_separator"]);

            if (session("business.currency_symbol_placement") == "after") {
                $formated_number .= " " . session("currency")["symbol"];
            }
            echo $formated_number; ?>';
        });


        Blade::directive('format_currency_with_symbol',function($number , $symbol = "KSh"){


        return '<?php
            $formated_number = "";
            if (session("business.currency_symbol_placement") == "before") {
                $formated_number .= "'.$symbol.'" ;
            }
            $formated_number .= number_format((float) '.$number.', session("business.currency_precision", 2) , session("currency")["decimal_separator"], session("currency")["thousand_separator"]);

            if (session("business.currency_symbol_placement") == "after") {
                $formated_number .= "'.$symbol.'";
            }
            echo $formated_number; ?>';
        });
    }
}
