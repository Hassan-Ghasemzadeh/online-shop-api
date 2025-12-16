<?php

namespace Tests\Unit;

use App\Models\Product;
use app\Repositories\ProductRepositoryInterface;
use App\Services\ProductService;
use Mockery;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    protected $repo;
    protected $service;
    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = Mockery::mock(ProductRepositoryInterface::class);
        $this->service = new ProductService($this->repo);
    }

    public function test_create_product_generates_sku_if_missing(): void
    {
        $this->repo->shouldReceive('create')->once()->andReturnUsing(function ($data) {
            return new Product($data + ['id' => 1]);
        });
        $product = $this->service->create([
            'category_id' => 1,
            'name' => 'Test product',
            'price' => 10,
        ]);
        $this->assertNotEmpty($product->sku);
        $this->assertEquals('Test product', $product->name);
    }
    public function test_get_product(): void
    {
        $mockProduct = new Product([
            'id' => 1,
            'category_id' => 1,
            'name' => 'Test product',
            'price' => 10,
        ]);
        $this->repo->shouldReceive('find')->once()->with(1)->andReturn($mockProduct);
        $product = $this->service->get(1);
        $this->assertEquals('Test product', $product->name);
    }
    public function test_update_product(): void
    {
        $productId = 1;
        $existingProduct = new Product([
            'id' => $productId,
            'name' => 'Old Name',
            'price' => 10
        ]);

        $updateData = [
            'name' => 'Updated Test product',
            'price' => 1000,
        ];
        $this->repo->shouldReceive('find')
            ->once()
            ->with($productId)
            ->andReturn($existingProduct);

        $this->repo->shouldReceive('update')
            ->once()
            ->with($existingProduct, $updateData)
            ->andReturnUsing(function ($product, $data) {
                $product->fill($data);
                return $product;
            });
        $product = $this->service->update($productId, $updateData);
        $this->assertEquals(1000, $product->price);
        $this->assertEquals('Updated Test product', $product->name);
    }
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
