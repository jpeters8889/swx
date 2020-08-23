<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\GroupSession;
use App\Models\Member;
use App\Models\MemberBooking;
use App\Models\MembersOld;
use App\Models\Session;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConvertMembersCommandTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        factory(User::class)->create();

        factory(Group::class, 5)->create(['user_id' => 1]);

        Group::query()->each(static function (Group $group, $index) {
            factory(Session::class)->create([
                'group_id' => $group->id,
                'day_id' => $index + 1,
                'start_at' => "1" . $index . ":00",
                'end_at' => "1" . ($index + 1) . ":00",
            ]);
        });
    }

    /** @test */
    public function it_moves_a_member_from_the_old_table_to_the_new_tables()
    {
        $oldMember = factory(MembersOld::class)->create([
           'group_session_id' => 1,
           'name' => 'Jamie',
           'email' => 'jamie@jamie-peters.co.uk',
           'phone' => '123456',
        ]);

        $this->assertEmpty(Member::all());
        $this->assertEmpty(MemberBooking::all());

        $this->artisan('sw:convert-legacy-members')
            ->expectsConfirmation('Are you sure you want to convert legacy members?', 'yes');

        $this->assertNotEmpty(Member::all());
        $this->assertNotEmpty(MemberBooking::all());

        $newMember = Member::query()->first();

        foreach(['name', 'email', 'phone'] as $item) {
            $this->assertEquals($oldMember->$item, $newMember->$item);
        }

        $this->assertNotEmpty($newMember->bookings);
        $this->assertEquals($oldMember->group_session_id, $newMember->bookings[0]->group_session_id);
    }

    /** @test */
    public function it_doesnt_create_multiple_records_for_the_same_member()
    {
        factory(MembersOld::class)->create([
            'group_session_id' => 1,
            'name' => 'Jamie',
            'email' => 'jamie@jamie-peters.co.uk',
            'phone' => '123456',
        ]);

        factory(MembersOld::class)->create([
            'group_session_id' => 2,
            'name' => 'Jamie',
            'email' => 'jamie@jamie-peters.co.uk',
            'phone' => '123456',
        ]);

        $this->artisan('sw:convert-legacy-members')
            ->expectsConfirmation('Are you sure you want to convert legacy members?', 'yes');

        $this->assertCount(1, Member::all());
        $this->assertCount(2, MemberBooking::all());
        $this->assertCount(2, Member::query()->first()->bookings);
    }
}
