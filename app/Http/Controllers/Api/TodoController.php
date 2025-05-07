<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Todo\Interfaces\TodoServiceInterface;
use App\Http\Resources\TodoResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Requests\UpdateTodoStatusRequest;
use App\Helpers\ApiResponse;
use App\Exceptions\NotFoundException;


class TodoController extends Controller
{
    protected TodoServiceInterface $todoService;

    public function __construct(TodoServiceInterface $todoService)
    {
        $this->todoService = $todoService;
    }

    public function index(Request $request)
    {

        $todos = $this->todoService->getAllWithFilters($request->all(), ['categories']);

        return ApiResponse::success(
            TodoResource::collection($todos['data']),
            '',
            [
                'pagination' => $todos['pagination']
            ]
        );
    }

    public function show(int $id)
    {
        $todo = $this->todoService->getById($id);

        return ApiResponse::success(
            new TodoResource($todo->load('categories'))
        );
    }


    public function store(StoreTodoRequest $request)
    {
        $todo = $this->todoService->create($request->validated())->load('categories');

        return ApiResponse::success(
            new TodoResource($todo),
            'Todo başarıyla oluşturuldu.',
            status: 201
        );
    }


    public function update(UpdateTodoRequest $request, int $id)
    {
        $todo = $this->todoService->update($id, $request->validated())->load('categories');

        if (!$todo) {
            throw new NotFoundException("Güncellenecek todo bulunamadı.");
        }

        return ApiResponse::success(
            new TodoResource($todo->load('categories')),
            'Todo başarıyla güncellendi.'
        );
    }


    public function updateStatus(UpdateTodoStatusRequest $request, int $id)
    {
        $status = $request->safe()->only('status')['status'];

        $todo = $this->todoService->updateStatus($id, $status);

        if (!$todo) {
            throw new NotFoundException("Durumu güncellenecek todo bulunamadı.");
        }

        return ApiResponse::success(
            new TodoResource($todo),
            'Todo durumu başarıyla güncellendi.'
        );
    }


    public function destroy(int $id)
    {
        $deleted = $this->todoService->delete($id);

        if (!$deleted) {
            throw new NotFoundException("Silinecek todo bulunamadı.");
        }

        return ApiResponse::deleted('Todo başarıyla silindi.');
    }

    public function search(Request $request)
    {
        $term = $request->query('q');

    if (!$term) {
        return ApiResponse::error('Arama terimi (q) gerekli.', [], 422);
    }

    // only alırsak page/limit varsa kullanılır, yoksa default
    $filters = $request->only(['page', 'limit']);
    $filters['q'] = $term;

    $todos = $this->todoService->search($filters, ['categories']);

    return ApiResponse::success(
        TodoResource::collection($todos['data']),
        '',
        ['pagination' => $todos['pagination']]
    );
    }
}
