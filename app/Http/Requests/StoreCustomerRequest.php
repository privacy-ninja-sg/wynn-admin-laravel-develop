<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('customer_create');
    }

    public function rules()
    {
        return [
            'uuid' => [
                'string',
                'nullable',
            ],
            'tel' => [
                'string',
                'nullable',
            ],
            'picture' => [
                'string',
                'nullable',
            ],
            'username' => [
                'string',
                'required',
            ],
            'password' => [
                'string',
                'nullable',
            ],
            'channel_user' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
