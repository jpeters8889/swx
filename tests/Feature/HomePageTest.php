<?php

namespace Tests\Feature;

use App\Events\SessionCreated;
use App\Models\Group;
use App\Models\Session;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    protected Group $firstGroup;
    protected Group $secondGroup;

    protected function setUp(): void
    {
        parent::setUp();
        Event::fake(SessionCreated::class);

        $user = factory(User::class)->create();

        $this->firstGroup = factory(Group::class)->create(['user_id' => $user]);
        $this->secondGroup = factory(Group::class)->create(['user_id' => $user]);

        factory(Session::class)->create(['group_id' => 1, 'day_id' => 4, 'start_at' => '17:00']);
        factory(Session::class)->create(['group_id' => 1, 'day_id' => 2, 'start_at' => '09:30']);
        factory(Session::class)->create(['group_id' => 2, 'day_id' => 2, 'start_at' => '11:00']);
        factory(Session::class)->create(['group_id' => 2, 'day_id' => 6, 'start_at' => '11:00']);
    }

    /** @test */
    public function it_loads_the_page()
    {
        $this->get('/')->assertStatus(200);
    }

    /** @test */
    public function it_shows_the_group_title()
    {
        $this->get('/')
            ->assertSee($this->firstGroup->name)
            ->assertSee($this->secondGroup->name);
    }

    /** @test */
    public function it_shows_the_group_owner()
    {
        $this->get('/')
            ->assertSee($this->firstGroup->user->first_name)
            ->assertSee($this->secondGroup->user->first_name);
    }

    /** @test */
    public function it_shows_the_group_days()
    {
        $request = $this->get('/');

        $this->firstGroup->sessions->each(static function(Session $session) use ($request) {
           $request->assertSee($session->day->day);
        });

        $this->secondGroup->sessions->each(static function(Session $session) use ($request) {
            $request->assertSee($session->day->day);
        });
    }

    /** @test */
    public function it_has_the_group_times()
    {
        $request = $this->get('/');

        $this->firstGroup->sessions->each(static function(Session $session) use ($request) {
            $request->assertSee($session->human_start_time);
        });

        $this->secondGroup->sessions->each(static function(Session $session) use ($request) {
            $request->assertSee($session->human_starttime);
        });
    }
}
