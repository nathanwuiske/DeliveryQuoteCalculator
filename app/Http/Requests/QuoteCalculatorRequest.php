<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteCalculatorRequest extends FormRequest
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
            "address" => [
                'required',
            ],
            "items" => [
                'required',
                'array', // input must be an array
            ],
            "items.*" => [
                'required',
                'array:name,weight' // input elements must be array containing keys name, weight
            ]
          ];
    }
}
