<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Services\CategoryService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponse;
    protected CategoryService $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->success($this->categoryService->all(), "Successfully got all data");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $request->validate();
        $category = $this->categoryService->create($request->all());
        return $this->success($category, "Successfully got the category", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
