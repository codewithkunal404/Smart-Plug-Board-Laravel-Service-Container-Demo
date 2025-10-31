<?php

namespace App\Providers;

use App\Services\Fan;
use App\Services\Light;
use App\Services\PowerInterface;
use App\Services\TV;
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
        $this->app->bind(PowerInterface::class,function($app){
            $device=request('device','fan');
            return match($device){
                "tv"=>new TV(),
                "light"=>new Light(),
                default=>new Fan()
            };
        });
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
