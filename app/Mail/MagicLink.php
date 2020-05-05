<?php

namespace App\Mail;

use App\Models\User;
use ZetthCore\Mail\Main as BaseMain;

class MagicLink extends BaseMain
{
    public function __construct(User $user)
    {
        $data = [
            'subject' => '[' . env('APP_NAME') . '] Tautan pintas',
            'view' => $this->getTemplate() . '.emails.magiclink',
            'name' => $user->fullname,
            'email' => $user->email,
            'code' => $user->verify->code,
        ];

        parent::__construct($data);
    }
}
