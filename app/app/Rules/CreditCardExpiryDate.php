<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CreditCardExpiryDate implements Rule
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
        $segments = explode("-", $value);
        if (count($segments) !== 2) {
            return false;
        }
        list($month, $year) = $segments;
        $now = Carbon::now();
        $expireDate = new Carbon();
        $expireDate->setYear($year);
        $expireDate->setMonth($month);
        $expireDate->setDay(1);
        if ($expireDate->isAfter($now)) {
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
        return 'Card has expired';
    }
}
