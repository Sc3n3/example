<?php

namespace App\RealEstate\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RealEstateServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $namespace = 'App\\RealEstate\\Controllers';

    /**
     * @return void
     */
    public function register()
    {
        $this->loadMigrationsFrom(app_path('RealEstate/Migrations'));

        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(app_path('RealEstate/Routes/api.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(app_path('RealEstate/Routes/web.php'));
    }
}