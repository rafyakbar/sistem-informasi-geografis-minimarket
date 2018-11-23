<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

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
