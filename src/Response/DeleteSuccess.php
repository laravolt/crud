<?php

namespace Laravolt\Crud\Response;

use Illuminate\Http\Resources\Json\JsonResource;

class DeleteSuccess extends JsonResource
{
    private const STATUS = 200;

    public function withResponse($request, $response)
    {
        $response->setStatusCode(self::STATUS);
    }

    public function toArray($request)
    {
        return [
            'status' => self::STATUS,
            'message' => 'success',
            'data' => 'Object was deleted',
        ];
    }
}
