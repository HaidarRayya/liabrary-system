<?php

namespace App\Services;

use App\Http\Resources\RatingResource;
use App\Models\Book;
use App\Models\BorrowRecords;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingService
{
    /**
     * show a numbers of movies
     * @param Book $books 
     * @return RatingResource ratings :   the specified book ratings  
     * 
     */
    public function allRating($book)
    {
        $ratings = $book->ratings()->get();
        $ratings = RatingResource::collection($ratings);
        return $ratings;
    }
    /**
     * show a rating
     * @param Rating $rating 
     * @return RatingResource rating :  the specified rating 
     * 
     */
    public function oneRating($rating)
    {
        $rating = RatingResource::make($rating);
        return  $rating;
    }
    /**
     * create a new rating
     * @param array $data 
     * @param int $book_id 
     * @return RatingResource rating  
     */
    public function createRating(array $data,  $book_id)
    {
        $data['user_id'] = Auth::user()->id;
        $data['book_id'] = $book_id;
        $rating = RatingResource::make(Rating::create($data));
        return $rating;
    }
    /**
     * update a specified rating
     * @param $rating 
     * @param  array $data
     * @return RatingResource rating  
     */
    public function updateRating(array $data,  $rating)
    {
        $rating->update($data);
        $rating = RatingResource::make(Rating::find($rating->id));
        return $rating;
    }
    /**
     * delete a  specified rating
     * @param $rating 
     * 
     */

    public function deleteRating($rating)
    {
        $rating->delete();
    }
    /**
     * check if user can rating  on specified book
     * @param int $user_id 
     *  @param int book_id
     * @return bool  
     * 
     */

    public function checkAvilabelRating($user_id, $book_id): bool
    {
        $borrowRecords = BorrowRecords::userBookBorrows($user_id, $book_id)->get();
        if (count($borrowRecords) < 1) {
            $ratings = Rating::userRatings($user_id, $book_id)->get();
            return !(count($ratings) >= 1);
        } else {
            return false;
        };
    }
}
