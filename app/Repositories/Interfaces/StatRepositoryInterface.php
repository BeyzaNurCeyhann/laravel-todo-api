<?php

namespace App\Repositories\Interfaces;

interface StatRepositoryInterface
{
    public function countTodosByStatus(): array;
    public function countTodosByPriority(): array;
}
