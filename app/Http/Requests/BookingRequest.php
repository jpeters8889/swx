<?php

namespace App\Http\Requests;

use App\Models\GroupSession;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookingRequest extends FormRequest
{
    public function groupSession(): GroupSession
    {
        return GroupSession::query()->firstWhere('id', $this->route('session'));
    }

    protected function passedValidation()
    {
        abort_if(!$this->groupSession()->session->live, 422);
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => ['required', 'email'],
            'phone' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $jsonResponse = response()->json(['errors' => $validator->errors()], 422);

        throw new HttpResponseException($jsonResponse);
    }
}
