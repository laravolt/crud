<?php

namespace Laravolt\Crud\Schema\Columns;

class IntegerColumn extends BaseColumn
{
    protected string $inputType = 'number';

    public function rules(): array
    {
        $rules = parent::rules();
        $rules[] = 'integer';

        return $rules;
    }
}
