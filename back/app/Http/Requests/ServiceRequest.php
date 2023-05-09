<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:100'],
            'destiny' => ['string', 'max:255'],
            'term' => ['required', 'integer'],
            'initials' => ['string', 'max:15'],
            'priority' => ['required', 'string', 'max:50'],
        ];
    }


    public function messages(){
        return [
            'required.name' => 'O campo "Nome" é obrigatório.',
        ];
    }
}
