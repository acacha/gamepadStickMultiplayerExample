<?php

namespace Tests\Feature;

use App\Events\ChatMessage;
use App\Events\NewBall;
use App\User;
use Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BallsControllerTest extends TestCase
{
    /** @test */
    public function logged_user_can_add_a_ball()
    {
        Event::fake();

        $logged_user = factory(User::class)->create();

        $response = $this->actingAs($logged_user)->post('/ball');

        $response->assertSuccessful();

        Event::assertDispatched(NewBall::class);

    }
}
