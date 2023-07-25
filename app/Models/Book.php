<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $fillable = [
        'title',
        'description',
        'level',
        'cover_image',
        'pdf_path',
        'video_url',
        'video',
        'book_header_id',
        'category_id',
//        'serial_code'
    ];

    public function images(): HasMany
    {
        return $this->hasMany(BookImage::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class , 'book_categories' , 'book_id' , 'category_id');
    }

    public function headers(): BelongsToMany
    {
        return $this->belongsToMany(BookHeader::class , 'book_headers');
    }

    public function serialCodes()
    {
        return $this->hasMany(Serial::class, 'material_code', 'serial_code');
    }
}
