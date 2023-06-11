<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' =>'required|',
            'level'=>'required|' ,
            'cover' =>'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'book_header_id' => ['required' , Rule::exists('book_headers' , 'id')]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

}
