<?php

namespace App\Http\Requests\BorrowRecords;

use App\Rules\DueDate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UpdateBorrowRecordsRequest extends FormRequest
{
    private $borrowRecord;
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        $this->borrowRecord = $this->route('borrowRecord');
        return Auth::check() && Auth::user()->role == 0;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'due_date' => ['required', 'date_format:Y-m-d H:i:s', new DueDate($this->borrowRecord)]
        ];
    }
    public function attributes(): array
    {
        return  [
            'due_date' => 'تاريخ الاعادة'
        ];
    }
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                'status' => 'error',
                'message' => "فشل التحقق يرجى التأكد من صحة القيم مدخلة",
                'errors' => $validator->errors()
            ],
            422
        ));
    }
    public function messages(): array
    {
        return  [
            'required' => 'حقل :attribute هو حقل اجباري ',
            'date_format' => 'حقل :attribute هو حقل تاريخ من الشكل سنة-شهر-يوم ساعة:دقيقة:ثانية',
        ];
    }
}
