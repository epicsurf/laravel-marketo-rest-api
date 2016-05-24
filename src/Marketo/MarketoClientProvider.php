<?php

namespace InfusionWeb\Laravel\Marketo;

use Illuminate\Support\ServiceProvider;
use InfusionWeb\Laravel\Marketo\MarketoClient;

class MarketoClientProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMarketoClient();

        $this->app->alias('marketo', 'InfusionWeb\Laravel\Marketo\MarketoClient');
    }

    /**
     * Register the Marketo connection instance.
     *
     * @return void
     */
    protected function registerMarketoClient()
    {
        $this->app->singleton('marketo', function($app)
        {
            return new MarketoClient($app['url']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('marketo', 'InfusionWeb\Laravel\Marketo\MarketoClient');
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/marketo.php' => config_path('marketo.php'),
        ]);
    }

}
