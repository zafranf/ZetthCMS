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
        $isCLI = strpos(php_sapi_name(), 'cli') !== false;
        if (!$isCLI) {
            if (!Schema::hasTable('applications')) {
                /* sementara, nanti redirect ke halaman install */
                dd('You need to install this app first');
                // redirect('http://google.com')->send();
            }

            /* check admin page */
            $isAdminPath = (env('ADMIN_ROUTE', 'path') == 'path');
            View::share('isAdminPath', $isAdminPath);

            $isAdminSubdomain = !$isAdminPath;
            View::share('isAdminSubdomain', $isAdminSubdomain);
        }

        /* send application data to all views */
        if (Schema::hasTable('applications')) {
            $apps = \App\Models\Application::find(1);
            View::share('apps', $apps);
        }

        /* send menu data to all views */
        /* if (Schema::hasTable('menus')) {
    $appmenu = \App\Models\Menu::where([
    'parent_id' => 0,
    'status' => 1,
    ])->with('submenu')->orderBy('order')->get();
    View::share('appmenu', $appmenu);
    } */
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
