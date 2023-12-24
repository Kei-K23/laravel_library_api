<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'status'
    ];

    public function scopeFilter($query, array $filters)
    {
        $filterMap = ['userId', 'bookId']; // allows filter keys

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
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
