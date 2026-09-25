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
            'title' => 'required|string|min:5|max:100', 
            'description' => 'required|string',
            'activity_date' => 'required|date',
            'category' => 'required|string|max:100',
            'status' => 'required|string|in:Done,On-going,Planned', 
        ];
    }
}