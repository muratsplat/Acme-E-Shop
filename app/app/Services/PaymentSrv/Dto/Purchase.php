<?php

namespace App\Services\PaymentSrv\Dto;

class Purchase {

    private string $cardNumber;
    private string $cvv;
    private string $cardHolder;
    private float $amount;
    private string $currency;
    private string $exipreDate;

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCardHolder(): string
    {
        return $this->cardHolder;
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
    public function getCardNumber(): string
    {
        return $this->cardNumber;
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
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getCvv(): string
    {
        return $this->cvv;
    }

    /**
     * @param string $cvv
     */
    public function setCvv(string $cvv): void
    {
        $this->cvv = $cvv;
    }

    /**
     * @param string $exipreDate
     */
    public function setExipreDate(string $exipreDate): void
    {
        $this->exipreDate = $exipreDate;
    }

    /**
     * @return string
     */
    public function getExipreDate(): string
    {
        return $this->exipreDate;
    }
}
