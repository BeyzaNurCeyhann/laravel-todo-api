<?php

namespace App\Repositories\Eloquent;

use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;

class TodoRepository extends BaseRepository implements TodoRepositoryInterface
{
    public function __construct(Todo $model)
    {
        parent::__construct($model);
    }

    /**
     * Başlık veya açıklamaya göre arama
     * GET /api/todos/search?q=terim
     */
    public function search(string $term)
    {
        return $this->model
            ->where('title', 'like', "%$term%")
            ->orWhere('description', 'like', "%$term%")
            ->get();
    }

    /**
     * Sadece todo durumunu günceller
     * PATCH /api/todos/{id}/status
     */
    public function updateStatus(int $id, string $status)
    {
        $todo = $this->find($id);
        if (!$todo) {
            return false;
        }

        $todo->status = $status;
        return $todo->save();
    }
}
