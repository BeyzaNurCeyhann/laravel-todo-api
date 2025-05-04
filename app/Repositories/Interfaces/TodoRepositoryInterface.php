<?php

namespace App\Repositories\Interfaces;

interface TodoRepositoryInterface extends BaseRepositoryInterface
{
   
    public function search(string $term);


    public function updateStatus(int $id, string $status);
    public function paginateWithFilters(array $filters);
}
