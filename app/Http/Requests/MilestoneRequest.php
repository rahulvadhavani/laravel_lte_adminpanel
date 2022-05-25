<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class MilestoneRequest extends FormRequest
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
            'project_id'     =>  'required|exists:projects,id',
            'milestone.*.status'  =>  'required|integer|between:0,2',
            'milestone.*.title'        =>  'required|max:255',
            'milestone.*.description'   =>  'required|max:255',
            'milestone.*.due_date'     =>  'required|date_format:Y-m-d',
            'milestone.*.file'  =>  'required',
            'id' =>  'required',
        ];
    }
    public function messages()
    {
        // dd(request()->all());
        return [
            'milestone.*.status.required'     =>  'The milestone status field is required.',
            'milestone.*.status.between'     =>  'The milestone status is must between 0 - 2.',
            'milestone.*.title.required'     =>  'The milestone title field is required.',
            'milestone.*.title.max'     =>  'The milestone title field no more than 255 char.',
            'milestone.*.description.required'     =>  'The milestone description field is required.',
            'milestone.*.description.max'     =>  'The milestone  description field no more than 255 char.',
            'milestone.*.due_date.required'     =>  'The milestone due date field is required.',
            'milestone.*.due_date.date_format'     =>  'The milestone due date field format in yy-mm-dd.',
            'milestone.*.file.required'     =>  'The milestone file field is required.',
            'milestone.*.file.mimes'     =>  'The milestone file must be type of .fdx.',
        ];
    }
}
