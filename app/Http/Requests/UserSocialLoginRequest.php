<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserSocialLoginRequest extends FormRequest
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
            'first_name'  =>  ['required','string','regex:/^[a-zA-Z\s]+$/'],
            'last_name'  =>  ['required','string','regex:/^[a-zA-Z\s]+$/'],
            'email'  =>  'required|email',
            'mobile' =>  'nullable|numeric|digits:10',
            'provider'  =>  'required|in:apple,google',
            'provider_id'  =>  'required|max:255',
            'device_token' =>  'nullable',
            // 'access_token'  =>  'required',
        ];
    }
}
