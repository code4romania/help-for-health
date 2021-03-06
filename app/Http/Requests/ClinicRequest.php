<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ClinicRequest
 * @package App\Http\Requests
 */
class ClinicRequest extends FormRequest
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
        $uniqueName = 'unique:clinics,name';
        $uniqueName .= ',' . (!empty($this->id) ? $this->id : 'NULL');
        $uniqueName .= ',id,deleted_at,NULL'; // ignore soft deleted entries

        return [
            'name' => ['required', 'string', 'min:2', 'max:128'],
            'name_english' => ['nullable', 'string', 'min:2', 'max:128'],
            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => ['required', 'exists:specialities,id'],
            'country' => ['required', 'exists:countries,id'],
            'city' => ['required', 'string', 'min:3', 'max:64'],
            'address' => ['required', 'string', 'min:5', 'max:128'],
            'phone' => ['required', 'max:18', 'min:10', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'website' => ['required', 'url', 'max:256'],
            'office_email' => ['nullable', 'email', 'min:5', 'max:64'],
            'contact_name' => ['nullable','string', 'min:2', 'max:64'],
            'contact_name_english' => ['nullable', 'string', 'min:2', 'max:64'],
            'contact_phone' => ['nullable', 'max:18', 'min:10', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'contact_email' => ['nullable','email', 'min:5', 'max:64'],
            'description' => ['nullable', 'string', 'max:20000'],
            'description_english' => ['nullable', 'string', 'max:20000'],
            'extra_details' => ['nullable', 'string', 'max:20000'],
            'extra_details_english' => ['nullable', 'string', 'max:20000'],
            'transport_details' => ['nullable', 'string', 'max:20000'],
            'transport_details_english' => ['nullable', 'string', 'max:20000'],
        ];
    }
}
