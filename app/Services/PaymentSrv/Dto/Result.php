<?php


namespace App\Services\PaymentSrv\Dto;


class Result {

    private int $status;
    private string $message;
    private string $authcode;
    private string $reference;

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }
    /**
     * @param string $authcode
     */
    public function setAuthcode(string $authcode): void
    {
        $this->authcode = $authcode;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Determine if it is success
     * @return bool
     */
    public function isSuccess(): bool
    {
        if ($this->status === 200) {
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getAuthcode(): string
    {
        return $this->authcode;
    }

    /**
     * @param string $reference
     */
    public function setReference(string $reference): void
    {
        $this->reference = $reference;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }
}
