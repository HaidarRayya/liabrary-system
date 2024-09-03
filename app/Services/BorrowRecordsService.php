<?php

namespace App\Services;

use App\Http\Resources\BorrowRecordsResource;
use App\Models\BorrowRecords;
use Carbon\Carbon;

class BorrowRecordsService
{
    /**
     * show all borrowRecords
     * @param  $book_id  
     * @return  BorrowRecordsResource $borrowRecords
     */
    public function allBorrowRecords($book_id)
    {
        $borrowRecords = BorrowRecords::bookBorrows($book_id)->get();
        $borrowRecords = BorrowRecordsResource::collection($borrowRecords);
        return  $borrowRecords;
    }
    /**
     * show all   borrowRecord for a user
     * @param  $book_id  
     * @param  $user_id  
     * @return  BorrowRecordsResource $borrowRecord
     */
    public function myAllBorrowRecords($book_id, $user_id)
    {
        $borrowRecords = BorrowRecords::userBookBorrows($book_id, $user_id)->get();
        $borrowRecords = BorrowRecordsResource::collection($borrowRecords);
        return  $borrowRecords;
    }
    /**
     * show a  borrowRecord
     * @param  $borrowRecord_id  
     * @return  BorrowRecordsResource $borrowRecord
     */
    public function oneBorrowRecord($borrowRecord_id)
    {
        $borrowRecord = BorrowRecords::find($borrowRecord_id);
        $borrowRecord = BorrowRecordsResource::make($borrowRecord);
        return  $borrowRecord;
    }
    /**
     * create a  borrowRecord
     * @param  $user_id  
     * @param  $book_id
     * @return  BorrowRecordsResource $borrowRecord
     */
    public function createBorrowRecord($user_id, $book_id)
    {

        $borrowRecord = BorrowRecords::create([
            'user_id' => $user_id,
            'book_id' => $book_id,
        ]);
        $borrowRecord = BorrowRecordsResource::make(BorrowRecords::find($borrowRecord->id));
        return  $borrowRecord;
    }
    /**
     * update a  borrowRecord
     * @param  $data  
     * @param  $borrowRecord
     * @return  BorrowRecordsResource $borrowRecord
     */

    public function updateBorrowRecord($data, $borrowRecord)
    {
        $borrowRecord->update([
            'due_date' => Carbon::create($data['due_date'])
        ]);

        return  BorrowRecordsResource::make(BorrowRecords::find($borrowRecord->id));
    }
    /**
     * delete a  borrowRecord
     * @param  $borrowRecord  
     */

    public function deleteBorrowRecord($borrowRecord)
    {
        $borrowRecord->delete();
    }

    /**
     * delete all book BorrowRecord
     * @param  $book  
     */

    public function deleteAllBorrowRecord($book)
    {
        $borrowRecord = $book->borrows();

        foreach ($borrowRecord as $br) {
            $br->delete();
        }
    }
}
