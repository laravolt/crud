<?php

namespace Laravolt\Crud\Schema\Columns;

class DecimalColumn extends BaseColumn
{
    protected string $inputType = 'number';

    public function rules(): array
    {
        $rules = parent::rules();
        $rules[] = 'numeric';

        return $rules;
    }
}
