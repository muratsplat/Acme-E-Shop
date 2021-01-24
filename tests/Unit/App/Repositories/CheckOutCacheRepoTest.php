<?php

namespace Tests\Unit\App\Repositories;

use App\Repositories\CheckOutCacheRepo;
use App\Repositories\PurchaseRepo;
use App\Repositories\Model\Item;
use Illuminate\Cache\ArrayStore;
use Illuminate\Contracts\Cache\Repository;
use PHPUnit\Framework\TestCase;
use Illuminate\Cache\Repository as Repo;

class CheckOutCacheRepoTest extends TestCase
{
    private Repository $cache;

    protected function setUp(): void
    {
       $this->cache = new Repo(new ArrayStore());
    }

    private function newRepo(): CheckOutCacheRepo
    {
        return new CheckOutCacheRepo($this->cache, now()->addMinutes(2));
    }

    public function testPut()
    {
        $repo = $this->newRepo();
        $this->assertTrue($repo->all()->isEmpty());
        $item = new Item();
        $item->setProductId(1);
        $item->setCount(1);
        $repo->put($item);
        $this->assertFalse($repo->all()->isEmpty());
    }

    public function testPutMany()
    {
        $repo = $this->newRepo();
        $this->assertTrue($repo->all()->isEmpty());
        $item = new Item();
        $item->setProductId(1);
        $item->setCount(1);
        // 4
        $repo->put($item);
        $repo->put($item);
        $repo->put($item);
        $repo->put($item);
        $this->assertEquals(
            $repo->all()->sum(function(Item $item){ return $item->getCount();}), 4
        );
    }

    public function testPutManyDiff()
    {
        $repo = $this->newRepo();
        $this->assertTrue($repo->all()->isEmpty());
        $item = new Item();
        $item->setProductId(1);
        $item->setCount(1);
        // 4
        $repo->put($item);
        $repo->put($item);
        $repo->put($item);
        $repo->put($item);

        $this->assertEquals(
            $repo->all()->sum(function(Item $item){ return $item->getCount();}),
            4
        );

        $item2 = new Item();
        $item2->setProductId(2);
        $item2->setCount(1);

        // 2
        $repo->put($item2);
        $repo->put($item2);


        $this->assertEquals(
            $repo->all()
                ->filter(function(Item $item){
                    return $item->getCount() == 2;
                })->sum(function(Item $item){ return $item->getCount();}),
            2
        );
    }

}
