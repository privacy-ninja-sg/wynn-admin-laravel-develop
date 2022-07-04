<?php

namespace App\Http\Requests;

use App\Models\Channel;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreChannelRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('channel_create');
    }

    public function rules()
    {
        return [
            'uuid' => [
                'string',
                'nullable',
            ],
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
