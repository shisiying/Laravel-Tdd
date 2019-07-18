<?php

namespace App\Http\Controllers\Api;

use App\Transformers\Threadsformer;
use Illuminate\Http\Request;
use App\Thread;

class ThreadsController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'
        ]);
        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body')
        ]);

        return $this->response->item($thread, new Threadsformer())->setStatusCode(201);
    }
}
