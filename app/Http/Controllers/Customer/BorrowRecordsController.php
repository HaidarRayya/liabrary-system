<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\BorrowRecords\StoreBorrowRecordsRequest;
use App\Models\Book;
use App\Models\BorrowRecords;
use App\Services\BorrowRecordsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowRecordsController extends Controller
{
    protected $borrowRecordsService;
    public function __construct(BorrowRecordsService $borrowRecordsService)
    {
        $this->borrowRecordsService = $borrowRecordsService;
    }
    /**
     * Display a listing of the resource.
     */
    /**
     *  show all borrowsRecords of specified book 
     * @param Book $book
     *
     * @return response  of the status of operation :  borrowsRecords
     */
    public function index(Book $book)
    {
        $borrowsRecords = $this->borrowRecordsService->myAllBorrowRecords($book->id, Auth::user()->id);
        return response()->json([
            'data' => [
                'borrowsRecords' => $borrowsRecords
            ]
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     *  create a new borrowsRecords of specified book 
     * @param Book $book
     * @param StoreBorrowRecordsRequest $request
     * @return response  of the status of operation :  borrowsRecord
     */
    public function store(StoreBorrowRecordsRequest $request, Book $book)
    {
        $borrowsRecord = $this->borrowRecordsService->createBorrowRecord(Auth::user()->id, $book->id);
        return response()->json([
            'message' => 'تم استعارة الكتاب بنجاح',
            'data' => [
                'borrowsRecord' => $borrowsRecord
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    /**
     *  show the borrowsRecord of specified book 
     * @param Book $book
     * @param BorrowRecords $borrowRecord
     * @return response  of the status of operation :  borrowsRecord
     */
    public function show(Book $book, BorrowRecords $borrowRecord)
    {

        $borrowsRecord = $this->borrowRecordsService->oneBorrowRecord($borrowRecord->id);
        return response()->json([
            'data' => [
                'borrowsRecord' => $borrowsRecord
            ]
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book, BorrowRecords $borrowRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book, BorrowRecords $borrowRecord)
    {
        //
    }
}
