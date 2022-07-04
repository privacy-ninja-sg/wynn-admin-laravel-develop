<?php

namespace App\Http\Requests;

use App\Models\Withdraw;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateWithdrawRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('withdraw_edit');
    }

    public function rules()
    {
        return [
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
