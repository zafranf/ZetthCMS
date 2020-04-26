<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Verify extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        /* set variable */
        $from = env('MAIL_USERNAME', 'no-reply@' . env('APP_DOMAIN'));
        $subject = '[' . env('APP_NAME') . '] Verifikasi akun';

        /* set view file */
        $view = getEmailFile($this->data['view']);

        return $this->from($from)
            ->subject($subject)
            ->view($view)
            ->with($this->data);
    }
}
