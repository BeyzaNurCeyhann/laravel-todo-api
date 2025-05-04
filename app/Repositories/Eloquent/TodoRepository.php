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

    public function paginateWithFilters(array $filters)
{
    $query = $this->model->newQuery();

    // Filtreler
    if (!empty($filters['status'])) {
        $query->where('status', $filters['status']);
    }

    if (!empty($filters['priority'])) {
        $query->where('priority', $filters['priority']);
    }

    // Sıralama
    $sortField = $filters['sort'] ?? 'created_at';
    $sortOrder = $filters['order'] ?? 'desc';

    $query->orderBy($sortField, $sortOrder);

    // Sayfalama
    $limit = min((int)($filters['limit'] ?? 10), 50);
    return $query->paginate($limit)->appends($filters);
}
}
