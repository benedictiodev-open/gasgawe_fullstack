<?php

namespace App\Http\Requests\Video;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoCustomThumbnailRequest extends FormRequest
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
            'file' => 'required|file|mimes:mp4,mov,avi|max:102400',
            'thumbnail_file'  => 'required|file|mimes:jpg,jpeg,png|max:2048',
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

            'thumbnail_file.required' => 'Thumbnail harus diunggah.',
            'thumbnail_file.file'     => 'File thumbnail tidak valid.',
            'thumbnail_file.mimes'    => 'Format thumbnail tidak valid. (Hanya jpg, jpeg, png)',
            'thumbnail_file.max'      => 'Ukuran thumbnail terlalu besar. Maksimal 2MB.',
        ];
    }
}
