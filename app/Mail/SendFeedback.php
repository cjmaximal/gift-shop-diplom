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
    private $email;
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
     * @param string $email
     * @param string $name
     * @param string $message
     */
    public function __construct(string $email, string $name, string $message)
    {
        $this->email = $email;
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
                'email'   => $this->email,
                'name'    => $this->name,
                'message' => $this->message,
            ])
            ->subject('Обратная свзяь')
            ->to('feedback@gift-shop.xyz');
    }
}
