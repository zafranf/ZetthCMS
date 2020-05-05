<?php

namespace App\Mail;

use App\Models\PasswordReset;
use App\Models\User;
use ZetthCore\Mail\Main as BaseMain;

class ForgotPassword extends BaseMain
{
    public function __construct(User $user, PasswordReset $reset)
    {
        $data = [
            'subject' => '[' . env('APP_NAME') . '] Permintaan ubah sandi',
            'view' => $this->getTemplate() . '.emails.forgot_password',
            'name' => $user->fullname,
            'email' => $user->email,
            'code' => $reset->token,
        ];

        parent::__construct($data);
    }
}
