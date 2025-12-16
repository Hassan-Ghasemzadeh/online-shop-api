<?php

namespace App\Services;

use App\Services\Contracts\ProductServiceInterface;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface as ContractsProductRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService implements ProductServiceInterface
{
    protected ContractsProductRepositoryInterface $productRepo;

    public function __construct(ContractsProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function list(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return $this->productRepo->paginate($perPage, $filters);
    }

    public function get(int $id): ?Product
    {
        $product = $this->productRepo->find($id);
        if (!$product) {
            throw new ModelNotFoundException("Product not found");
        }
        return $product;
    }

    public function create(array $data): Product
    {
        if (empty($data['sku'])) {
            $data['sku'] = 'SKU-' . strtoupper(uniqid());
        }
        return $this->productRepo->create($data);
    }

    public function update(int $id, array $data): Product
    {
        $product = $this->get($id);
        return $this->productRepo->update($product, $data);
    }

    public function delete(int $id): bool
    {
        $product = $this->get($id);
        return $this->productRepo->delete($product);
    }
}
