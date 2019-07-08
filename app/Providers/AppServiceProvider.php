<?php

namespace App\Providers;

use App\Channel;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
        Carbon::setLocale('zh');

        //视图共享数据
//        \View::share('channels',\App\Channel::all());

        //视图合成器
        \View::composer('*', function ($view) {
            $view->with("channels", Channel::query());
        });
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
