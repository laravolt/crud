<?php

namespace Laravolt\Crud\Schema\Columns;

class TextColumn extends BaseColumn
{
    protected string $inputType = 'textarea';

    public function rules(): array
    {
        $rules = parent::rules();
        $rules[] = 'string';

        return $rules;
    }
}
