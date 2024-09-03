<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Services\RatingService;

class RatingController extends Controller
{
    protected $ratingService;
    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }
    /**
     * Display a listing of the resource.
     */
    /**
     * show all book ratings
     *
     * @param Book $book
     *
     * @return response  of the status of operation :  ratings
     */
    public function index(Book $book)
    {
        $ratings = $this->ratingService->allRating($book);
        return response()->json([
            'status' => 'success',
            'data' => [
                'ratings' => $ratings
            ]
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    /**
     * show a rating
     *
     * @param Book $book
     * @param Rating $rating
     * @return response  of the status of operation :  rating
     */
    public function show(Book $book, Rating $rating)
    {
        $rating = $this->ratingService->oneRating($rating);
        return response()->json([
            'status' => 'success',
            'data' => [
                'rating' => $rating
            ]
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rating $rating)
    {
        //
    }
}

/*

*/