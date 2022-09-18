<?php

namespace Laravolt\Crud\Schema\Columns;

interface Column
{
    public function spec(): array;
    public function rules(): array;
}
