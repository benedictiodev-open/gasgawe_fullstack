<?php

namespace App\Http\Requests\Recruiter;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'company_name'        => ['required', 'string', 'max:250'],
            'established_date'    => ['required', 'date'],
            'province_id'         => ['required', 'integer'],
            'city_id'             => ['required', 'integer'],
            'industry_type_id'    => ['required', 'integer'],
            'bio'                 => ['required', 'string', 'max:250'],
            'employee_count'      => ['required', 'integer', 'min:1'],
            'file_profile_image'  => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
