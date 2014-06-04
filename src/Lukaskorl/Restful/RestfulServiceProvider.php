<?php namespace Lukaskorl\Restful;

use JMS\Serializer\SerializerBuilder;
use Illuminate\Support\ServiceProvider;
use App;

class RestfulServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('lukaskorl/restful');
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind('restful', function($app)
        {
           return $app->make('Lukaskorl\Restful\Restful');
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
