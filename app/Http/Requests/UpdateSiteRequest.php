<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'server_id' => 'nullable|exists:servers,id',
            'cdn_id' => 'nullable|exists:cdns,id',
            'create_server' => 'sometimes|boolean',
            'create_cdn' => 'sometimes|boolean',
            'credential.login' => 'nullable|string|max:255',
            'credential.password' => 'nullable|string|max:255',
        ];
    }
}
