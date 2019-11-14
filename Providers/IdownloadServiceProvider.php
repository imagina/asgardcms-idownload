<?php

namespace Modules\Idownload\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Idownload\Events\Handlers\RegisterIdownloadSidebar;

class IdownloadServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterIdownloadSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('categories', array_dot(trans('idownload::categories')));
            $event->load('downloads', array_dot(trans('idownload::downloads')));
            $event->load('suscriptors', array_dot(trans('idownload::suscriptors')));
            // append translations



        });
    }

    public function boot()
    {
        $this->publishConfig('idownload', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
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

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Idownload\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Idownload\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Idownload\Entities\Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Idownload\Repositories\Cache\CacheCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Idownload\Repositories\DownloadRepository',
            function () {
                $repository = new \Modules\Idownload\Repositories\Eloquent\EloquentDownloadRepository(new \Modules\Idownload\Entities\Download());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Idownload\Repositories\Cache\CacheDownloadDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Idownload\Repositories\SuscriptorRepository',
            function () {
                $repository = new \Modules\Idownload\Repositories\Eloquent\EloquentSuscriptorRepository(new \Modules\Idownload\Entities\Suscriptor());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Idownload\Repositories\Cache\CacheSuscriptorDecorator($repository);
            }
        );
// add bindings



    }
}
