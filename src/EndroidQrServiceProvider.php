<?php
/**
 * Created by PhpStorm.
 * User: jelle
 * Date: 21-12-2016
 * Time: 08:23
 */

namespace Dijkma\EndroidQrLaravelBundle\src;

use Illuminate\Support\ServiceProvider;

class EndroidQrServiceProvider extends ServiceProvider {

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

        //routes in laden
        $this->app->router->group(
            ['namespace' => 'Dijkma\EndroidQrLaravelBundle\src'],
            function(){
                require __DIR__.'/../routes/routes.php';
            }
        );
        $this->bladeDirectives();
        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'QR');
        $this->publishConfig();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->alias('QR', 'dijkma\EndroidQrLaravelBundle\src\Facade');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(){
        return [];
    }

    /**
     * Register the blade directives
     *
     * @return void
     */
    private function bladeDirectives()
    {
        // Call to QR;;create
        \Blade::directive('QR', function($configdata) {
            return "<?php echo(\\QR::create({$configdata})) ?>";
        });
    }

    private function publishConfig(){
        $this->publishes([__DIR__.'/../config/config.php' => config_path('qr.php')], 'config');
    }

    private function publishMigrations(){
        $this->publishes([  __DIR__.'/database/Migrations/' => database_path('migrations')], 'migrations');
    }

    private function publishPublic(){
        $this->publishes([__DIR__ . '/public' => public_path('/')], 'public');
    }

}
