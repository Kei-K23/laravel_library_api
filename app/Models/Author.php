<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    // filter by author name
    public function scopeFilter($query, array $filters)
    {
        if ($filters['name'] ?? false) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
