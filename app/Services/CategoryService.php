<?php

namespace App\Services;

use app\Repositories\CategoryRepositoryInterface;
use App\Services\Contracts\CategoryServiceInterface;

class CategoryService implements CategoryServiceInterface
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
