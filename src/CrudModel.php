<?php

namespace Laravolt\Crud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravolt\Suitable\AutoFilter;
use Laravolt\Suitable\AutoSearch;
use Laravolt\Suitable\AutoSort;

class CrudModel extends Model
{
    use HasFactory;
    use AutoSort;
    use AutoFilter;
    use AutoSearch;

    protected $guarded = [];

    protected array $searchableColumns = [];

    protected array $filterableColumns = [];
}
