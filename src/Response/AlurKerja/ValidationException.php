<?php

namespace Laravolt\Crud\Response\AlurKerja;

use Illuminate\Contracts\Support\Responsable;

class ValidationException extends \Illuminate\Validation\ValidationException implements Responsable
{
    public $status = 400;

    public function toResponse($request)
    {
        $data = [];

        foreach ($this->errors() as $key => $errors) {
            foreach ($errors as $error) {
                $data[] = [$key => $error];
            }
        }
        return response()->json(
            [
                'status' => $this->status,
                'message' => $this->getMessage(),
                'data' => $data,
            ],
            $this->status
        );
    }
}
