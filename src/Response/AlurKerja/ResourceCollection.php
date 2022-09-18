<?php

namespace Laravolt\Crud\Response\AlurKerja;

use Illuminate\Http\Resources\Json\ResourceCollection as BaseResourceCollection;
use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Pagination\AbstractPaginator;

class ResourceCollection extends BaseResourceCollection
{
    public function with($request)
    {
        return [
            'status' => 200,
            'message' => 'success',
        ];
    }

    public function toArray($request)
    {
        $response = ['data' => $this->collection];

        if ($this->resource instanceof AbstractPaginator || $this->resource instanceof AbstractCursorPaginator) {
            $response = ['data' => ['content' => $this->collection]];
            $pagination = (new PaginatedResourceResponse($this))->toArray();

            $response['data'] += [
                'pageable' => [
                    'sort' => [
                        'sorted' => $request->has('sort'),
                        'unsorted' => ! $request->has('sort'),
                        'empty' => $this->collection->isEmpty(),
                    ],
                    'offset' => $pagination['per_page'] * ($pagination['current_page'] - 1),
                    'pageNumber' => $pagination['current_page'] - 1,
                    'pageSize' => $pagination['per_page'],
                    'paged' => true,
                    'unpaged' => false,
                ],
                'totalPages' => $pagination['last_page'],
                'totalElements' => $pagination['total'],
                'numberOfElements' => $pagination['total'],
                'first' => $pagination['current_page'] === 1,
                'last' => $pagination['current_page'] === $pagination['last_page'],
                'size' => $pagination['per_page'],
                'number' => $pagination['current_page'] - 1,
                'empty' => $pagination['total'] === 0,
                'sort' => [
                    'sorted' => $request->has('sort'),
                    'unsorted' => ! $request->has('sort'),
                    'empty' => $this->collection->isEmpty(),
                ],
            ];
        }

        return $response;
    }

    /**
     * Create a paginate-aware HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function preparePaginatedResponse($request)
    {
        if ($this->preserveAllQueryParameters) {
            $this->resource->appends($request->query());
        } elseif (! is_null($this->queryParameters)) {
            $this->resource->appends($this->queryParameters);
        }

        return (new PaginatedResourceResponse($this))->toResponse($request);
    }
}
