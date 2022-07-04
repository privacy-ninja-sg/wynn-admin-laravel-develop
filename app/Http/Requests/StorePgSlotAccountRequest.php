<?php

namespace App\Http\Requests;

use App\Models\PgSlotAccount;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePgSlotAccountRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('pg_slot_account_create');
    }

    public function rules()
    {
        return [
            'uuid' => [
                'string',
                'nullable',
            ],
            'username' => [
                'string',
                'nullable',
            ],
            'password' => [
                'string',
                'nullable',
            ],
            'desktop_uri' => [
                'string',
                'nullable',
            ],
            'mobile_uri' => [
                'string',
                'nullable',
            ],
            'game_account_pgslot' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
