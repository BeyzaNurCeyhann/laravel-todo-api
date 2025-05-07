<?php

namespace App\Services\Todo\Interfaces;

use App\Services\Base\Interfaces\BaseServiceInterface;

interface TodoServiceInterface extends BaseServiceInterface
{
    public function search(array $filters, array $with = []);
    public function updateStatus(int $id, string $status);
    public function getAllWithFilters(array $filters, array $with = []);
}
