<?php

namespace App\Repositories\Contracts;

use App\Exceptions\NotFoundException;
use App\Repositories\Model\Order;
use App\Services\Pagination;

interface OrderPersistentRepo
{

    /**
     * @param int $offset
     * @param int $limit
     * @return Pagination
     * @throws NotFoundException
     */
    public function all($offset = 0, $limit = 20): Pagination
    ;
    /**
     * Get model by id
     *
     * @param int $id
     * @return Order
     * @throws NotFoundException
     */
    public function findById(int $id): Order;

    /**
     * @param Order $order
     * @return bool
     */
    public function store(Order $order): bool;

}
