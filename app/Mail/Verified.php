<?php

namespace App\Mail;

use App\Models\User;
use ZetthCore\Mail\Main as BaseMain;

class Verified extends BaseMain
{
    public function __construct(User $user)
    {
        $data = [
            'subject' => '[' . env('APP_NAME') . '] Verifikasi berhasil!',
            'view' => $this->getTemplate() . '.emails.verified',
            'name' => $user->fullname,
            'email' => $user->email,
        ];

        parent::__construct($data);
    }
}
