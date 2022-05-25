<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
            'id'     =>  ['required'],
            'first_name'     =>  ['required','string','regex:/^[a-zA-Z\s]+$/','max:100'],
            'last_name'     =>  ['required','string','regex:/^[a-zA-Z\s]+$/','max:100'],
            'email'       =>  'required|email|unique:users,email,'.request()->id,
            'image'  =>  'nullable|mimes:jpeg,jpg,png',
            'password' => 'required_if:id,=,0|nullable|min:6',
	        'password_confirmation' => 'required_if:id,=,0|nullable|same:password',
        ];
    }
}
