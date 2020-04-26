<?php

namespace App\Jobs;

use ZetthCore\Jobs\CommentReply as BaseCommentReply;

class CommentReply extends BaseCommentReply
{
    public function __construct($data)
    {
        parent::__construct($data);
    }
}
