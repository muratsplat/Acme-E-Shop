<?php

namespace App\Services\ProductSrv;

use App\Exceptions\NotFoundException;
use App\Repositories\ProductRepo;
use App\Services\ProductSrv\Contracts\ProductService;
use App\Services\ProductSrv\Dto\Product as ProductDTO;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;

class ProductServiceImpl implements ProductService {

    private ProductRepo $productRepo;
    private int $pageSize;

    public function __construct(ProductRepo $productRepo, Application $app) {
        $this->productRepo = $productRepo;
        $this->pageSize =   intval($app['config']->get("app.pageSize"), 10);
    }

    /**
     * @param int $offset
     * @return \App\Services\Pagination
     */
    public function all($offset = 0) {
        return $this->productRepo->all($offset, $this->pageSize);
    }

    /**
     * Get product model by primaryId
     * @param int $id
     * @return ProductDTO
     * @throws NotFoundException
     */
    public function findById(int $id): ProductDTO {
        return $this->productRepo->findById($id);
    }

    /**
     * Find products by many ids
     * @param Arrayable $ids
     * @return Collection Includes ProductDTO
     */
    public function findMany(Arrayable $ids): Collection
    {
        return $this->productRepo->findManyByIds($ids);
    }
}
