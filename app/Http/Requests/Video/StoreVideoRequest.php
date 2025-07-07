<?php

namespace App\Http\Requests\Video;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest
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
            'file' => 'required|file|mimes:mp4,mov,avi,|max:102400'
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
            'file.required' => 'Video harus diunggah.',
            'file.file' => 'File video tidak valid.',
            'file.mimes' => 'Format video tidak valid.',
            'file.max' => 'Ukuran video terlalu besar.',
        ];
    }
}
