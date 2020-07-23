<?php

namespace Tests\Unit;

use App\Events\SessionCreated;
use App\Models\Day;
use App\Models\Group;
use App\Models\GroupSession;
use App\Models\Session;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class SessionTest extends TestCase
{
    use RefreshDatabase;

    protected Session $session;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        Event::fake(SessionCreated::class);

        $group = factory(Group::class)->create(['user_id' => factory(User::class)->create()]);
        $this->session = factory(Session::class)->create(['group_id' => $group]);
    }

    /** @test */
    public function it_has_a_day()
    {
        $this->assertInstanceOf(Day::class, $this->session->day);
    }

    /** @test */
    public function it_belongs_to_a_group()
    {
        $this->assertInstanceOf(Group::class, $this->session->group);
    }

    /** @test */
    public function it_can_have_group_sessions()
    {
        $this->assertEmpty($this->session->groupSessions);

        GroupSession::query()->create([
            'group_id' => $this->session->group->id,
            'session_id' => $this->session->id,
            'date' => Carbon::today(),
        ]);

        $this->assertNotEmpty($this->session->fresh()->groupSessions);
    }

    /** @test */
    public function a_session_cant_be_the_same_time_as_another_session_in_the_same_group()
    {
        Session::query()->truncate();

        $sessionParams = [
            'group_id' => 1,
            'start_at' => '10:00',
            'end_at' => '11:00',
            'day_id' => 1,
        ];

        factory(Session::class)->create($sessionParams);

        $this->expectException(QueryException::class);
        factory(Session::class)->create($sessionParams);
    }
}
