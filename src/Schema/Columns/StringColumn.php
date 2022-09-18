<?php

namespace Laravolt\Crud\Schema\Columns;

class StringColumn extends BaseColumn
{
    protected string $inputType = 'text';

    public function rules(): array
    {
        $rules = parent::rules();
        $rules[] = 'string';
        $max = $this->column->getLength();
        if ($max) {
            $rules[] = "max:$max";
        }

        return $rules;
    }
}
