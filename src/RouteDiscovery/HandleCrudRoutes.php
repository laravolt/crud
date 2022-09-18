<?php

namespace Laravolt\Crud\RouteDiscovery;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Laravolt\Crud\CrudManager;
use Laravolt\Crud\PrimaryKeyFormat;
use Spatie\RouteDiscovery\Attributes\Where;
use Spatie\RouteDiscovery\PendingRoutes\PendingRoute;
use Spatie\RouteDiscovery\PendingRoutes\PendingRouteAction;
use Spatie\RouteDiscovery\PendingRouteTransformers\PendingRouteTransformer;

class HandleCrudRoutes implements PendingRouteTransformer
{
    private array $crudMethods = ['index', 'spec', 'show', 'create', 'store', 'edit', 'update', 'destroy'];

    public function transform(Collection $pendingRoutes): Collection
    {
        return $pendingRoutes->each(function (PendingRoute $pendingRoute) {
            $pendingRoute->actions = $pendingRoute
                ->actions
                ->filter(fn(PendingRouteAction $action) => in_array($action->action[1], $this->crudMethods, true))
                ->sortBy(function (PendingRouteAction $action) {
                    return array_search($action->method->getName(), $this->crudMethods, true);
                });

            $pendingRoute->actions->each(function (PendingRouteAction $action) {
                $crudAction = $action->action[1];
                $hasId = collect($action->method->getParameters())->first(function (\ReflectionParameter $param) {
                    return $param->getName() === 'id';
                });

                if ($hasId) {
                    $action->uri = "$action->uri/{id}";

                    $constraint = PrimaryKeyFormat::getRouteConstraint(CrudManager::getPrimaryKeyFormat());
                    $action->addWhere(new Where('id', $constraint));
                }
                if (!in_array($crudAction, ['spec', 'import', 'export'])) {
                    $action->name = "$action->name.$crudAction";
                }
            });
        });
    }
}
