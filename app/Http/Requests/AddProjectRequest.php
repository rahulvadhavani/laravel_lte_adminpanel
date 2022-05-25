<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddProjectRequest extends FormRequest
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
        // dd(request()->all());
        return [
            'user_id'   => 'required|numeric|exists:users,id',
            'title'     =>  'required|string|max:255',
            'price'    =>  'required|numeric|min:1',
            'milestone'  =>  'required|integer',
            'purchase_date'  =>  'required|date_format:Y-m-d',
            'complate_date' =>  'required|date_format:Y-m-d',
            'id' =>  'required|integer',
        ];
    }
}
