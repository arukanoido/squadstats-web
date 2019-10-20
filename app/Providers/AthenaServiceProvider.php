<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Athena;
use App\Facades\Aws;

class AthenaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('athena', function () {
            return new Athena(Aws::createClient('athena'));
        });
    }
}
