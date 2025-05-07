<?php

namespace App\Services\Todo;

use App\Services\Base\BaseService;
use App\Services\Todo\Interfaces\TodoServiceInterface;
use App\Repositories\Interfaces\TodoRepositoryInterface;

class TodoService extends BaseService implements TodoServiceInterface
{
    protected TodoRepositoryInterface $todoRepository;

    public function __construct(TodoRepositoryInterface $todoRepository)
    {
        parent::__construct($todoRepository);
        $this->todoRepository = $todoRepository;
    }

    public function search(string $term, array $with = [])
    {
        return $this->todoRepository->search($term, $with);
    }

    public function updateStatus(int $id, string $status)
    {
        return $this->todoRepository->updateStatus($id, $status);
    }

    public function getAllWithFilters(array $filters, array $with = [])
    {
        return $this->todoRepository->paginateWithFilters($filters, $with);
    }
}
