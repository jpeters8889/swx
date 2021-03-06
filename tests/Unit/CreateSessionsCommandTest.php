<?php

namespace Tests\Unit;

use App\Models\Group;
use App\Models\Session;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class CreateSessionsCommandTest extends TestCase
{
    use RefreshDatabase;

    protected Session $session;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        TestTime::freeze();
        config(['sw.dont_create' => []]);

        factory(Group::class)->create(['user_id' => factory(User::class)]);
        $this->session = factory(Session::class)->create([
            'group_id' => 1,
            'day_id' => Carbon::now()->dayOfWeek + 1,
            'first_session_date' => Carbon::now(),
            'advance_weeks_to_create' => 2,
        ]);
    }

    /** @test */
    public function it_creates_new_sessions_when_the_command_is_ran()
    {
        // We should have 3 group sessions created from the setup method and the create event.
        // The first being the original setting, and then the 2 from the advance
        $this->assertCount(3, $this->session->groupSessions);

        $this->artisan('sw:create-sessions');
        $this->session->refresh();

        // At this point there should be still 4 because it will have created one for the following week
        $this->assertCount(4, $this->session->groupSessions);

        // If we run it again without advancing a week it shouldn't have added any more
        $this->artisan('sw:create-sessions');
        $this->session->refresh();

        $this->assertCount(4, $this->session->groupSessions);

        // If we fast forward a week, then it should create another group session in 3 weeks
        TestTime::addWeek();

        $this->artisan('sw:create-sessions');
        $this->session->refresh();

        $this->assertCount(5, $this->session->groupSessions);

        $newestSession = $this->session->groupSessions()->latest()->first();

        $this->assertTrue(Carbon::now()->addWeeks(3)->isSameDay($newestSession->date));
    }

    /** @test */
    public function it_doesnt_create_sessions_if_the_Session_isnt_live()
    {
        $this->session->update(['live' => false]);

        $this->assertCount(3, $this->session->groupSessions);

        $this->artisan('sw:create-sessions');
        $this->session->refresh();

        $this->assertCount(3, $this->session->groupSessions);

        TestTime::addWeek();

        $this->artisan('sw:create-sessions');
        $this->session->refresh();

        $this->assertCount(3, $this->session->groupSessions);
    }

    /** @test */
    public function it_doesnt_create_a_session_if_the_date_exists_in_the_config_to_not_create()
    {
        $dontCreate = Carbon::now()->addWeeks(4);
        config(['sw.dont_create' => [$dontCreate->format('d/m')]]);
        TestTime::addWeek();

        $this->assertDatabaseMissing('group_sessions', ['date' => $dontCreate->format('Y-m-d')]);
        $this->assertCount(3, $this->session->groupSessions);

        $this->artisan('sw:create-sessions');
        $this->session->refresh();

        $this->assertCount(3, $this->session->groupSessions);
        $this->assertDatabaseMissing('group_sessions', ['date' => $dontCreate->format('Y-m-d')]);
    }
}
