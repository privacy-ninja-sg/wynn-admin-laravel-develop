<?php

namespace App\Http\Requests;

use App\Models\GameTransfer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreGameTransferRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('game_transfer_create');
    }

    public function rules()
    {
        return [
            'game' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'transfer_transaction' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
