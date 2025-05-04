<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\JsonResponse;

class TodoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $action = $request->route()->getActionMethod();

        if ($action === 'updateStatus') {
            return [
                'id'         => $this->id,
                'status'     => $this->status,
                'updated_at' => $this->updated_at,
            ];
        }

        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'status'      => $this->status,
            'priority'    => $this->priority,
            'due_date'    => $this->due_date,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'categories'  => CategoryResource::collection($this->whenLoaded('categories')),
        ];
    }

    public function toResponse($request): JsonResponse
    {
        $action = $request->route()->getActionMethod();

        $response = [
            'status' => 'success',
            'data'   => $this->toArray($request),
        ];

        if (in_array($action, ['store', 'update', 'updateStatus', 'destroy'])) {
            $response['message'] = match ($action) {
                'store'        => 'Todo başarıyla oluşturuldu',
                'update'       => 'Todo başarıyla güncellendi',
                'updateStatus' => 'Todo durumu başarıyla güncellendi',
                'destroy'      => 'Todo başarıyla silindi',
                default        => null,
            };
        }

        return response()->json($response, $this->getStatusCode($action));
    }

    private function getStatusCode(string $action): int
    {
        return match ($action) {
            'store'   => 201,
            'destroy' => 204,
            default   => 200,
        };
    }
}
