<?php

namespace Tests\Unit\App\Repositories\Model;

use App\Repositories\Model\Item;
use App\Rules\CreditCardNumber;
use PHPUnit\Framework\TestCase;

class CreditCardNumberTest extends TestCase
{
    public function testSimple()
    {
        $validator = new CreditCardNumber();
        $this->assertTrue($validator->passes("card_number", "4000056655665556" ));
        $this->assertTrue($validator->passes("card_number", "5555555555554444" ));
        $this->assertTrue($validator->passes("card_number", "2223003122003222" ));
        $this->assertTrue($validator->passes("card_number", "5200828282828210" ));
        $this->assertFalse($validator->passes("card_number", "2222" ));
        $this->assertFalse($validator->passes("card_number", "" ));
    }
}
