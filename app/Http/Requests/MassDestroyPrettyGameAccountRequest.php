<?php

namespace App\Http\Requests;

use App\Models\PrettyGameAccount;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPrettyGameAccountRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('pretty_game_account_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:pretty_game_accounts,id',
        ];
    }
}
