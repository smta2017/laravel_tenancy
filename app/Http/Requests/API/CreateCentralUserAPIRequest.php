<?php

namespace App\Http\Requests\API;

use App\Models\CentralUser;
use Illuminate\Foundation\Http\FormRequest;

class CreateCentralUserAPIRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string',
        ];
    }
}
