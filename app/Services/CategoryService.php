<?php

namespace App\Services;

use app\Repositories\CategoryRepositoryInterface;

class CategoryService implements CategoryRepositoryInterface
{
    protected CategoryRepositoryInterface $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function all()
    {
        return $this->categoryRepo->all();
    }
    public function create(array $data)
    {
        return $this->categoryRepo->create($data);
    }
}
