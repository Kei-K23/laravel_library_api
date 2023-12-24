<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // filter
    public function scopeFilter($query, array $filters)
    {
        $filterMap = ['title', 'genre']; // allows filter keys

        $queryKey = array_keys($filters);

        if (count($queryKey) === 1) {
            if (in_array($queryKey[0], $filterMap)) {
                $query->where($queryKey[0], 'like', '%' . request($queryKey[0]) . '%');
            }
        } else {
            // filter for two query keys
            if ($this->in_arrayForArray($queryKey, $filterMap)) {
                $query->where($queryKey[0], 'like', '%' . request($queryKey[0]) . '%')
                    ->where($queryKey[1], 'like', '%' . request($queryKey[1]) . '%');
            }
        }
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    // custom method to check array value with array value
    protected function in_arrayForArray(array $arr1, array $arr2): bool
    {
        $arr = [];
        foreach ($arr2 as $check) {
            if (in_array($check, $arr1)) {
                $arr[] = $check;
            }
        }
        return count($arr) > 0;
    }
}
