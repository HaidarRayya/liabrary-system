<?php

namespace App\Services;

use Illuminate\Http\Exceptions\HttpResponseException;

class RatingRequestService
{
    /**
     *  get array of  RatingRequestService attributes 
     *
     * @return array   of attributes
     */
    public function attributes()
    {
        return  [
            'rating' => 'التقييم',
            'review' => 'المراجعة'
        ];
    }
    /**
     *  
     * @param $validator
     *
     * throw a exception
     */
    public function failedValidation($validator)
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
    /**
     *  get array of  RatingRequestService messages 
     * @return array   of messages
     */
    public function messages()
    {
        return  [
            'required' => 'حقل :attribute هو حقل اجباري ',
            'min' => 'حقل :attribute يجب ان  يكون على الاقل 5 محارف',
            'max' => 'حقل :attribute يجب ان  يكون على الاكثر 255 محرف',
            'integer' => 'حقل :attribute هو عدد صحيح   ',
            "gte" => "حقل :attribute 1 يجب ان يكون اكبر او يساوي ",
            "lte" => "حقل :attribute 5 يجب ان يكون اصغر او يساوي "
        ];
    }
}
