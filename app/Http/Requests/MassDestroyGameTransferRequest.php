<?php

namespace App\Http\Requests;

use App\Models\GameTransfer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyGameTransferRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('game_transfer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:game_transfers,id',
        ];
    }
}
