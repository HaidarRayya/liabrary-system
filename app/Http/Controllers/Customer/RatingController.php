<?php

namespace App\Http\Controllers\Customer;

use App\Http\Requests\Rating\UpdateRatingRequest;
use App\Models\Rating;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\StoreRatingRequest;
use App\Models\Book;
use App\Services\RatingService;
use Illuminate\Support\Facades\Auth;

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
    /**
     * add a  new rating for specified book
     * @param StoreRatingRequest $request 
     * @param  Book $book
     * @return response  of the status of operation : message and the new rating
     */
    public function store(StoreRatingRequest $request, Book $book)
    {
        if (!$this->ratingService->checkAvilabelRating(Auth::user()->id, $book->id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'لا يمكنك تقييم هذا الكتاب'
            ], 422);
        }
        $rating = $this->ratingService->createRating($request->all(), $book->id);
        return response()->json([
            'status' => 'success',
            'message' => 'تمت اضافة تقييم بنجاح',
            'data' => [
                'rating' => $rating
            ]
        ], 201);
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
    /**
     * Update a specified  rating for specified book
     * @param UpdateRatingRequest $request 
     * @param  Book $book
     *@param  Rating $rating
     * @return response  of the status of operation : message and the new update rating
     */
    public function update(UpdateRatingRequest $request, Book $book, Rating $rating)
    {
        $rating = $this->ratingService->updateRating($request->all(), $rating);
        return response()->json([
            'status' => 'success',
            'message' => 'تم تحديث التقييم بنجاح',
            'rating' => $rating
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * delete a specified  rating for specified book
     * @param Book $book
     *@param  Rating $rating
     * @return response  of the status of operation : message 
     */
    public function destroy(Book $book, Rating $rating)
    {
        $this->ratingService->deleteRating($rating);
        return response()->json([
            'status' => 'success',
            'message' => 'تم الحذف بنجاح',
        ], 204);
    }
}
