<?php

namespace Tests\Unit\App\Repositories\Model;

use App\Rules\CreditCardExpiryDate;
use PHPUnit\Framework\TestCase;

class CreditCardExpiryDateTest extends TestCase
{
    public function testSimple()
    {
        $validator = new CreditCardExpiryDate();
//        4000056655665556	Visa (debit)	Any 3 digits
//        5555555555554444	Mastercard	Any 3 digits
//        2223003122003222	Mastercard (2-series)	Any 3 digits
//        5200828282828210	Mastercard (debit)	Any 3 digits
        $this->assertTrue($validator->passes("expireDate", "01-2022" ));
        $this->assertFalse($validator->passes("expireDate", "01-1900" ));
        $this->assertTrue($validator->passes("expireDate", "01-2030" ));
    }
}
