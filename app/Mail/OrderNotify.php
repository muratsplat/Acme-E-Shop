<?php

namespace App\Mail;

use App\Services\OrderSrv\Dto\OrderDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderNotify extends Mailable
{
    use Queueable, SerializesModels;

    public OrderDetail $orderDetail;

    /**
     * Create a new message instance.
     *
     * @param OrderDetail $orderDetail
     */
    public function __construct(OrderDetail $orderDetail)
    {
        $this->orderDetail = $orderDetail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.ordernotify');
    }
}
