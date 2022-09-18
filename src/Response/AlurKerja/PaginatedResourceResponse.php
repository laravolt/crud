<?php

namespace Laravolt\Crud\Response\AlurKerja;

use Illuminate\Http\Resources\Json\PaginatedResourceResponse as BasePaginatedResourceResponse;

class PaginatedResourceResponse extends BasePaginatedResourceResponse
{
    public function toArray()
    {
        return $this->resource->resource->toArray();
    }

    protected function paginationInformation($request)
    {
        $pagination = parent::paginationInformation($request);
        unset($pagination['meta'], $pagination['links']);

        return $pagination;
    }
}
