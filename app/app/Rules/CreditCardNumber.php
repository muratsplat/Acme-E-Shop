<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Omnipay\Common\Helper;

class CreditCardNumber implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (Helper::validateLuhn($value)) {
            if (!is_null($value) && !preg_match('/^\d{12,19}$/i', $value)) {
               return false;
            }
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Card number should have 12 to 19 digits.';
    }
}
