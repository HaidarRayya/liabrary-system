<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        'rating',
        'review',
        'book_id',
        'user_id',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUserRatings(Builder $query, $user_id, $book_id)
    {
        return $query->where('user_id', '=', $user_id)->where('book_id', '=', $book_id);
    }
}
