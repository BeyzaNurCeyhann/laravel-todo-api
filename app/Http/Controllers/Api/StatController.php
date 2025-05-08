<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Stat\Interfaces\StatServiceInterface;
use App\Http\Resources\StatusStatResource;
use App\Http\Resources\PriorityStatResource;
use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;


class StatController extends Controller
{
    protected StatServiceInterface $statService;

    public function __construct(StatServiceInterface $statService)
    {
        $this->statService = $statService;
    }

    public function todos(): JsonResponse
    {
        $data = $this->statService->getTodoCountsByStatus();

        return ApiResponse::success(
            new StatusStatResource($data),
            'Durum istatistikleri başarıyla getirildi.'
        );
    }

    public function priorities(): JsonResponse
    {
        $data = $this->statService->getTodoCountsByPriority();

        return ApiResponse::success(
            new PriorityStatResource($data),
            'Öncelik istatistikleri başarıyla getirildi.'
        );
    }
}
