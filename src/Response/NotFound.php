<?php

namespace Laravolt\Crud\Response;

use Illuminate\Http\Resources\Json\JsonResource;

class NotFound extends JsonResource
{
    private const STATUS = 404;

    public function withResponse($request, $response)
    {
        $response->setStatusCode(self::STATUS);
    }

    public function toArray($request)
    {
        return [
            'status' => self::STATUS,
            'message' => 'not_found',
            'data' => $this->resource->getMessage(),
        ];
    }
}
