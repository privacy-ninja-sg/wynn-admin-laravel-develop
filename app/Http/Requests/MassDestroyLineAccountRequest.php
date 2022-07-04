<?php

namespace App\Http\Requests;

use App\Models\LineAccount;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyLineAccountRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('line_account_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:line_accounts,id',
        ];
    }
}
