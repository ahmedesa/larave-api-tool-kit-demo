<?php

namespace App\Http\Controllers\API;

use App\Enums\StoragePaths;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Essa\APIToolKit\MediaHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function __construct()
    {
//        $this->middleware(['auth:api']);
    }

    public function index(): AnonymousResourceCollection
    {
        $categories = Category::useFilters()->dynamicPaginate();

        return CategoryResource::collection($categories);
    }

    public function store(CreateCategoryRequest $request): JsonResponse
    {
        $category = Category::make($request->validated());

        if ($request->has('image')){
            $category->image = MediaHelper::uploadFile($request->file('image'), StoragePaths::Category);
        }

        $category->save();

        return $this->responseCreated('Category created successfully', new CategoryResource($category));
    }

    public function show(Category $category): JsonResponse
    {
        return $this->responseSuccess(null, new CategoryResource($category));
    }

    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $category->fill($request->validated());

        if ($request->has('image')){
            $category->image = MediaHelper::uploadFile($request->file('image'), 'categories');
        }

        $category->save();

        return $this->responseSuccess('Category updated Successfully', new CategoryResource($category));
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return $this->responseDeleted();
    }

}
