<?php

namespace Laravolt\Crud\Response;

use Illuminate\Http\Resources\Json\JsonResource;

class NoContent extends JsonResource
{
    private const STATUS = 204;

    public function withResponse($request, $response)
    {
        $response->setStatusCode(self::STATUS);
    }

    public function toArray($request)
    {
        return [
            'status' => self::STATUS,
            'message' => 'no_content',
            'data' => null,
        ];
    }
}
