<?php

namespace App\Mail;

use App\Models\Post;
use ZetthCore\Mail\Main as BaseMain;

class NewPost extends BaseMain
{
    public function __construct(Post $post)
    {
        $data = [
            'subject' => '[' . env('APP_NAME') . '] Artikel baru "' . $post->title . '"',
            'view' => $this->getTemplate() . '.emails.new_post',
            'post' => $post,
        ];

        parent::__construct($data);
    }
}
