<?php

namespace Laravolt\Crud\Response\Laravolt;

use Illuminate\Http\Resources\Json\ResourceCollection as BaseResourceCollection;

class ResourceCollection extends BaseResourceCollection
{
    public function with($request)
    {
        return [
            'status' => 200,
            'message' => 'success',
        ];
    }
}
