<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'level' => $this['level'],
            'cover' => asset($this['cover']),
            'book_header_id' => $this['book_header_id'],
        ];
    }
}
