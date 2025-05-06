<?php

namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface extends BaseRepositoryInterface {
    public function all(array $columns = ['*']);
    public function getTodosByCategoryId(int $id);
}
