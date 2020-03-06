<?php

namespace App\Providers;

use App\Models\Airport;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer(['index', 'flights'], function ($view) {
            $airports = Airport::orderBy('location')->get();

            $view->with(compact('airports'));
        });
    }
}
