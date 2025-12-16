<?php

namespace app\Repositories;

use App\Models\Category;

class EloquentCategoryRepository implements CategoryRepositoryInterface
{
    public function all()
    {
        return Category::with('products')->get();
    }
    public function create(array $data)
    {
        throw new \Exception('Not implemented');
    }
}
