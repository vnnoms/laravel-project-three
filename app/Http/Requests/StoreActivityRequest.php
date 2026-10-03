<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'code'        => ['required', 'string', 'max:30', 'unique:activities,code'],
            'title'       => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'start_at'    => ['nullable', 'date', 'required_with:end_at'],
            'end_at'      => ['nullable', 'date', 'after_or_equal:start_at'],
            'location'    => ['nullable', 'string', 'max:150'],
            'capacity'    => ['nullable', 'integer', 'min:1', 'max:500'],
            'poster'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'poster.image'    => 'Poster harus berupa file gambar.',
            'poster.mimes'    => 'Poster harus berformat JPG, PNG, atau WEBP.',
            'poster.max'      => 'Ukuran poster maksimal 2 MB.',
            'poster.uploaded' => 'Poster gagal diunggah. Pastikan ukurannya tidak lebih dari 2 MB.',
        ];
    }
}