<?php

namespace App\Repositories;

use App\Repositories\Contracts\CheckOutRepo;
use App\Repositories\Model\Item;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;
use DateTimeInterface;
use Psr\SimpleCache\InvalidArgumentException;

class CheckOutCacheRepo implements CheckOutRepo
{
    const PREFIX = "repository.checkout";
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
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->getCollection();
    }

    /**
     * Put item into cache
     *
     * @param Item $item
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function put(Item $item): void
    {
        $key = $this->key();
        $collectionKey = "{$item->getProductId()}";
        $collection = $this->getCollection();
        $found = $collection->get($collectionKey);

        if (is_null($found)) {
            $collection->put($collectionKey, $item, $this->expire);
            $this->putOnCache($key, $collection);
            return;
        }
        $found->setCount( $found->getCount() + 1);
        $collection->put($collectionKey, $found, $this->expire);
        $this->putOnCache($key, $collection);
    }

    /**
     * @param string $key
     * @param Collection $collection
     */
    private function putOnCache(string $key, Collection $collection) {
        $this->cache->put($key, $collection, $this->expire);
    }

    /**
     * @param string $key
     * @return Collection|null
     */
    private function getOnCache(string $key):Collection|null
    {
        try {
            return $this->cache->get($key, null);
        } catch (InvalidArgumentException $ex) {
            throw new \RuntimeException("key is malformed", 500);
        }
    }

    /**
     * Get the collection
     * @return Collection
     */
    private function getCollection(): Collection
    {
        /**
         * @var $result Collection|null
         */
        $result = $this->getOnCache($this->key(), null);
        if (is_null($result)) {
            return new Collection([]);
        }
        return $result;
    }

    private function key(): string
    {
        return self::PREFIX;
    }

    /**
     * Clear cache
     */
    public function clear(): void
    {
        try {
            $this->cache->delete($this->key());
        } catch (InvalidArgumentException $ex) {
            throw new \RuntimeException("key is malformed", 500);
        }
    }
}
