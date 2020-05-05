<?php

namespace App\Mail;

use App\Models\User;
use ZetthCore\Mail\Main as BaseMain;

class Verify extends BaseMain
{
    public function __construct(User $user)
    {
        $data = [
            'subject' => '[' . env('APP_NAME') . '] Verifikasi akun',
            'view' => $this->getTemplate() . '.emails.verify',
            'name' => $user->fullname,
            'email' => $user->email,
            'code' => $user->verify->code,
        ];

        parent::__construct($data);
    }
}
