<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class serial extends Model
{
    protected $fillable = [
        'generated_serial',
        'is_expired',
        'book_id'
    ];

    public function books(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
