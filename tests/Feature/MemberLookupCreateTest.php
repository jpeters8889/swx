<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\Member;
use App\Models\MemberLookup;
use App\Models\Session;
use App\Models\User;
use App\Events\MemberLookupCreated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class MemberLookupCreateTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        Notification::fake();
        $this->setUpFaker();


    }

    /** @test */
    public function it_errors_without_an_email()
    {
        $this->makeRequest('')->assertStatus(422);
    }

    /** @test */
    public function it_errors_with_an_invalid_email()
    {
        $this->makeRequest('foobar')->assertStatus(422);
    }

    /** @test */
    public function it_errors_with_an_email_that_doesnt_exist_in_the_database()
    {
        $this->makeRequest('jamie@foo.com')->assertStatus(422);
    }

    /** @test */
    public function it_returns_ok_with_a_valid_email_that_exists_in_the_database()
    {
        factory(User::class)->create();
        factory(Group::class,)->create(['user_id' => 1]);
        factory(Session::class)->create(['group_id' => 1]);

        factory(Member::class)->create(['email' => 'jamie@jamie-peters.co.uk']);

        $this->makeRequest('jamie@jamie-peters.co.uk')->assertStatus(200);
    }

    /** @test */
    public function it_creates_a_lookup_record_when_a_member_has_bookings()
    {
        factory(User::class)->create();
        factory(Group::class,)->create(['user_id' => 1]);
        factory(Session::class)->create(['group_id' => 1]);

        factory(Member::class)->create(['email' => 'jamie@jamie-peters.co.uk']);

        $this->assertEmpty(MemberLookup::all());

        $this->makeRequest('jamie@jamie-peters.co.uk');

        $this->assertNotEmpty(MemberLookup::all());
    }

    /** @test */
    public function it_dispatches_a_lookup_created_event()
    {
        Event::fake(MemberLookupCreated::class);

        factory(User::class)->create();
        factory(Group::class,)->create(['user_id' => 1]);
        factory(Session::class)->create(['group_id' => 1]);

        factory(Member::class)->create(['email' => 'jamie@jamie-peters.co.uk']);

        $this->makeRequest('jamie@jamie-peters.co.uk');

        Event::assertDispatched(MemberLookupCreated::class);
    }

    /** @test */
    public function it_doesnt_create_a_lookup_record_or_notify_a_member_when_a_member_doesnt_exist()
    {
        Event::fake(MemberLookupCreated::class);
        $this->makeRequest();

        $this->assertEmpty(MemberLookup::all());
        Event::assertNotDispatched(MemberLookupCreated::class);
        Notification::assertNothingSent();
    }

    protected function makeRequest($email = null): TestResponse
    {
        return $this->post('/lookup', [
            'email' => $email ?? $this->faker->email,
        ]);
    }
}
