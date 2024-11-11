<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    /**
     * @param LengthAwarePaginator $data
     * @param string               $resource
     * @return array
     */
    public function toPaginateCollection(LengthAwarePaginator $data, string $resource): array
    {
        /* @var JsonResource $resource */
        if ($collection = $resource::collection($data)->collection) {
            $data->setCollection($collection);
        }

        return [
            'items' => $collection,
            'meta' => $this->toMeta($data)
        ];
    }

    /**
     * @param LengthAwarePaginator $data
     * @return array
     */
    public function toMeta(LengthAwarePaginator $data): array
    {
        return [
            'per_page' => $data->perPage(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'from' => $data->firstItem(),
            'to' => $data->lastItem(),
            'total' => $data->total()
        ];
    }

    /**
     * @param array|object|string|null $data
     * @param bool                     $success
     * @param array                    $headers
     * @param int                      $status
     * @param string|null              $message
     * @return JsonResponse
     */
    public function response(
        array|object|string|null $data = [],
        bool                     $success = true,
        array                    $headers = [],
        int                      $status = Response::HTTP_OK,
        string                   $message = null
    ): JsonResponse {
        return response()->json([
            'success' => $success,
            ...is_null($message)
                ? ['data' => $data]
                : ['message' => $message]
        ], $status, $headers);
    }
}
