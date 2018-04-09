<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegistered extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var User
     */
    private $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fullName = trim(implode(' ', [
            $this->user->surname,
            $this->user->name,
            $this->user->patronymic,
        ]));

        $hash = md5($this->user->id . ':' . $this->user->email);
        $profileUrl = route('profile.index', ['email' => $this->user->email, 'hash' => $hash]);

        return $this->markdown('emails.auth.registered')
            ->with([
                'full_name'   => $fullName,
                'profile_url' => $profileUrl,
            ])
            ->to($this->user->email)
            ->subject('Регистрация в интернет-магазине' . config('app.name'));
    }
}
