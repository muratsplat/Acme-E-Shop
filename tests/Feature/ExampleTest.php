<?php

namespace Tests\Feature;

use App\Services\Pagination;
use App\Services\ProductSrv\Dto\Product;
use App\Services\ProductSrv\ProductServiceImpl;
use Database\Factories\BrandFactory;
use Database\Factories\ProductFactory;
use Faker\Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory;
use Illuminate\Support\Collection;
use Mockery\MockInterface;
use Tests\TestCase;
use Mockery;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->instance(
            ProductServiceImpl::class, Mockery::mock(ProductServiceImpl::class, function (MockInterface $mock) {
                $pagination = new Pagination();
                $pagination->setTotal(0);
                $pagination->setPageId(1);
                $pagination->setItems(
                    new Collection(
                        [
                            $this->randomProduct(),
                            $this->randomProduct()
                        ]
                    )
                );
                $mock->shouldReceive('all')
                    ->once()
                    ->with( 1)
                    ->andReturn($pagination);
            })
        );
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    private function randomProduct(): Product {
        $productFaker = new ProductFactory();
        $brandFaker = new BrandFactory();
        $productModel = $productFaker->definition();
        $brandModel = $brandFaker->definition();
        $product = new Product();
        $product->setId($this->faker()->numberBetween(1));
        $product->setPrice($productModel['price']);
        $product->setBrandId($this->faker()->numberBetween(1));
        $product->setBrandName($brandModel['name']);
        $product->setName($this->faker()->name());
        return $product;
    }

    private function faker(): Generator {
        return Factory::create();
    }
}
