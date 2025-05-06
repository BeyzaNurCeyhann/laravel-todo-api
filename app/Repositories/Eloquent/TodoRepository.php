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

    
    public function search(string $term)
    {
        return $this->model
            ->where('title', 'like', "%$term%")
            ->orWhere('description', 'like', "%$term%")
            ->get();
    }


    public function updateStatus(int $id, string $status)
    {
        $todo = $this->find($id);
        if (!$todo) {
            return false;
        }

        $todo->status = $status;
        return $todo->save();
    }

    public function paginateWithFilters(array $filters, array $with = [])
    {
        //dd($filters);
        $query = Todo::filter($filters);

        $allowedSorts = ['created_at', 'due_date', 'priority'];
        $sort = in_array($filters['sort'] ?? '', $allowedSorts) ? $filters['sort'] : 'created_at';

        $order = strtolower($filters['order'] ?? 'desc');
        $order = in_array($order, ['asc', 'desc']) ? $order : 'desc';

        $query->orderBy($sort, $order);

        $limit = isset($filters['limit']) && $filters['limit'] <= 50 ? (int)$filters['limit'] : 10;

        $paginator = $query->paginate($limit);

        return [
            'data' => $paginator->items(),
            'pagination' => [
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
            ]
        ];
    }
}
