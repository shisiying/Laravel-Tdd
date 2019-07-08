<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavoritiesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function an_authedticated_user_can_favorite_any_reply()
    {
        $this->signIn();
        //post a favorite endpoint
        $reply = create('App\Reply');

        $this->post('/replies/'.$reply->id.'/favorites');
        //it should be recoreded in the database
        $this->assertCount(1,$reply->favorites);
    }

    /**
     * @test
     */
    public function guests_can_not_favorite_anything()
    {
        $this->withExceptionHandling()->post('replies/1/favorites')->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();

        $reply = create('App\Reply');

        try {
            $this->post('replies/'.$reply->id.'/favorites');
            $this->post('replies/'.$reply->id.'/favorites');
        }catch (\Exception $e) {
            $this->fail('did not expect to inssert the same record set twice');
        }

        $this->assertCount(1,$reply->favorites);
    }

}
