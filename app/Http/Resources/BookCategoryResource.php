<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'level' => $this['level'],
            'cover' => asset($this['cover']),
            'header' => $this['bookHeader']['title'],
        ];
    }
}
