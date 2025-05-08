<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\Category\Interfaces\CategoryServiceInterface;
use App\Helpers\ApiResponse;
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

        return ApiResponse::success(
            CategoryResource::collection($categories),
            'Kategoriler başarıyla listelendi.'
        );
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->create($request->validated());

        return ApiResponse::success(
            new CategoryResource($category),
            'Kategori başarıyla oluşturuldu.',
            status: 201
        );
    }

    public function show(int $id): JsonResponse
    {
        $category = $this->categoryService->getById($id);

        if (!$category) {
            return ApiResponse::error('Kategori bulunamadı.', status: 404);
        }

        return ApiResponse::success(
            new CategoryResource($category),
            'Kategori başarıyla getirildi.'
        );
    }

    public function update(UpdateCategoryRequest $request, int $id): JsonResponse
    {
        $category = $this->categoryService->update($id, $request->validated());

        return ApiResponse::success(
            new CategoryResource($category),
            'Kategori başarıyla güncellendi.'
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->categoryService->delete($id);

        if (!$deleted) {
            return ApiResponse::error('Kategori silinemedi.', status: 400);
        }

        return ApiResponse::deleted('Kategori başarıyla silindi.');
    }

    public function todos(int $id)
    {
        $todos = $this->categoryService->getTodosByCategoryId($id);

        if (!$todos) {
            return ApiResponse::error('İstenen kategori veya todo bulunamadı.', status: 404);
        }

        return ApiResponse::success(
            TodoResource::collection($todos),
            'Kategoriye ait todo’lar başarıyla getirildi.'
        );
    }
}
