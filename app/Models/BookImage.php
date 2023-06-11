<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class BookImage extends Model
{
    protected $fillable = ['path' , 'book_id'];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function getPathAttribute($value): string
    {
        return asset(Storage::url($value));
    }
}
