<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'title' => $this['title'],
            'description' => $this['description'],
            'level' => 'Level ' .  $this['level'],
            'cover_image' => asset($this['cover_image']),
            'pdf' => asset($this['pdf_path']),
            'video_url' => $this['video_url'],
            'categories' => BookCategoryResource::collection($this['categories']),
            'images' => BookImageResource::collection($this['images'])
        ];
    }
}
