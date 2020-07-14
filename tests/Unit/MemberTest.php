<?php

namespace Tests\Unit;

use App\Models\Group;
use App\Models\GroupSession;
use App\Models\Member;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberTest extends TestCase
{
    use RefreshDatabase;

    protected Group $group;
    protected Session $session;
    protected GroupSession $groupSession;
    protected Member $member;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->group = factory(Group::class)->create();
        $this->session = factory(Session::class)->create(['group_id' => $this->group->id]);

        $this->groupSession = GroupSession::query()->create([
            'group_id' => $this->group->id,
            'session_id' => $this->session->id,
            'date' => Carbon::today(),
        ]);

        $this->member = factory(Member::class)->create(['group_session_id' => $this->groupSession->id]);
    }

    /** @test */
    public function it_has_a_group_session()
    {
        $this->assertInstanceOf(GroupSession::class, $this->member->groupSession);
    }
}
