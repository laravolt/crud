<?php

namespace Laravolt\Crud\Schema\Columns;

class JsonColumn extends BaseColumn
{
    protected string $inputType = 'json';

    public function rules(): array
    {
        $rules = parent::rules();
        $rules[] = 'json';

        return $rules;
    }
}
