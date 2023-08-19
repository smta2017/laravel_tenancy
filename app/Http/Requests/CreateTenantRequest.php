<?php

namespace App\Http\Requests;

use App\Helpers\Helper;
use App\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateTenantRequest extends FormRequest
{
    use ResponseTrait, Helper;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        if (Helper::TestedEnv() && $this->id == "") {
            $random_time = substr(\Carbon\Carbon::now()->timestamp, -3);
            $tenant_id = \Str::random(2) . "_" . $random_time;
            // Append a parameter to the request data
            $this->merge([
                'id' => $tenant_id,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email|unique:tenants'
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator
     * @return void
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();

        $formattedErrors = [];
        foreach ($errors as $field => $messages) {
            $formattedErrors[$field] = $messages[0];
        }

        throw new HttpResponseException(
            $this->sendError('The given data was invalid.', 400, $formattedErrors)
        );
    }
}
