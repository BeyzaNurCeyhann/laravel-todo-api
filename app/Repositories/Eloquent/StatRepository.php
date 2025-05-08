<?php

namespace App\Repositories\Eloquent;

use App\Models\Todo;
use App\Repositories\Interfaces\StatRepositoryInterface;

class StatRepository implements StatRepositoryInterface
{
    public function countTodosByStatus(): array
    {
        $statusCounts = Todo::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $total = Todo::count();

        $overdue = Todo::whereDate('due_date', '<', now())
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->count();

        return array_merge($statusCounts, [
            'total' => $total,
            'overdue' => $overdue,
        ]);
    }

    public function countTodosByPriority(): array
    {
        $priorityCounts = Todo::selectRaw('priority, COUNT(*) as count')
            ->groupBy('priority')
            ->pluck('count', 'priority')
            ->toArray();

        $total = Todo::count();

        $overdue = Todo::whereDate('due_date', '<', now())
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->count();

        return array_merge($priorityCounts, [
            'total' => $total,
            'overdue' => $overdue,
        ]);
    }
}
