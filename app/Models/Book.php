<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'author',
        'image',
        'descripation',
        'published_at',
        'category'
    ];

    public function borrows()
    {
        return $this->hasMany(BorrowRecords::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function scopeByAuthor(Builder $query, $author)
    {
        if ($author != null)
            return $query->where('author', '=', $author);
        else
            return $query;
    }
    public function scopeByTitle(Builder $query, $title)
    {
        if ($title != null)
            return $query->where('author', 'like', "%$title%");
        else
            return $query;
    }
    public function scopeByCategory(Builder $query, $category)
    {
        if ($category != null)
            return $query->where('category', '=', $category);
        else
            return $query;
    }
}
