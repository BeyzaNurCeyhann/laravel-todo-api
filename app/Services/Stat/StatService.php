<?php

namespace App\Services\Stat;

use App\Repositories\Interfaces\StatRepositoryInterface;
use App\Services\Stat\Interfaces\StatServiceInterface;

class StatService implements StatServiceInterface
{
    protected StatRepositoryInterface $statRepository;

    public function __construct(StatRepositoryInterface $statRepository)
    {
        $this->statRepository = $statRepository;
    }

    public function getTodoCountsByStatus(): array
    {
        return $this->statRepository->countTodosByStatus();
    }

    public function getTodoCountsByPriority(): array
    {
        return $this->statRepository->countTodosByPriority();
    }
}
