<?php

namespace App\RealEstate\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAppointmentRequest extends FormRequest
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
            'date' => 'required|date',
            'property' => 'required|array',
            'property.name' => 'required|string',
            'property.zip' => 'required|string',
            'agent_id' => 'required|exists:users,id',
            'office_id' => 'required|exists:offices,id',
            'contact' => 'required|array',
            'contact.name' => 'required|string',
            'contact.email' => 'required|email',
            'contact.phone' => 'required|numeric',
        ];
    }
}
