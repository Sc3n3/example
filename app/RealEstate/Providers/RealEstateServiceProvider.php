<?php

namespace App\RealEstate\Providers;

use App\RealEstate\Contracts\IDirectionResolver;
use App\RealEstate\Contracts\IZipResolver;
use App\RealEstate\Events\AppointmentCreated;
use App\RealEstate\Events\AppointmentDeleted;
use App\RealEstate\Events\AppointmentUpdated;
use App\RealEstate\Events\PropertyCreated;
use App\RealEstate\Events\PropertyDeleted;
use App\RealEstate\Events\PropertyUpdated;
use App\RealEstate\Services\GoogleDirections;
use App\RealEstate\Services\PostCodesIO;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RealEstateServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $namespace = 'App\\RealEstate\\Controllers';

    /**
     * @var array[]
     */
    protected $events = [
        PropertyCreated::class => [],
        PropertyUpdated::class => [],
        PropertyDeleted::class => [],
        AppointmentCreated::class => [],
        AppointmentUpdated::class => [],
        AppointmentDeleted::class => []
    ];

    /**
     * @return void
     */
    public function register()
    {
        $this->setRoutes();
        $this->setEvents();
        $this->bindDependencies();
        $this->loadMigrationsFrom(app_path('RealEstate/assets/migrations'));
    }

    /**
     * @return void
     */
    protected function bindDependencies()
    {
        $this->app->bind(IZipResolver::class, function(){
            return new PostCodesIO();
        });

        $this->app->bind(IDirectionResolver::class, function(){
            return new GoogleDirections(env('GOOGLE_API_KEY'));
        });

    }

    /**
     * @return void
     */
    protected function setEvents()
    {
        foreach ($this->events as $event => $listeners) {
            foreach($listeners as $listener) {
                Event::listen($event, $listener);
            }
        }
    }

    /**
     * @return void
     */
    protected function setRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(app_path('RealEstate/assets/routes/api.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(app_path('RealEstate/assets/routes/web.php'));

    }
}