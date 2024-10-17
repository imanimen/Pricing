<?php

namespace Modules\Pricing\Providers;

use Config;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Entities\Action;
use Modules\Pricing\Actions\GetLatestPriceByClassAction;
use Modules\Pricing\Actions\GetPriceAction;
use Modules\Pricing\Actions\GetPriceSum;
use Modules\Pricing\Actions\SetPriceByClassAction;

class PricingServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Pricing';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'pricing';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom( module_path( $this->moduleName , 'Database/Migrations' ) );
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path( 'lang/modules/' . $this->moduleNameLower );

        if ( is_dir( $langPath ) )
        {
            $this->loadTranslationsFrom( $langPath , $this->moduleNameLower );
        }
        else
        {
            $this->loadTranslationsFrom( module_path( $this->moduleName , 'Resources/lang' ) , $this->moduleNameLower );
        }
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes( [
                              module_path( $this->moduleName , 'Config/config.php' ) => config_path( $this->moduleNameLower . '.php' ) ,
                          ] , 'config' );
        $this->mergeConfigFrom(
            module_path( $this->moduleName , 'Config/config.php' ) , $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path( 'views/modules/' . $this->moduleNameLower );

        $sourcePath = module_path( $this->moduleName , 'Resources/views' );

        $this->publishes( [
                              $sourcePath => $viewPath ,
                          ] , [ 'views' , $this->moduleNameLower . '-module-views' ] );

        $this->loadViewsFrom( array_merge( $this->getPublishableViewPaths() , [ $sourcePath ] ) , $this->moduleNameLower );
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach ( Config::get( 'view.paths' ) as $path )
        {
            if ( is_dir( $path . '/modules/' . $this->moduleNameLower ) )
            {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register( RouteServiceProvider::class );
        Action::registerAction( 'pricing' , 'get-price' , GetPriceAction::class );
        Action::registerAction( 'pricing' , 'getModelPrice' , GetLatestPriceByClassAction::class );
        Action::registerAction( 'pricing' , 'setModelPrice' , SetPriceByClassAction::class );
        Action::registerAction( 'pricing' , 'get-price-sum' , GetPriceSum::class );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
