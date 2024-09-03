<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BorrowRecords\UpdateBorrowRecordsRequest;
use App\Models\Book;
use App\Models\BorrowRecords;
use App\Services\BorrowRecordsService;
use Illuminate\Http\Request;

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
        $borrowsRecords = $this->borrowRecordsService->allBorrowRecords($book->id);
        return response()->json([
            'status' => 'success',
            'data' => [
                'borrowsRecords' => $borrowsRecords
            ]
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book)
    {
        //
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
            'status' => 'success',
            'data' => [
                'borrowsRecord' => $borrowsRecord
            ]
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     *  update the borrowsRecord of specified book 
     * @param Book $book
     * @param BorrowRecords $borrowRecord
     * @param UpdateBorrowRecordsRequest $request

     * @return response  of the status of operation : message and  borrowsRecord
     */
    public function update(UpdateBorrowRecordsRequest $request, Book $book, BorrowRecords $borrowRecord)
    {
        $borrowsRecord = $this->borrowRecordsService->updateBorrowRecord($request->all(), $borrowRecord);
        return response()->json([
            'status' => 'success',
            'message' => 'تم تحديث بنجاح',
            'data' => [
                'borrowsRecord' => $borrowsRecord
            ]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     *  delete the borrowsRecord of specified book 
     * @param Book $book
     * @param BorrowRecords $borrowRecord
     * @return response  of the status of operation : message 
     */
    public function destroy(Book $book, BorrowRecords $borrowRecord)
    {
        $this->borrowRecordsService->deleteBorrowRecord($borrowRecord);
        return response()->json([
            'status' => 'success',
            'message' => 'تم حذف بنجاح',
        ], 204);
    }
    /**
     *  delete all  borrowsRecords of specified book 
     * @param Book $book
     * @return response  of the status of operation : message 
     */
    public function destroyAll(Book $book)
    {
        $this->borrowRecordsService->deleteAllBorrowRecord($book);
        return response()->json([
            'status' => 'success',
            'message' => 'تم حذف جميع سجلات',
        ], 204);
    }
}
