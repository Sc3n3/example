<?php

namespace App\RealEstate\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZipInfoRequest extends FormRequest
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
            'zip' => 'required_without_all:latitude,longitude',
            'latitude' => 'required_without:zip',
            'longitude' => 'required_without:zip'
        ];
    }
}
