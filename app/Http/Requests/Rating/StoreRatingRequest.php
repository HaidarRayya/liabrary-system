<?php

namespace App\Http\Requests\Rating;

use App\Services\RatingRequestService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRatingRequest extends FormRequest
{
    protected $ratingRequestService;
    public function __construct(RatingRequestService $ratingRequestService)
    {
        $this->ratingRequestService = $ratingRequestService;
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role == 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function attributes(): array
    {
        return $this->ratingRequestService->attributes();
    }
    public function rules(): array
    {
        return [
            'rating' => ['required', 'gte:1', 'lte:5', 'integer'],
            'review' => ['sometimes', 'nullable', 'min:5', 'max:255'],
        ];
    }
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->ratingRequestService->failedValidation($validator);
    }
    public function messages(): array
    {
        return  $this->ratingRequestService->messages();
    }
}