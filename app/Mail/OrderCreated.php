<?php

namespace App\Mail;

use App\Image as ImageModel;
use App\Order;
use App\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCreated extends Mailable
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
        $products = $this->order->products->map(function (Product $product) {

            $count = (float)$product->pivot->count;
            $price = (float)$product->pivot->price;
            $sum = round($count * $price, 2);


            return [
                'link'  => route('home.product.show', ['slug' => $product->slug], true),
                'name'  => $product->name,
                'count' => $count,
                'price' => $price,
                'sum'   => number_format($sum, 2, ', ', ' ') . ' руб.',
            ];
        })->toArray();

        $status = Order::getStatuses()[ $this->order->status ];

        $detailsUrl = route('order.show', [
            'id'    => $this->order->id,
            'hash'  => md5($this->order->id . ':' . $this->order->email),
            'email' => $this->order->email,
        ]);

        return $this->markdown('emails.orders.created')
            ->with([
                'id'          => $this->order->id,
                'status'      => $status,
                'details_url' => $detailsUrl,
                'full_name'   => $this->order->full_name,
                'phone'       => $this->order->phone,
                'address'     => $this->order->address,
                'comment'     => $this->order->comment,
                'products'    => $products,
                'total'       => number_format($this->order->total, 2, ',', ' ') . ' руб.',
            ])
            ->subject('Новый заказ в интернет-магазине ' . config('app.name'))
            ->to($this->order->email);
    }
}
