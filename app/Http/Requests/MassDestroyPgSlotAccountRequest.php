<?php

namespace App\Http\Requests;

use App\Models\PgSlotAccount;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPgSlotAccountRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('pg_slot_account_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:pg_slot_accounts,id',
        ];
    }
}
