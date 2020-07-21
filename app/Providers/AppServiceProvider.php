<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
/* fbsg-signature-hotFixMySQL:<begin> Schema */
use Illuminate\Support\Facades\Schema;
/* fbsg-signature-hotFixMySQL:<end> Schema */

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
        /* fbsg-signature-hotFixMySQL:<begin> defaultString */
        Schema::defaultStringLength(191);
        /* fbsg-signature-hotFixMySQL:<end> defaultString */
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
