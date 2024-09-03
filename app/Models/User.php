<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function books()
    {
        return $this->hasMany(Book::class);
    }
    public function borrows()
    {
        return $this->hasMany(BorrowRecords::class);
    }
    public function scopeCustomers(Builder $query)
    {
        return $query->where('role', '=', 1);
    }
    public function scopeAllBlockUsers(Builder $query)
    {
        return $query->customers()->where('status', '=', 2);
    }
    public function scopeAllUnBlockUsers(Builder $query)
    {
        return $query->customers()->where('status', '=', 1);
    }
    public function scopeCheckAvilabelDeleteUser(Builder $query, $user): bool
    {
        $borrows = $user->load('borrows');
        return  $borrows == null ? true :  false;
    }
    public function scopeUserBookBorrows($user, $book_id): bool
    {
        $borrows = $user->load('borrows', function ($query) use ($book_id) {
            $query->where('book_id', '=', $book_id);
        });
        return $borrows;
    }
}
