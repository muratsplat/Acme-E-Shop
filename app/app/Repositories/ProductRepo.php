<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Models\Product as Model;
use App\Services\Pagination;
use App\Services\ProductSrv\Dto\Product as ProductDTO;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class ProductRepo extends Repo {

    private Model $model;

    public function __construct(Model $model) {
        $this->model = $model;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return Pagination
     * @throws NotFoundException
     */
    public function all($offset = 0, $limit = 20): Pagination {
        $lPagination =  $this->model->newQuery()->paginate($limit, ['*'],  'page', $offset);
        if ($lPagination->isEmpty()) {
            throw new NotFoundException("not found", 404);
        }

        $list = (new Collection($lPagination->items()))->map(function(Model $model) {
            return $this->mapProductDTO($model);
        });
        return $this->newPagination($lPagination, $list, $offset, $limit);
    }

    /**
     * Get model by id
     *
     * @param int $id
     * @return ProductDTO
     * @throws NotFoundException
     */
    public function findById(int $id): ProductDTO {
        $model = $this->model->newQuery()->find($id);
        if (is_null($model)) {
            throw new NotFoundException("not found", 404);
        }

        return $this->mapProductDTO($model);
    }

    /**
     * Get model by id
     *
     * @param Arrayable  $ids Product Ids
     * @return Collection includes ProductDTO
     * @throw NotFoundException
     */
    public function findManyByIds(Arrayable $ids): Collection {
        $row = $this->model->newQuery()->findMany($ids);
        if ($row->isEmpty()) {
            throw new NotFoundException("not found", 404);
        }
        return $row->map(function (Model $product){
            return $this->mapProductDTO($product);
        });
    }

    /**
     * Map model to ProductDTO
     *
     * @param Model $model
     * @return ProductDTO
     */
    private function mapProductDTO(Model $model): ProductDTO {
        $dto = new ProductDTO();
        $dto->setId($model->id);
        $dto->setBrandId($model->brand_id);
        $dto->setBrandName($model->brand->name);
        $dto->setName($model->name);
        $dto->setPrice($model->price);
        return $dto;
    }
}
