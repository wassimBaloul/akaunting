<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class UserInvitationMail extends Mailable
{
    public $token;

    /**
     * Create a new message instance.
     *
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Invitation to Register')
                    ->view('emails.invitation')
                    ->with([
                        'url' => url("/auth/register/{$this->token}"),
                    ]);
    }
}
