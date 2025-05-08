<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatusStatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'pending'   => $this['pending'] ?? 0,
            'in_progress' => $this['in_progress'] ?? 0,
            'completed' => $this['completed'] ?? 0,
            'cancelled' => $this['cancelled'] ?? 0,
            'total'     => $this['total'] ?? 0,
            'overdue'   => $this['overdue'] ?? 0,
        ];
    }
}
