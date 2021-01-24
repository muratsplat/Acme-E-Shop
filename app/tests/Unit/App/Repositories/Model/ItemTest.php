<?php

namespace Tests\Unit\App\Repositories\Model;

use App\Repositories\Model\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function testSerialize()
    {
        $item = new Item();
        $item->setProductId(1);
        $item->setCount(33);
        $serialize = $item->serialize();
        $this->assertNotNull($serialize);
        $item2 = new Item();
        $item2->unserialize($serialize);
        $this->assertEquals($item, $item2);
    }
}
