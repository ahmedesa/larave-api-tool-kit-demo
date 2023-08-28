<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function index(): AnonymousResourceCollection 
    {
        $categories = Category::useFilters()->dynamicPaginate();

        return CategoryResource::collection($categories);
    }

    public function store(CreateCategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());

        return $this->responseCreated('Category created successfully', new CategoryResource($category));
    }

    public function show(Category $category): JsonResponse
    {
        return $this->responseSuccess(null, new CategoryResource($category));
    }

    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $category->update($request->validated());

        return $this->responseSuccess('Category updated Successfully', new CategoryResource($category));
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return $this->responseDeleted();
    }

}
