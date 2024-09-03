<?php

namespace App\Http\Requests\Books;

use App\Services\BookRequestService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UpdateBookRequest extends FormRequest
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
            'title' => 'sometimes|min:3|max:255|unique:books,title',
            'author' => 'sometimes|min:3|max:255',
            'image' => 'sometimes|mimes:png,jpg',
            'descripation' => 'sometimes|min:20|max:255',
            'category' => 'sometimes|min:3|max:255',
            'published_at' => ['sometimes', 'integer', 'gte:' . $this->minDate, 'lte:' . $this->maxDate]
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
        return $this->bookRequestService->messages($this->minDate, $this->maxDate);
    }
}
