<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function all(array $columns = ['*'])
    {
        return $this->model->all($columns);
    }

    public function getTodosByCategoryId(int $id)
    {
        $category = $this->model->find($id);

        if (!$category) {
            return null;
        }

        //return $category->todos()->with('categories')->get();
        return $category->todos()->get();
    }
}
