<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'level', 'cover', 'book_header_id'];

    public function bookHeader(): BelongsTo
    {
        return $this->belongsTo(BookHeader::class, 'book_header_id', 'id');
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'category_id', 'id');
    }
}
