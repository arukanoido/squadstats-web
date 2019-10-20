<?php

namespace App\Providers;

use Aws\Sdk;
use Illuminate\Support\ServiceProvider;

class AwsServiceProvider extends ServiceProvider
{
    const VERSION = '3.3.2';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('aws', function ($app) {
            $config = [
                'region' => env('AWS_REGION', 'us-west-2'),
                'credentials' => [
                    'key'    => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
                'version' => 'latest',
                'ua_append' => [
                    'L5MOD/' . AwsServiceProvider::VERSION,
                ],
            ];
            return new Sdk($config);
        });
        
        $this->app->alias('aws', 'Aws\Sdk');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['aws', 'Aws\Sdk'];
    }
}
