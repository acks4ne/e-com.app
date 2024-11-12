<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFilterRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Throwable;

class ProductController extends Controller
{
    /**
     * @param ProductService $productService
     */
    public function __construct(
        protected ProductService $productService
    ) {}

    /**
     * @param ProductFilterRequest $request
     * @return JsonResponse
     */
    public function index(ProductFilterRequest $request): JsonResponse
    {
        return $this->response(
            $this->toPaginateCollection(
                $this->productService->getProductsWithFilters($request->validated()),
                ProductResource::class
            ),
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function show(int $id): JsonResponse
    {
        $product = $this->productService->firstById($id);

        if (is_null($product)) {
            return $this->response(
                success:false,
                status:404,
                message:'Product is not found.'
            );
        }

        return $this->response($product);
    }
}
