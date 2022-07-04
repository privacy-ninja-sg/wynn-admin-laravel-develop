<?php

namespace App\Http\Requests;

use App\Models\Bank;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBankRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('bank_create');
    }

    public function rules()
    {
        return [
            'uuid' => [
                'string',
                'nullable',
            ],
            'name' => [
                'string',
                'nullable',
            ],
            'short_name' => [
                'string',
                'nullable',
            ],
            'logo' => [
                'string',
                'nullable',
            ],
            'bank_id' => [
                'nullable',
                'integer',
            ],
            'name_th' => [
                'string',
                'nullable',
            ],
            'short_name_th' => [
                'string',
                'nullable',
            ],
            'bank_account_name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
