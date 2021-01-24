<?php

namespace App\Services\CheckOutSrv;

use App\Exceptions\CheckOutLogicException;
use App\Repositories\Contracts\CheckOutRepo;
use App\Repositories\Contracts\PurchaseRepo;
use App\Repositories\Model\Item;
use App\Services\CheckOutSrv\Contracts\CheckoutService;
use App\Services\CheckOutSrv\Dto\CheckOutItem;
use App\Services\CheckOutSrv\Dto\CheckOutPage;
use App\Services\CheckOutSrv\Dto\CheckOutItemWithPrice;
use App\Services\ProductSrv\Dto\Product;
use App\Services\ProductSrv\ProductServiceImpl;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Psr\SimpleCache\InvalidArgumentException;

class CheckoutServiceImpl implements CheckoutService
{
    private CheckOutRepo $repo;
    private ProductServiceImpl $productService;

    public function __construct(CheckOutRepo $repo, ProductServiceImpl $productService)
    {
        $this->repo = $repo;
        $this->productService = $productService;
    }

    /**
     * @param CheckOutItem $item
     */
    public function addItem(CheckOutItem $item): void
    {
        $model = new Item();
        $model->setCount($item->getCount());
        $model->setProductId($item->getProductId());
        $this->repo->put($model);
    }

    /**
     *
     * @return Collection it includes CheckOutItem objects
     */
    public function all(): Collection
    {
        return $this->repo->all()->map(function(Item $item){
            $dto = new CheckOutItem();
            $dto->setCount($item->getCount());
            $dto->setProductId($item->getProductId());
            return $dto;
        });
    }

    /**
     * It represents a model describes listed items with total prices
     *
     * @return CheckOutPage
     */
    public function getPage(): CheckOutPage
    {
        $page = new CheckOutPage();
        $items = $this->allOfItem();
        $page->setItems($items);
        if ($items->isEmpty()) {
            $page->setTotalProductValue(0.0);
            return $page;
        }

        $total = $items->sum(function (CheckOutItemWithPrice $item){
            return $item->getTotalPrice();
        });
        $page->setTotalProductValue($total);
        return $page;
    }

    /**
     * @return Collection includes CheckOutItemWithPrice item in
     */
    public function allOfItem(): Collection
    {
        $item = $this->all();
        if ($item->isEmpty()) {
            return new Collection();
        }
        $ids = $item->map(function (CheckOutItem $item){
            return $item->getProductId();
        });
        $products = $this->getProducts($ids);
        return $this->all()->map(function(CheckOutItem $item) use($products)  {
            /**
             * @var $product Product
             */
            $product = $products->filter(function (Product $product) use($item) {
                return $item->getProductId() === $product->getId();
            })->first();
            if (is_null($product)) {
                throw new CheckOutLogicException("regarding product couldn't found in database!");
            }
            return $this->mapToCheckOutItemWithPrice($product, $item);
        });
    }

    /**
     * Map to CheckOutItemWithPrice
     *
     * @param Product $product
     * @param CheckOutItem $item
     * @return CheckOutItemWithPrice
     */
    private function mapToCheckOutItemWithPrice(Product $product, CheckOutItem $item): CheckOutItemWithPrice
    {
        $dto = new CheckOutItemWithPrice();
        $dto->setCount($item->getCount());
        $dto->setProductId($item->getProductId());
        $dto->setName($product->getName());
        $dto->setBrandName($product->getBrandName());
        $dto->setPrice($product->getPrice());
        $dto->setTotalPrice($product->getPrice() * floatval($item->getCount()));
        return $dto;
    }

    /**
     * @param Arrayable $productIds
     * @return Collection
     */
    private function getProducts(Arrayable $productIds): Collection
    {
        return $this->productService->findMany($productIds);
    }

    /**
     * Clear Checkout data
     */
    public function clear(): void
    {
        $this->repo->clear();
    }
}
