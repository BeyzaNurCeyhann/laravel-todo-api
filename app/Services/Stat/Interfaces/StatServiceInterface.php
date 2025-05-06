<?php

namespace App\Services\Stat\Interfaces;

interface StatServiceInterface
{
    public function getTodoCountsByStatus(): array;
    public function getTodoCountsByPriority(): array;
}
