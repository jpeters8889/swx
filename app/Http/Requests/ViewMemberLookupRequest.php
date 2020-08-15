<?php

namespace App\Http\Requests;

use App\Models\MemberLookup;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ViewMemberLookupRequest extends FormRequest
{
    protected ?MemberLookup $lookup;

    public function memberLookup(): MemberLookup
    {
        return $this->lookup;
    }

    protected function prepareForValidation()
    {
        $this->lookup = MemberLookup::query()
            ->where('key', $this->route('key'))
            ->where('valid_until', '>', Carbon::now())
            ->first();

        abort_if(!$this->lookup, 404);
    }

    public function rules()
    {
        return [];
    }
}
