<?php

namespace App\Repositories\Interfaces;

interface TodoRepositoryInterface extends BaseRepositoryInterface
{
    public function search(string $term, array $with = []);
    public function updateStatus(int $id, string $status);
    public function paginateWithFilters(array $filters);
}
