<?php

namespace app\Services\Contracts;

interface CategoryServiceInterface
{
    public function all();
    public function create(array $data);
}

