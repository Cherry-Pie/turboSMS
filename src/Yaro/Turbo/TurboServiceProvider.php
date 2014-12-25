<?php 

namespace Yaro\Turbo;

use Illuminate\Support\ServiceProvider;


class TurboServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    public function boot()
    {
        $this->package('yaro/turbo');
    }
    
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['yaro_turbo'] = $this->app->share(function($app) {
            return new Turbo();
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
