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
            'video_url' => 'url',
            'video' => 'mimes:mp4,mov,mkv',
            'category_id' => ['nullable'],
            'category_id.*' => ['nullable' , Rule::exists('categories' , 'id')],
            'book_header_id' => 'required|integer',
            'images' => ['bail','nullable' , 'array'],
            'images.*' => 'bail|nullable|image|mimes:png,gif,jpg,jpeg|max:2048',
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
}
