<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

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

        if (App::environment('production')) {
            Config::set('app.debug', false);
        }

        Validator::extend('filter', function ($attribute, $value) {
            if ($value == 'god') {
                return false;
            }
            return true;
        }, 'Invalid word');

        Paginator::useBootstrap();
        JsonResource::withoutWrapping();

        View::composer('*', function ($view) {
            $settings = Schema::hasTable('site_settings')
                ? SiteSetting::current()
                : new SiteSetting(SiteSetting::defaults());

            $view->with('siteSettings', $settings);
        });
    }
}
