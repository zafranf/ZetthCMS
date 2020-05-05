<?php

namespace App\Mail;

use App\Models\User;
use ZetthCore\Mail\Main as BaseMain;

class ResetPassword extends BaseMain
{
    public function __construct(User $user)
    {
        $data = [
            'subject' => '[' . env('APP_NAME') . '] Ubah sandi berhasil!',
            'view' => $this->getTemplate() . '.emails.reset_password',
            'name' => $user->fullname,
            'email' => $user->email,
        ];

        parent::__construct($data);
    }
}
