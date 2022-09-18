<?php

namespace Laravolt\Crud\Schema\Columns;

class DatetimeColumn extends BaseColumn
{
    protected string $inputType = 'datetime-local';

    public function rules(): array
    {
        $rules = parent::rules();
        $rules[] = 'date_format:Y-m-d H:i:s';

        return $rules;
    }
}
