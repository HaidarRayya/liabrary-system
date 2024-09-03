<?php

namespace App\Http\Requests\BorrowRecords;

use App\Http\Controllers\EmailController;
use App\Models\BorrowRecords;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class StoreBorrowRecordsRequest extends FormRequest
{
    private $book;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->book = $this->route('book');
        return Auth::check() && Auth::user()->role == 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
    protected function passedValidation()
    {
        $borrowsRecord = BorrowRecords::where('book_id', '=', $this->book->id)->first();
        if ($borrowsRecord != null && $borrowsRecord->due_date == null ) {
            throw new HttpResponseException(response()->json(
                [
                    'status' => 'error',
                    'message' => 'لا يمكن استعارة هذا الكتاب'
                ],
                422
            ));
        }
        EmailController::borrowBook([
            "body" =>  "مرحبا " . " " . Auth::user()->name . " "  .  " تم اسعتارة الكتاب بنجاح يرجى اعادته بمدى اقصاها 14 يوم  "
        ], Auth::user()->email);
    }
}