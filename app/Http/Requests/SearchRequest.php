<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            'query' => [
                'required',
                'regex:/^[a-zA-Z0-9\s\-\.]+$/', // Hanya huruf, angka, spasi, tanda sambung, dan titik
            ],
        ];
    }

    public function message(){
        return[
            'query.regex' => 'Input pencarian hanya boleh mengandung huruf, angka, spasi, tanda sambung, dan titik.',
        ];
    }
}
