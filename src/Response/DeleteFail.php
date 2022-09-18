<?php

namespace Laravolt\Crud\Response;

use Illuminate\Http\Resources\Json\JsonResource;

class DeleteFail extends JsonResource
{
    private const STATUS = 422;

    public function withResponse($request, $response)
    {
        $response->setStatusCode(self::STATUS);
    }

    public function toArray($request)
    {
        return [
            'status' => self::STATUS,
            'message' => 'error',
            'data' => 'Object deletion failed',
        ];
    }
}
