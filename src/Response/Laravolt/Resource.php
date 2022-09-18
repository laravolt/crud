<?php

namespace Laravolt\Crud\Response\Laravolt;

use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    public function with($request)
    {
        return [
            'status' => 200,
            'message' => 'success',
        ];
    }
}
