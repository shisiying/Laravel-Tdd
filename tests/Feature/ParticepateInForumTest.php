<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticepateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @author sevenshi
     * @date myformmat
     * @test
     */
    public function unauthenticated_user_may_no_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = create('App\Thread');

        $reply = create('App\Reply');

        $this->post($thread->path().'/replies',$reply->toArray());
    }

    /**
     * @test
     */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        // Given we have a authenticated user
        $this->signIn();

        // And an existing thread
        $thread = create('App\Thread');

        // When the user adds a reply to the thread
        $reply = make('App\Reply');

        $this->post($thread->path().'/replies',$reply->toArray());

        // Then their reply should be visible on the page
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
