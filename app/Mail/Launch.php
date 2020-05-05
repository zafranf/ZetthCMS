<?php

namespace App\Mail;

use ZetthCore\Mail\Main as BaseMain;

class Launch extends BaseMain
{
    public function __construct()
    {
        $data = [
            'subject' => '[' . env('APP_NAME') . '] Situs sudah aktif!',
            'view' => $this->getTemplate() . '.emails.launch',
        ];

        parent::__construct($data);
    }
}
