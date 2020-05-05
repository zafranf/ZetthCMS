<?php

namespace App\Mail;

use ZetthCore\Mail\Main as BaseMain;

class ContactForm extends BaseMain
{
    public function __construct($input)
    {
        $data = [
            'subject' => '[' . env('APP_NAME') . '] Pesan masuk dari ' . $input['name'] . ' (' . $input['email'] . ')',
            'view' => $this->getTemplate() . '.emails.contact_form',
            'title' => $input['subject'],
        ];
        unset($input['subject']);
        $data = array_merge($data, $input);

        parent::__construct($data);
    }
}
