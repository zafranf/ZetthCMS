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
        /* set default varchar */
        Schema::defaultStringLength(191);

        /* check config */
        if (strpos(php_sapi_name(), 'cli') !== false) {
            if (!Schema::hasTable('applications')) {
                /* sementara, nanti redirect ke halaman install */
                dd('you need to install this app first');
                // redirect('http://google.com')->send();
            }
        }

        /* send application data to all views */
        if (Schema::hasTable('applications')) {
            $app = \App\Models\Application::find(1);
            View::share('apps', $app);
        }

        /* send menu data to all views */
        if (Schema::hasTable('menus')) {
            $menu = \App\Models\Menu::where([
                'parent_id' => 0,
                'status' => 1,
            ])->with('submenu')->orderBy('order')->get();
            View::share('appmenu', $menu);
        }
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
