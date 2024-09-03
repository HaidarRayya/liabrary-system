<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BorrowRecords extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'due_date',
        'returned_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function scopeBookBorrows(Builder $query, $book_id)
    {
        return $query->where('book_id', '=', $book_id);
    }

    public function scopeUserBookBorrows(Builder $query, $book_id, $user_id)
    {
        return $query->bookBorrows($book_id)->where('user_id', '=', $user_id);
    }
}