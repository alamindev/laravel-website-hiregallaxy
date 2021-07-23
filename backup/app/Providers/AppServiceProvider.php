<?php

namespace App\Providers;

use DB;
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

        // If (env('APP_ENV') !== 'local') {

        //     \URL::forceScheme('https');

        //     $this->app['request']->server->set('HTTPS', true);

        // }

        if ($this->app->environment() === 'production') {

            \URL::forceScheme('https');

            $this->app['request']->server->set('HTTPS', true);

        } else {

            \URL::forceScheme('http');

            $this->app['request']->server->set('HTTPS', false);

        }

    }

    /**

     * Bootstrap any application services.

     *

     * @return void

     */

    public function boot()
    {

        View::composer(['backend.partials.navbar-main', 'backend.pages.index'], function ($view) {

            $editor_access = DB::table('editor_access')->where('user_id', auth()->user()->id)->select('access')->first();

            if ($editor_access) {

                $view->with('editor_access', json_decode($editor_access->access));

            } else {

                $view->with('editor_access', []);

            }

        });

    }

}
