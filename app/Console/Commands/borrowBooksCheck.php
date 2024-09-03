<?php

namespace App\Console\Commands;

use App\Http\Controllers\EmailController;
use App\Models\Book;
use App\Models\BorrowRecords;
use App\Models\User;
use Illuminate\Console\Command;

class borrowBooksCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:borrow-books-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    /*
    get all borrowing records are passed in case the book has been returned, 
    the record is deleted. In the event that the book has not been repeated,
    we test the current time if it is 3 days younger than the expected time for the replay,
    we send a reminder email, otherwise if the current time is greater than expected,
    we send an email to the admin to perform the appropriate operations 
     */
    public function handle()
    {

        $borrowRecords = BorrowRecords::all();

        foreach ($borrowRecords  as  $borrowRecord) {
            if ($borrowRecord->due_date != null) {
                $borrowRecord->delete();
            } else {
                $user = User::find($borrowRecord->user_id);
                $book = Book::find($borrowRecord->book_id);
                $admin = User::where('role', '=', 0)->first();
                if (now()->lessThan($borrowRecord->returned_at)) {
                    if (now()->diffInDays($borrowRecord->returned_at, true) < 3) {
                        EmailController::warningDelayBorrow([
                            "body" =>  "مرحبا " . " " . $user->name . " "  .  " يجب عليك اعادة كتاب في مدة اقصاها 3 ايام "
                        ], $user->email);
                    }
                } else {
                    if (now()->diffInDays($borrowRecord->returned_at, true) >= 3) {
                        EmailController::nowReturnBook([
                            "body" =>  "مرحبا سيادة المدير المستخدم" . " " . $user->name . " "  .  "  لم يقم باعادة الكتاب الذي استعاره" .
                                ' ' . $book->title . ' ' . 'يرجى اتخاذ التدابير المناسبة ، يجب عليك اعادة توفير الكتاب او حذفه '
                        ], $admin->email);
                    }
                }
            }
        }
    }
}
