<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'level' => 'required',
            'cover_image' => 'required|mimes:png,gif,jpg,jpeg|max:2048',
            'pdf' => 'required|mimes:pdf',
            'video_url' => 'required|url',
            'categories' => ['required' , 'array'],
            'categories.*' => ['required' , Rule::exists('categories' , 'id')],
            'images' => ['nullable' , 'array'],
            'images.*' => 'nullable|image|mimes:png,gif,jpg,jpeg|max:2048'
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
}
