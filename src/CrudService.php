<?php

namespace Laravolt\Crud;

use Doctrine\DBAL\Schema\Column;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravolt\Crud\Contracts\StoreRequestContract;
use Laravolt\Crud\Contracts\UpdateRequestContract;
use Laravolt\Crud\Schema\ColumnFactory;

class CrudService
{
    /**
     * @var \Laravolt\Crud\CrudModel
     */
    private CrudModel $model;

    /**
     * @var array<int, string>
     */
    protected array $autoLoadRelations = [];

    public function __construct(CrudModel $model)
    {
        $this->model = $model;
        $this->autoLoadRelations = $this->getAutoLoadRelations();
    }

    public function find(mixed $id): CrudModel
    {
        return $this->model->newQuery()->with($this->autoLoadRelations)->findOrFail($id);
    }

    public function get(Request $request): LengthAwarePaginator
    {
        return $this->model
            ->newQuery()
            ->with($this->autoLoadRelations)
            ->autoSearch($request->input('search'))
            ->autoSort()
            ->autoFilter(null)
            ->paginate($request->input('limit'), ['*'], 'page', $request->input('page', 0) + 1);
    }

    public function create(StoreRequestContract $request): CrudModel
    {
        return $this->model->newQuery()->create($request->all())->load($this->autoLoadRelations);
    }

    public function update(mixed $id, UpdateRequestContract $request): CrudModel
    {
        $model = $this->model->newQuery()->findOrFail($id);
        $model->update($request->all());
        $model->load($this->autoLoadRelations);

        return $model;
    }

    public function delete(mixed $id): ?bool
    {
        return $this->model->newQuery()->findOrFail($id)->delete();
    }

    public function spec(): Collection
    {
        /** @var \Doctrine\DBAL\Schema\AbstractSchemaManager $schemaManager */
        $schemaManager = DB::getDoctrineSchemaManager();
        $table = $this->model->getTable();
        $columns = collect($schemaManager->listTableColumns($table));
        return $columns->map(function (Column $column) {
            return ColumnFactory::make($column)->spec();
        })->values();
    }

    /**
     * @return array<int, string>
     */
    private function getAutoLoadRelations(): array
    {
        $reflector = new \ReflectionClass($this->model);

        return collect($reflector->getMethods())
            ->filter(
                function (\ReflectionMethod $method) {
                    /** @var \ReflectionNamedType $returnType */
                    $returnType = $method->getReturnType();

                    return $returnType !== null
                        && in_array(
                            $returnType->getName(),
                            [
                                BelongsTo::class,
                                HasOne::class,
                            ]
                        );
                }
            )
            ->pluck('name')
            ->toArray();
    }
}
