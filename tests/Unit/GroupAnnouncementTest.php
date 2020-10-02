<?php

namespace Tests\Unit;

use App\Events\SessionCreated;
use App\Models\Group;
use App\Models\GroupAnnouncement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class GroupAnnouncementTest extends TestCase
{
    use RefreshDatabase;

    protected Group $group;
    protected GroupAnnouncement $groupAnnouncement;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        Event::fake(SessionCreated::class);

        $this->group = factory(Group::class)->create(['user_id' => factory(User::class)->create()]);
        $this->groupAnnouncement = factory(GroupAnnouncement::class)->create(['group_id' => 1]);
    }

    /** @test */
    public function it_belongs_to_a_group()
    {
        $this->assertInstanceOf(Group::class, $this->groupAnnouncement->group);
        $this->assertTrue($this->group->is($this->groupAnnouncement->group));
    }
}