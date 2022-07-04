<?php

namespace App\Http\Requests;

use App\Models\LineAccount;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateLineAccountRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('line_account_edit');
    }

    public function rules()
    {
        return [
            'uuid' => [
                'string',
                'nullable',
            ],
            'line' => [
                'string',
                'nullable',
            ],
            'line_client' => [
                'string',
                'nullable',
            ],
            'user_line' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
