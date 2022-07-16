<?php

namespace App\RealEstate\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DistanceRequest extends FormRequest
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
            'from' => 'required|array',
            'from.id' => 'required_without:from.zip,from.latitude,from.longitude|exists:properties,id',
            'from.zip' => 'required_without:from.id,from.latitude,from.longitude',
            'from.latitude' => 'required_without:from.id,from.zip',
            'from.longitude' => 'required_without:from.id,from.zip',
            'to' => 'required|array',
            'to.id' => 'required_without:to.zip,to.latitude,to.longitude|exists:properties,id',
            'to.zip' => 'required_without:to.id,to.latitude,to.longitude',
            'to.latitude' => 'required_without:to.id,to.zip',
            'to.longitude' => 'required_without:to.id,to.zip'
        ];
    }
}
