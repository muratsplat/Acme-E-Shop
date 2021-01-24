<?php


namespace App\Services\ProductSrv\Contracts;


use App\Exceptions\NotFoundException;
use App\Services\ProductSrv\Dto\Product as ProductDTO;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

interface ProductService
{
    /**
     * @param int $offset
     * @return \App\Services\Pagination
     */
    public function all($offset = 0);
    /**
     * Get product model by primaryId
     * @param int $id
     * @return ProductDTO
     * @throws NotFoundException
     */
    public function findById(int $id): ProductDTO;

    /**
     * Find products by many ids
     * @param Arrayable $ids
     * @return Collection
     */
    public function findMany(Arrayable $ids): Collection;
}
