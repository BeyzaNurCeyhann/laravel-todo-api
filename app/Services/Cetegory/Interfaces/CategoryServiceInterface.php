<?php

namespace App\Services\Category\Interfaces;

use App\Services\Base\Interfaces\BaseServiceInterface;

interface CategoryServiceInterface extends BaseServiceInterface
{
    public function getAll(array $filters = []);
}
