<?php

namespace Tests\Unit;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function it_has_groups(): void
    {
        $this->assertEmpty($this->user->groups);

        factory(Group::class, 3)->create(['user_id' => $this->user->id]);

        $this->assertCount(3, $this->user->fresh()->groups);
    }

    /** @test */
    public function it_returns_the_first_name()
    {
        $this->user->update(['name' => 'Jamie Peters']);
        $this->assertEquals('Jamie', $this->user->first_name);

        $this->user->update(['name' => 'Jamie Foobar Peters']);
        $this->assertEquals('Jamie', $this->user->first_name);
    }
}
