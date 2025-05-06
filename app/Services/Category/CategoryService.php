<?php

namespace App\Services\Category;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Services\Category\Interfaces\CategoryServiceInterface;
use App\Services\Base\BaseService;

class CategoryService extends BaseService implements CategoryServiceInterface
{
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        parent::__construct($categoryRepository);
        $this->categoryRepository = $categoryRepository;
    }
    public function getAll(array $filters = [])
    {
        return $this->categoryRepository->all();
    }
}
