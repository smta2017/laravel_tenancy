<?php

namespace App\Http\Requests\API;

use App\Models\CaseDetailEvent;
use InfyOm\Generator\Request\APIRequest;

class UpdateCaseDetailEventAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = CaseDetailEvent::$rules;
        
        return $rules;
    }
}
