<?php

namespace App\Http\Requests\Currency;

use Illuminate\Foundation\Http\FormRequest;

class store extends FormRequest
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
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:255',
            'rank' => 'required|integer',
            'total_volume' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'daily_volume' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
