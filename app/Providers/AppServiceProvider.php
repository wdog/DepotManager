<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use ViewComponents\ViewComponents\Component\Control\SelectFilterControl;
use ViewComponents\ViewComponents\Resource\ResourceManager;
use ViewComponents\ViewComponents\Service\Bootstrap;
use ViewComponents\ViewComponents\Service\ServiceContainer;
use ViewComponents\ViewComponents\Service\ServiceId;

use ViewComponents\ViewComponents\Service\Services;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength( 191 );

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        Bootstrap::registerServiceProvider( function ( ServiceContainer $container ) {
            $container->extend( ServiceId::RESOURCE_MANAGER, function ( ResourceManager $resourceManager ) {
                $resourceManager
                    ->ignoreCss( [ 'bootstrap' ] )
                    ->ignoreJs( [ 'jquery', 'bootstrap' ] );
                return $resourceManager;
            } );
        } );



        Services::renderer()->getFinder()->registerPath( dirname( __DIR__ ) . '/../resources/views/vendor/grid-bootstrap/', true);
        //dd ( Services::renderer()->getFinder());
    }
}
