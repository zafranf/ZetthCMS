<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        Schema::defaultStringLength(191);

        /* send application data to all views */
        if (Schema::hasTable('applications')) {
            $app = \App\Models\Application::find(1);
            View::share('app', $app);
        }

        /* send menu data to all views */
        $menu = \App\Models\Menu::where([
                    'parent_id' => 0, 
                    'status' => 1
                ])->with('submenu')->orderBy('order')->get();
        View::share('appmenu', $menu);
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
