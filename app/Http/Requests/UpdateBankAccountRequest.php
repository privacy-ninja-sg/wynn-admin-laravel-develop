<?php

namespace App\Http\Requests;

use App\Models\BankAccount;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBankAccountRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('bank_account_edit');
    }

    public function rules()
    {
        return [
            'uuid' => [
                'string',
                'nullable',
            ],
            'bank_account' => [
                'string',
                'nullable',
            ],
            'bank_account_id_last' => [
                'string',
                'nullable',
            ],
            'bank_account_name' => [
                'string',
                'nullable',
            ],
            'bank_accounts' => [
                'nullable',
                'integer',
            ],
            'user_banks' => [
                'nullable',
                'integer',
            ],
            'bank_code' => [
                'string',
                'nullable',
            ],
        ];
    }
}
