<?php

namespace App\Mail;

use App\Models\Comment;
use App\Models\Post;
use ZetthCore\Mail\Main as BaseMain;

class CommentReply extends BaseMain
{
    public function __construct(Post $post, Comment $comment)
    {
        $data = [
            'subject' => '[' . env('APP_NAME') . '] Balasan komentar artikel "' . $post->title . '"',
            'view' => $this->getTemplate() . '.emails.comment_replied',
            'post' => $post,
            'comment' => $comment,
        ];

        parent::__construct($data);
    }
}
