<?php

namespace App\Transformers;

use App\Thread;
use League\Fractal\TransformerAbstract;

class Threadsformer extends TransformerAbstract
{
    public function transform(Thread $thread)
    {
        return [
            'user_id' => $thread->user_id,
            'channel_id' => $thread->channel_id,
            'title' => $thread->title,
            'body' => $thread->body
        ];
    }
}