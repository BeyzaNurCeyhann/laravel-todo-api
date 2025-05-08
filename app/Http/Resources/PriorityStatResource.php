<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PriorityStatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'low'     => $this['low'] ?? 0,
            'medium'  => $this['medium'] ?? 0,
            'high'    => $this['high'] ?? 0,
            'total'   => $this['total'] ?? 0,
            'overdue' => $this['overdue'] ?? 0,
        ];
    }
}
