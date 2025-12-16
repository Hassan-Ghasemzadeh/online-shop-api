<?php

namespace Tests\Unit;

use App\Models\Category;
use app\Repositories\CategoryRepositoryInterface;
use App\Services\CategoryService;
use Mockery;
use PHPUnit\Framework\TestCase;

class CategoryServiceTest extends TestCase
{
    protected $repo;
    protected $service;
    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = Mockery::mock(CategoryRepositoryInterface::class);
        $this->service = new CategoryService($this->repo);
    }

    public function test_create_category(): void
    {
        $this->repo->shouldReceive('create')->once()->andReturnUsing(function ($data) {
            return new Category($data + ['id' => 1]);
        });

        $category = $this->service->create([
            'name' => "Electric",
            "slug" => "gaming-laptops",
            "description" => "gaming-laptops computer 128 GB ram and 64 GB graphic card",
        ]);
        $this->assertEquals("gaming-laptops", $category->slug);
    }
}
