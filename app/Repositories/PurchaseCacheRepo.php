<?php

namespace App\Repositories;

use App\Repositories\Contracts\PurchaseRepo;
use App\Repositories\Model\OrderShipping;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;
use DateTimeInterface;
use Psr\SimpleCache\InvalidArgumentException;

class PurchaseCacheRepo implements PurchaseRepo
{
    const PREFIX = "repository.purchase";
    private Repository $cache;
    private DateTimeInterface $expire;

    /**
     * CheckOutRepo constructor.
     * @param Repository $repository
     * @param DateTimeInterface $expire
     */
    public function __construct(Repository $repository, DateTimeInterface $expire)
    {
        $this->expire = $expire;
        $this->cache = $repository;
    }

    /**
     * Put item into cache
     *
     * @param OrderShipping $purchase
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function put(OrderShipping $purchase): void
    {
        $key = $this->key();
        $this->putOnCache($key, $purchase);
    }

    /**
     * get item
     *
     * @return OrderShipping|null
     */
    public function get(): OrderShipping|null
    {
        $key = $this->key();
        return $this->getOnCache($key);
    }

    /**
     * @param string $key
     * @param OrderShipping $purchase
     */
    private function putOnCache(string $key, OrderShipping $purchase) {
        $this->cache->put($key, $purchase, $this->expire);
    }

    /**
     * @param string $key
     * @return Collection|null
     */
    private function getOnCache(string $key):OrderShipping|null
    {
        try {
            return $this->cache->get($key, null);
        } catch (InvalidArgumentException $ex) {
            throw new \RuntimeException("key is malformed", 500);
        }
    }

    private function key(): string
    {
        return self::PREFIX;
    }
}
