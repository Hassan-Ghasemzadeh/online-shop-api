<?php

namespace Tests\Unit;

use App\Models\Product;
use app\Repositories\ProductRepositoryInterface;
use App\Services\ProductService;
use Mockery;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{

    public function test_create_product_generates_sku_if_missing(): void
    {
        $repo = Mockery::mock(ProductRepositoryInterface::class);
        $repo->shouldReceive('create')->once()->andReturnUsing(function ($data) {
            return new Product($data + ['id' => 1]);
        });
        $service = new ProductService($repo);
        $product = $service->create([
            'category_id' => 1,
            'name' => 'Test product',
            'price' => 10,
        ]);
        $this->assertNotEmpty($product->sku);
        $this->assertEquals('Test product', $product->name);
    }
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
