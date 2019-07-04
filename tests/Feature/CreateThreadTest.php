<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function an_authenticated_user_can_create_new_forum_thread()
    {
        // Given we have a signed in user
        $this->actingAs(factory('App\User')->create());  // 已登录用户

        // When we hit the endpoint to cteate a new thread
        $thread = factory('App\Thread')->make();
        $this->post('/threads',$thread->toArray());

        // Then,when we visit the thread
        // We should see the new thread
        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /**
     * @test
     */

    public function guests_may_not_create_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = factory('App\Thread')->make();
        $this->post('/threads',$thread->toArray());
    }

}
