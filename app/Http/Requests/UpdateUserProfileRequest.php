<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserProfileRequest extends FormRequest
{
    protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(
          response()->json([
            'status' => false,
            'message' => $validator->errors()->first(),
            'errors' => $validator->errors()
          ], 200)
        ); 
    }

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

        return [
            'first_name'  => 'required|string|regex:/^[a-zA-Z\s]+$/',
            'last_name' =>  'required|string|regex:/^[a-zA-Z\s]+$/',
            'email'     =>  'required|email|unique:users,email,'.\Auth::user()->id,
            'mobile'    =>  'nullable|numeric|digits:10',
            'country'   =>  'nullable|string|max:50',
            'state' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:50',
        ];
    }
}
