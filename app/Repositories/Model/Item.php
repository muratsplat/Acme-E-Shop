<?php

namespace App\Repositories\Model;

use Serializable;

class Item implements Serializable
{
    private int $productId;
    private int $count;

    /**
     * @param int $productId
     */
    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    public function serialize()
    {
        $arr = get_object_vars($this);
        return json_encode($arr);
    }

    public function unserialize($serialized)
    {
        if (is_null($serialized)) {
            throw new \RuntimeException("given param couldn't deserialized!");
        }
        $arr = json_decode($serialized, true);
        $this->setProductId($arr['productId']);
        $this->setCount($arr['count']);
    }
}
