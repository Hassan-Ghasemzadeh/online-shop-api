<?php

namespace app\Repositories;

interface CategoryRepositoryInterface
{
    public function all();
    public function create(array $data);
}
