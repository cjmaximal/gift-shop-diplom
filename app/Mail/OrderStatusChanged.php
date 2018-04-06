<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderStatusChanged extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Order
     */
    private $order;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $status = Order::getStatuses()[ $this->order->status ];
        $detailsUrl = route('order.show', [
            'id'    => $this->order->id,
            'hash'  => md5($this->order->id . ':' . $this->order->email),
            'email' => $this->order->email,
        ]);

        return $this->markdown('emails.orders.status_changed')
            ->with([
                'id'          => $this->order->id,
                'status'      => $status,
                'details_url' => $detailsUrl,
                'full_name'   => $this->order->full_name,
            ])
            ->subject('Изменение статуса заказа #' . $this->order->id . ' в интернет-магазине ' . config('app.name'))
            ->to($this->order->email);
    }
}
