<?php

namespace App\Http\Requests\Books;

use App\Services\BookRequestService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreBookRequest extends FormRequest
{

    private $maxDate;
    private $minDate;
    protected $bookRequestService;
    public function __construct(BookRequestService $bookRequestService)
    {
        $this->bookRequestService = $bookRequestService;
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->role == 0;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $this->maxDate = now()->year;
        $this->minDate = 1700;
        return [
            'title' => 'required|min:3|max:255|unique:books,title',
            'author' => 'required|min:3|max:255',
            'image' => 'required|mimes:png,jpg',
            'descripation' => 'required|min:20|max:255',
            'category' => 'required|min:3|max:255',
            'published_at' => ['required', 'integer', 'gte:' . $this->minDate, 'lte:' . $this->maxDate]
        ];
    }

    public function attributes(): array
    {
        return  $this->bookRequestService->attributes();
    }
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->bookRequestService->failedValidation($validator);
    }
    public function messages(): array
    {
        $messages = $this->bookRequestService->messages($this->minDate, $this->maxDate);
        $messages['required'] = 'حقل :attribute هو حقل اجباري ';
        return $messages;
    }
}
