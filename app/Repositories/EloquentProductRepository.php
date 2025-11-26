<?php

namespace App\Repositories;

use App\Models\Product;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function all(array $filters = [])
    {
        return Product::query()->get();
    }
    public function find(int $id)
    {
        return Product::findorFail($id);
    }
    public function create(array $data)
    {
        return Product::create($data);
    }
    public function update(int $id, array $data)
    {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }
    public function delete(int $id): bool
    {
        $product = $this->find($id);
        return $product->delete();
    }
}
