<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Stat\Interfaces\StatServiceInterface;
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
        return response()->json([
            'status' => 'success',
            'data' => $this->statService->getTodoCountsByStatus()
        ]);
    }

    public function priorities(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->statService->getTodoCountsByPriority()
        ]);
    }
}
