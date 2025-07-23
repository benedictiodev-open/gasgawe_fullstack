<?php

namespace App\Http\Requests\Masterdata\Badge;

use Illuminate\Foundation\Http\FormRequest;

class StoreBadgeRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'required|file|mimes:png,jpg,jpeg,gif,webp|max:2048',
            'type' => 'required|in:Applicant,Recruiter'
        ];
    }

    /**
     * Define custom messages for each validation.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function messages(): array
    {
        return [
            'image.file' => 'File image tidak valid.',
            'image.mimes' => 'Format image tidak valid.',
            'image.max' => 'Ukuran image terlalu besar (max: 2MB).',
        ];
    }
}
