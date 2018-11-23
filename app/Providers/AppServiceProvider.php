<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        setlocale(LC_TIME, 'Indonesia');
        Carbon::setLocale('id');

        ini_set('max_execution_time', 10800);
        ini_set('post_max_size', '100M');
        ini_set('upload_max_filesize', '10M');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
