<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookHeader extends Model
{

    protected $fillable = ['title'];

    public function categories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function books(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Book::class);
    }

}


