<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendFeedback extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $message;

    /**
     * Create a new message instance.
     *
     * @param string $to
     * @param string $name
     * @param string $message
     */
    public function __construct(string $to, string $name, string $message)
    {
        $this->to = $to;
        $this->name = $name;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.feedback')
            ->with([
                'to'      => $this->to,
                'name'    => $this->name,
                'message' => $this->message,
            ])
            ->subject('Обратная свзяь')
            ->to('feedback@gift-shop.xyz');
    }
}
