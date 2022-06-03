<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        #api routes
        $this->mapApiRoutes();
        $this->mapRiderApiRoutes();
        $this->mapMerchantApiRoutes();



        #web & Admin  route
        $this->mapWebRoutes();
        $this->mapAdminRoutes();
        $this->mapMerchantRoutes();
        $this->mapHubRoutes();
        $this->mapSellerRoutes();

        
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the user application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api/user')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
    /**
     * Define the "api" routes for the rider application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapRiderApiRoutes()
    {
        Route::prefix('api/rider')
            ->middleware(['api','passport.rider'])
            ->namespace($this->namespace)
            ->group(base_path('routes/rider-api.php'));
    }
    /**
     * Define the "api" routes for the merchant application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapMerchantApiRoutes()
    {
        Route::prefix('api/merchant')
            ->middleware(['api'])
            ->namespace($this->namespace)
            ->group(base_path('routes/merchant-api.php'));
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */

     protected function mapAdminRoutes()
    {
        Route::group([
            'middleware' => ['web', 'admin','roleAuth'],
            'prefix' => 'admin',
            'as' => 'admin.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/admin.php');
        });
    }

     /**
     * Define the "Merchant" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */

     protected function mapMerchantRoutes()
    {
        Route::group([
            'middleware' => ['web', 'merchant'],
            'prefix' => 'merchant',
            'as' => 'merchant.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/merchant.php');
        });
    }


      /**
     * Define the "Hub" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */

     protected function mapHubRoutes()
    {
        Route::group([
            'middleware' => ['web', 'hub'],
            'prefix' => 'hub',
            'as' => 'hub.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/hub.php');
        });
    }  
    /**
     * Define the "Seller Panel" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */

     protected function mapSellerRoutes()
    {
        Route::group([
            'middleware' => ['web', 'seller'],
            'prefix' => 'seller',
            'as' => 'seller.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/seller.php');
        });
    }
}
