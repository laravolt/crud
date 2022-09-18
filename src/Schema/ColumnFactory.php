<?php

namespace Laravolt\Crud\Schema;

use Laravolt\Crud\Schema\Columns\Column;
use Laravolt\Crud\Schema\Columns\StringColumn;

class ColumnFactory
{
    public static function make(\Doctrine\DBAL\Schema\Column $column): Column
    {
        $class = ucfirst($column->getType()->getName());
        $classpath = "\\Laravolt\\Crud\\Schema\\Columns\\{$class}Column";
        if (class_exists($classpath)) {
            return new $classpath($column);
        }

        return new StringColumn($column);
    }
}
