<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\Category\Interfaces\CategoryServiceInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TodoResource;

class CategoryController extends Controller
{
    protected CategoryServiceInterface $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAll();

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori listelendi',
            'data' => CategoryResource::collection($categories)
        ]);
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori başarıyla oluşturuldu',
            'data' => new CategoryResource($category)
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $category = $this->categoryService->getById($id);

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori bulunamadı'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => new CategoryResource($category)
        ]);
    }

    public function update(UpdateCategoryRequest $request, int $id): JsonResponse
    {
        $category = $this->categoryService->update($id, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori başarıyla güncellendi',
            'data' => new CategoryResource($category)
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->categoryService->delete($id);

        if (!$deleted) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori silinemedi'
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori başarıyla silindi'
        ], 204);
    }

    public function todos(int $id)
    {
        $todos = $this->categoryService->getTodosByCategoryId($id);

        if (!$todos) {
            return response()->json([
                'status' => 'error',
                'message' => 'İstenen kaynak bulunamadı.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => TodoResource::collection($todos)
        ]);
    }
}
