<?php

namespace Laravolt\Crud;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravolt\Crud\RouteDiscovery\HandleCrudRoutes;

class CrudServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::macro('crud', function ($name, $controller) {
            Route::get("$name/spec", [$controller, 'spec'])->name("$name.spec");
            Route::resource($name, $controller);
        });

        $default = config()->get('route-discovery.pending_route_transformers');
        $default[] = HandleCrudRoutes::class;
        config()->set('route-discovery.pending_route_transformers', $default);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'crud');
    }
}
