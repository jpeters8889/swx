<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Models\MemberBooking;
use App\Models\MembersOld;
use Illuminate\Console\Command;

class ConvertMembersFromLegacy extends Command
{
    protected $signature = 'sw:convert-legacy-members';

    public function handle()
    {
        if(!$this->confirm('Are you sure you want to convert legacy members?')) {
            return;
        }

        MembersOld::query()->get()->each(static function (MembersOld $oldMember) {
            $member = Member::query()
                ->firstOrCreate(
                    $oldMember->only(['name', 'email', 'phone'],
                        $oldMember->only(['created_at', 'updated_at'])
                    )
                );

            MemberBooking::query()->create([
                'member_id' => $member->id,
                'group_session_id' => $oldMember->group_session_id,
                'created_at' => $oldMember->created_at,
                'updated_at' => $oldMember->updated_at,
            ]);
        });
    }
}
