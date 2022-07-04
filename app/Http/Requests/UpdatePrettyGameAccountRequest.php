<?php

namespace App\Http\Requests;

use App\Models\PrettyGameAccount;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePrettyGameAccountRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('pretty_game_account_edit');
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
            'game_account_pretty' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
