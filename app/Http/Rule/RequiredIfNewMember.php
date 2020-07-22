<?php

namespace App\Http\Rule;

use App\Models\GroupSession;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class RequiredIfNewMember implements Rule
{
    public function passes($attribute, $value)
    {
        /** @var Request $request */
        $request = resolve(Request::class);

        $isNewMemberSession = GroupSession::query()
            ->firstWhere('id', $request->route('session'))
            ->session
            ->new_member_session;

        return !($isNewMemberSession && !$value);
    }

    public function message()
    {
        return 'You must include your phone number if you are a new member.';
    }
}
