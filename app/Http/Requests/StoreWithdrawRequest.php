<?php

namespace App\Http\Requests;

use App\Models\Withdraw;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreWithdrawRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('withdraw_create');
    }

    public function rules()
    {
        return [
            'uuid' => [
                'string',
                'nullable',
            ],
            'debit' => [
                'numeric',
                'required',
            ],
            'credit' => [
                'numeric',
                'required',
            ],
            'balance' => [
                'numeric',
                'required',
            ],
            'remark' => [
                'string',
                'nullable',
            ],
            'txn_type' => [
                'string',
                'required',
            ],
            'status' => [
                'required',
            ],
            'user_wallet' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
