<?php

namespace App\Http\Requests;

use App\Models\GameAccount;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyGameAccountRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('game_account_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:game_accounts,id',
        ];
    }
}
