<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFilterRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ProductController extends Controller
{
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

        throw_if(is_null($product), new NotFoundHttpException('Product is not found.'));

        return $this->response($product);
    }
}
