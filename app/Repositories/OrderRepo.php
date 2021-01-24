<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Models\Order as Model;
use App\Repositories\Contracts\OrderPersistentRepo;
use App\Repositories\Model\Order;
use App\Services\Pagination;
use Illuminate\Support\Collection;

class OrderRepo extends Repo implements OrderPersistentRepo
{

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
        $lPagination = $this->model->newQuery()->paginate($limit, ['*'],  'page', $offset);
        if ($lPagination->isEmpty()) {
            throw new NotFoundException("not found", 404);
        }

        $list = (new Collection($lPagination->items()))->map(function(Model $model) {
            return $this->mapDTO($model);
        });

        return $this->newPagination($lPagination, $list, $offset, $limit);
    }

    /**
     * Get model by id
     *
     * @param int $id
     * @return Order
     * @throws NotFoundException
     */
    public function findById(int $id): Order {
        $model = $this->model->newQuery()->find($id);
        if (is_null($model)) {
            throw new NotFoundException("not found", 404);
        }
        return $this->mapDTO($model);
    }

    /**
     * Map model to ProductDTO
     *
     * @param Model $model
     * @return Order
     */
    private function map(Model $model): Order {
        $dto = new Order();
        $dto->setId($model->id);
        $dto->setTotalProductValue($model->total_product_value);
        $dto->setTotalShippingValue($model->total_shipping_value);
        $dto->setClientName($model->client_name);
        $dto->setClientAddress($model->client_address);
        return $dto;
    }

    /**
     * @param Order $order
     * @return bool
     */
    public function store(Order $order): bool
    {
        return $this->model->newInstance(
            [
                "total_product_value" => $order->getTotalProductValue(),
                "total_shipping_value" => $order->getTotalShippingValue(),
                "client_name" => $order->getClientName(),
                "client_address" => $order->getClientAddress(),
            ]
        )->save();
    }
}
