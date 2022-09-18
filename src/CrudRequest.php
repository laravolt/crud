<?php

namespace Laravolt\Crud;

use Doctrine\DBAL\Schema\Column;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Laravolt\Crud\Contracts\StoreRequestContract;
use Laravolt\Crud\Contracts\UpdateRequestContract;
use Laravolt\Crud\Schema\ColumnFactory;

class CrudRequest extends FormRequest implements StoreRequestContract, UpdateRequestContract
{
    public function rules()
    {
        // @TODO how to skip column?
        $except = ['id', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'];

        /** @var \Doctrine\DBAL\Schema\AbstractSchemaManager $schemaManager */
        $schemaManager = DB::getDoctrineSchemaManager();
        $table = 'pelatihan';
        return collect($schemaManager->listTableColumns($table))->mapWithKeys(function (Column $column) {
            return [$column->getName() => ColumnFactory::make($column)->rules()];
        })->except($except)->toArray();
    }

    protected function failedValidation(Validator $validator)
    {
        if (CrudManager::getApiFormat() === ApiFormat::AlurKerja) {
            throw new \Laravolt\Crud\Response\AlurKerja\ValidationException($validator);
        }

        parent::failedValidation($validator);
    }
}
