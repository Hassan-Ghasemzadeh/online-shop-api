<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\Contracts\ProductServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse;
    protected ProductServiceInterface $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filters = request()->only(['category_id', 'is_active', 'search']);
        $perPage = request('per_page', 15);
        $products = $this->productService->list($filters, $perPage);
        return $this->success($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $products = $this->productService->create($request->validated());
        return $this->success($products, 'Product successfully created', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $products = $this->productService->get((int)$id);
        return $this->success($products, 'Request successfully done');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request,  $id)
    {
        $products = $this->productService->update((int)$id, $request->validated());
        return $this->success($products);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->productService->delete((int)$id);
        return $this->success(null, 'Successfully deleted', 204);
    }
}
