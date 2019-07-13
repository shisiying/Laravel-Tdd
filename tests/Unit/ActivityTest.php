<?php

namespace Tests\Unit;

use App\Activity;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */

    public function it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities',[
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread'
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id,$thread->id);
    }

    /**
     * @test
     */
    public function it_records_activeity_when_a_reply_is_created()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->assertEquals(2,Activity::count());
    }

    /**
     * @test
     */
    public function it_fetches_a_feed_for_any_user()
    {
        $this->signIn();

        // Given we have a thread
        // And another thread from a week ago
        create('App\Thread',['user_id' => auth()->id()],2);

        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        // When we fetch their feed
        $feed = Activity::feed(auth()->user());

        // Then,it should be returned in the proper format.
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));

    }

    /**
     * @test
     */
    public function authorized_users_can_delete_threads()
    {
        $this->signIn();

        $thread = create('App\Thread',['user_id' => auth()->id()]);
        $reply = create('App\Reply',['thread_id' => $thread->id]);

        $response =  $this->json('DELETE',$thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads',['id' => $thread->id]);
        $this->assertDatabaseMissing('replies',['id' => $reply->id]);

        $this->assertEquals(0,Activity::count());
    }
}
