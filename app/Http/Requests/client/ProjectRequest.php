<?php

namespace App\Http\Requests\client;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
        return [
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
            'type' => ['required', 'in:hourly,fixed'],
            'category_id' => ['required', 'exists:categories,id'],
            'budget' => ['nullable', 'numeric', 'min:0'],
        ];
    }
    
    public function messages(){
        return [
            'title.required' => 'Title is required',
        ];
    }
}
