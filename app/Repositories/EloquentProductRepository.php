<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function paginate(int $perpage, array $filters = []): LengthAwarePaginator
    {
        $query = Product::query();
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }
        if (isset($filters['is_active'])) {
            $query->where('is_active', (bool) $filters['is_active']);
        }
        if (!empty($filters['search'])) {
            $query->where('name','like',"%{$filters['search']}%");
        }
        return $query->paginate($perpage);
    }
    public function find(int $id): ?Product
    {
        return Product::find($id);
    }
    public function create(array $data): Product
    {
        return Product::create($data);
    }
    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product->refresh();
    }
    public function delete(Product $product): bool
    {
        return $product->delete();
    }
}
