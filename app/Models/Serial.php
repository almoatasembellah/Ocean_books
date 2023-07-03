<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Serial extends Model
{
    protected $fillable = [
        'material_code',
        'is_expired',
        'book_id'
    ];

    public function books(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
