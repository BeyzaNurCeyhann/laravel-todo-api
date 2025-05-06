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
        return response()->json([
            'status' => 'success',
            'data' => TodoResource::collection($todos['data']),
            'meta' => [
                'pagination' => $todos['pagination']
            ]
        ]);
    }

    public function show(int $id)
    {
        $todo = $this->todoService->getById($id);

        if (!$todo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Todo bulunamadı'
            ], Response::HTTP_NOT_FOUND);
        }

        return new TodoResource($todo->load('categories'));
    }


    public function store(StoreTodoRequest $request)
    {
        $todo = $this->todoService->create($request->validated())->load('categories');
        return new TodoResource($todo);
    }


    public function update(UpdateTodoRequest $request, int $id)
    {
        $todo = $this->todoService->update($id, $request->validated());

        if (!$todo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Güncellenecek todo bulunamadı'
            ], Response::HTTP_NOT_FOUND);
        }

        return new TodoResource($todo->load('categories'));
    }


    public function updateStatus(UpdateTodoStatusRequest $request, int $id)
    {

        $todo = $this->todoService->updateStatus($id, $request->validated('status'));

        if (!$todo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Durumu güncellenecek todo bulunamadı'
            ], Response::HTTP_NOT_FOUND);
        }

        return new TodoResource($todo);
    }


    public function destroy(int $id)
    {
        $deleted = $this->todoService->delete($id);

        if (!$deleted) {
            return response()->json([
                'status' => 'error',
                'message' => 'Silinecek todo bulunamadı'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Todo başarıyla silindi'
        ], Response::HTTP_NO_CONTENT);
    }

    public function search(Request $request)
    {
        $term = $request->query('q');

        if (!$term) {
            return response()->json([
                'status' => 'error',
                'message' => 'Arama terimi (q) gerekli.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $results = $this->todoService->search($term);

        return response()->json([
            'status' => 'success',
            'data' => TodoResource::collection($results)
        ]);
    }
}
