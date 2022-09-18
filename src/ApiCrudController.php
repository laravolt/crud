<?php

namespace Laravolt\Crud;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection as BaseResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Laravolt\Crud\Contracts\StoreRequestContract;
use Laravolt\Crud\Contracts\UpdateRequestContract;
use Laravolt\Crud\Response\DeleteFail;
use Laravolt\Crud\Response\DeleteSuccess;
use Laravolt\Crud\Response\Laravolt\Resource;
use Laravolt\Crud\Response\Laravolt\ResourceCollection;
use Laravolt\Crud\Response\NotFound;

abstract class ApiCrudController extends Controller
{
    protected CrudService $service;

    protected string $storeRequest = CrudRequest::class;

    protected string $updateRequest = CrudRequest::class;

    protected static string $resource = Resource::class;

    protected static string $resourceCollection = ResourceCollection::class;

    abstract protected function model(): CrudModel;

    public function __construct()
    {
        $this->service = $this->service();
        $this->init();
    }

    protected function service(): CrudService
    {
        return new CrudService($this->model());
    }

    protected function init(): void
    {
        app()->bind(StoreRequestContract::class, $this->storeRequest);
        app()->bind(UpdateRequestContract::class, $this->updateRequest);
    }

    public static function setFormat(ApiFormat $format): void
    {
        switch ($format) {
            case ApiFormat::AlurKerja:
                static::$resource = \Laravolt\Crud\Response\AlurKerja\Resource::class;
                static::$resourceCollection = \Laravolt\Crud\Response\AlurKerja\ResourceCollection::class;
                break;
            case ApiFormat::Laravolt:
                static::$resource = \Laravolt\Crud\Response\Laravolt\Resource::class;
                static::$resourceCollection = \Laravolt\Crud\Response\Laravolt\ResourceCollection::class;

                break;
        }
    }

    public function index(Request $request): BaseResourceCollection
    {
        return $this->collection($this->service->get($request));
    }

    public function show(Request $request, mixed $id): JsonResource
    {
        try {
            return $this->single($this->service->find($id));
        } catch (ModelNotFoundException $e) {
            return new NotFound($e);
        }
    }

    public function store(StoreRequestContract $request): JsonResource
    {
        $model = $this->service->create($request);

        return $this->single($model);
    }

    public function update(UpdateRequestContract $request, mixed $id): JsonResource
    {
        try {
            $model = $this->service->update($id, $request);

            return $this->single($model);
        } catch (ModelNotFoundException $e) {
            return new NotFound($e);
        }
    }

    public function destroy(mixed $id): JsonResource
    {
        try {
            $deleted = $this->service->delete($id);

            return $deleted ? new DeleteSuccess(null) : new DeleteFail(null);
        } catch (ModelNotFoundException $e) {
            return new NotFound($e);
        }
    }

    public function spec(): JsonResource
    {
        return $this->collection($this->service->spec());
    }

    protected function single(Model $model): JsonResource
    {
        return app(static::$resource, ['resource' => $model]);
    }

    protected function collection(Collection|LengthAwarePaginator $collection): BaseResourceCollection
    {
        return app(static::$resourceCollection, ['resource' => $collection]);
    }
}
