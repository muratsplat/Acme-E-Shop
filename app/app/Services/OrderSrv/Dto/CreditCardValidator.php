<?php


namespace App\Services\OrderSrv\Dto;

use App\Exceptions\CreditCardValidationException;
use Illuminate\Validation\ValidationException;
use Omnipay\Common\CreditCard;
use Omnipay\Common\Exception\InvalidCreditCardException;

class CreditCardValidator
{
    private string $cardNumber;
    private string $cvv;
    private string $cardHolder;
    private string $expireDate;

    /**
     * @param string $cvv
     */
    public function setCvv(string $cvv): void
    {
        $this->cvv = $cvv;
    }

    /**
     * @return string
     */
    public function getCvv(): string
    {
        return $this->cvv;
    }

    /**
     * @param string $cardNumber
     */
    public function setCardNumber(string $cardNumber): void
    {
        $this->cardNumber = $cardNumber;
    }

    /**
     * @return string
     */
    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    /**
     * @param string $cardHolder
     */
    public function setCardHolder(string $cardHolder): void
    {
        $this->cardHolder = $cardHolder;
    }

    /**
     * @return string
     */
    public function getCardHolder(): string
    {
        return $this->cardHolder;
    }

    /**
     * @return string m-Y format example: 12-2034
     */
    public function getExpireDate(): string
    {
        return $this->expireDate;
    }

    /**
     * @param string $expireDate string m-Y format example: 12-2034
     */
    public function setExpireDate(string $expireDate): void
    {
        $this->expireDate = $expireDate;
    }
}
